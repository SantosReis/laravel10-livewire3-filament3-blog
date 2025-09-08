<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class ImportImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports images from the storage/app/itinerario folder and attaches them to posts.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sourceDirectory = storage_path('app/itinerario');
        $this->info("Starting to import images from '{$sourceDirectory}'...");

        if (!File::isDirectory($sourceDirectory)) {
            $this->error("The source directory '{$sourceDirectory}' does not exist.");
            return Command::FAILURE;
        }

        try {
            $files = File::files($sourceDirectory);
            $importedCount = 0;

            foreach ($files as $file) {
                $filename = $file->getFilename();

                // Check for the pattern [id]-name.jpg
                if (preg_match('/^(\d+)-.*?\.(jpe?g|png|gif|svg)$/i', $filename, $matches)) {
                    $postId = (int)$matches[1];

                    // Find the corresponding post
                    $post = Post::find($postId);

                    if (!$post) {
                        $this->warn("Post with ID {$postId} not found. Skipping image '{$filename}'.");
                        continue;
                    }

                    // Attach the image using Spatie Media Library
                    $post->addMedia($file->getPathname())
                         ->preservingOriginal()
                         ->toMediaCollection('posts');

                    $this->line("Attached image '{$filename}' to post ID {$postId}.");
                    $importedCount++;
                }
            }

            $this->info("Successfully imported {$importedCount} images.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('An error occurred during the import process.');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
