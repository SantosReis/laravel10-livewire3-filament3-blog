<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LinkPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attaches categories and tags (authors) to posts based on the JSON file.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jsonFile = 'output.json';
        $this->info("Starting to link posts, categories, and authors from '{$jsonFile}'...");

        if (!Storage::disk('local')->exists($jsonFile)) {
            $this->error("The file '{$jsonFile}' was not found in the storage directory.");
            return Command::FAILURE;
        }

        try {
            $jsonData = Storage::disk('local')->get($jsonFile);
            $postsData = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Error decoding JSON: " . json_last_error_msg());
            }

            DB::beginTransaction();
            $linkedCount = 0;

            foreach ($postsData as $data) {
                $postId = $data['id'];
                $post = Post::find($postId);

                if (!$post) {
                    $this->warn("Post with ID {$postId} not found. Skipping...");
                    continue;
                }

                // 1. Attach Category
                if (isset($data['category'])) {
                    // Find the category by its localized title
                    // Changed to a more direct query on the localized JSON key
                    $category = Category::where('title->' . app()->getLocale(), $data['category'])->first();
                    if ($category) {
                        // The attach() method ensures the relationship is created
                        $post->categories()->attach($category->id);
                        $this->line("Attached category '{$category->getLocalizedTitleAttribute()}' to post ID {$postId}");
                    } else {
                        $this->warn("Category '{$data['category']}' not found for post ID {$postId}.");
                    }
                }

                // 2. Attach Author (as a tag)
                if (isset($data['author'])) {
                    // The syncTags() method from Spatie's package is perfect for this.
                    // It will find the tag and attach it to the post.
                    $post->syncTags($data['author']);
                    $this->line("Attached author tag '{$data['author']}' to post ID {$postId}");
                }

                $linkedCount++;
            }

            DB::commit();
            $this->info("Successfully linked {$linkedCount} posts.");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('An error occurred during the linking process.');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
