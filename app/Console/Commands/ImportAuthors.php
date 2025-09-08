<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:authors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports unique authors from the output.json file into the tags table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jsonFile = 'output.json';
        $this->info("Starting author import from '{$jsonFile}'...");

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

            // Get a unique collection of authors, filtering out any null values.
            $uniqueAuthors = collect($postsData)
                ->pluck('author')
                ->filter()
                ->unique()
                ->values();

            DB::beginTransaction();
            $importedCount = 0;

            foreach ($uniqueAuthors as $authorName) {
                // Use Spatie's findOrCreateFromString method to handle unique tags.
                // This will create the tag if it doesn't exist, and return the existing one if it does.
                Tag::findOrCreateFromString($authorName);

                $this->line("Imported author tag: {$authorName}");
                $importedCount++;
            }

            DB::commit();
            $this->info("Successfully imported {$importedCount} unique authors into the database.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('An error occurred during the import process.');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
