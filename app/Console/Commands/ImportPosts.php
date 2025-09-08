<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from the output.json file into the posts table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jsonFile = 'output.json';
        $this->info("Starting data import from '{$jsonFile}'...");

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

            // Get the first user to assign as the post author.
            $user = User::first();
            if (!$user) {
                $this->error('No users found. Please create a user in your database first.');
                return Command::FAILURE;
            }

            DB::beginTransaction();
            $importedCount = 0;

            foreach ($postsData as $data) {
                // Prepare translatable fields
                $translatableTitle = [app()->getLocale() => '#' . $data['id']];
                $translatableBody = [app()->getLocale() => $data['body']];

                // Create or update the post, using the ID from the JSON as the primary key.
                // We use updateOrCreate to handle cases where we might run the command multiple times.
                Post::updateOrCreate(
                    ['id' => $data['id']],
                    [
                        'title' => $translatableTitle,
                        'slug' => strtolower(Str::slug($translatableTitle[app()->getLocale()])),
                        'body' => $translatableBody,
                        'user_id' => $user->id,
                        'published_at' => now(),
                    ]
                );

                $this->line("Imported post with ID: {$data['id']}");
                $importedCount++;
            }

            DB::commit();
            $this->info("Successfully imported {$importedCount} posts into the database.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('An error occurred during the import process.');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
