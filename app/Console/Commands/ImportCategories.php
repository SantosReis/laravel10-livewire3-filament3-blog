<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports unique categories from the output.json file into the categories table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jsonFile = 'output.json';
        $this->info("Starting category import from '{$jsonFile}'...");

        if (!Storage::disk('local')->exists($jsonFile)) {
            $this->error("The file '{$jsonFile}' was not found in the storage directory.");
            $this->warn("Please run 'php artisan process:texts' first to generate the file.");
            return Command::FAILURE;
        }

        try {
            $jsonData = Storage::disk('local')->get($jsonFile);
            $postsData = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Error decoding JSON: " . json_last_error_msg());
            }

            // Use a unique collection to avoid duplicate database queries
            $uniqueCategories = collect($postsData)->pluck('category')->filter()->unique();

            DB::beginTransaction();
            $importedCount = 0;

            foreach ($uniqueCategories as $categoryTitle) {
                // Prepare translatable fields
                $translatableTitle = [app()->getLocale() => $categoryTitle];
                $slug = Str::slug($categoryTitle);
                $translatableSlug = [app()->getLocale() => $slug];

                // Create the category if it doesn't already exist
                Category::firstOrCreate(
                    ['slug->' . app()->getLocale() => $slug],
                    [
                        'title' => $translatableTitle,
                        'slug' => $translatableSlug,
                    ]
                );

                $this->line("Imported category: {$categoryTitle}");
                $importedCount++;
            }

            DB::commit();
            $this->info("Successfully imported {$importedCount} unique categories into the database.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('An error occurred during the import process.');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
