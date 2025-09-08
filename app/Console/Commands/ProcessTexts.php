<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProcessTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * The signature defines the command name and any arguments or options.
     * We'll use a simple signature without arguments for this task.
     *
     * @var string
     */
    protected $signature = 'process:texts';

    /**
     * The console command description.
     *
     * This description is shown when a user runs "php artisan list".
     *
     * @var string
     */
    protected $description = 'Reads text files from a directory and converts them to a single JSON file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * This is the main method where the command's logic is executed.
     *
     * @return int
     */
    public function handle()
    {
        // Define the source directory for the text files relative to the storage path.
        // Make sure this directory exists and is writable.
        $sourceDirectory = 'itinerario';

        // Define the output JSON file path relative to the storage path.
        $outputFile = 'output.json';

        $this->info("Starting the file processing. Looking for files in the '{$sourceDirectory}' directory.");

        // Check if the source directory exists in the storage path.
        if (!Storage::exists($sourceDirectory)) {
            $this->error("The source directory '{$sourceDirectory}' does not exist in the storage disk.");
            $this->error("Please create a '{$sourceDirectory}' folder inside the 'storage/app' directory and add your text files.");
            return Command::FAILURE;
        }

        // Get all files from the source directory.
        $files = Storage::files($sourceDirectory);
        $processedData = [];

        if (empty($files)) {
            $this->warn("No text files found in the '{$sourceDirectory}' directory. The JSON file will be empty.");
        }

        foreach ($files as $filePath) {
            // Check if the file has a .txt extension.
            if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) !== 'txt') {
                $this->line("Skipping non-text file: {$filePath}");
                continue;
            }

            $this->line("Processing file: {$filePath}");

            // Extract the file name (e.g., "1.txt").
            $fileName = basename($filePath);

            // Extract the ID from the file name (e.g., "1").
            $id = pathinfo($fileName, PATHINFO_FILENAME);

            // Read the full content of the file.
            $content = Storage::get($filePath);

            // Check if the file is empty.
            if (empty(trim($content))) {
                $this->warn("Skipping empty file: {$fileName}");
                continue;
            }

            // Split the content into an array of lines.
            $lines = explode("\n", $content);

            // Get the last line which contains the category and author.
            $lastLine = trim(array_pop($lines));

            $category = '';
            $author = null;

            // Remove "No livro " from the beginning of the line.
            $category = preg_replace('/^No livro /', '', $lastLine);

            // Check for the author prefix " de " and split the string.
            $parts = explode(' de ', $category);
            if (count($parts) > 1) {
                // The last part is the author's name.
                $author = array_pop($parts);
                // The remaining parts form the category.
                $category = implode(' de ', $parts);
            }

            // Remove any trailing comma and whitespace from the category.
            $category = rtrim($category, ', ');

            // Join the remaining lines to form the body, preserving original line breaks.
            $body = trim(implode("\n", $lines));

            // Create an associative array for this file's data.
            $processedData[] = [
                'id' => $id,
                'body' => $body,
                'category' => $category,
                'author' => $author,
            ];
        }

        // Sort the data array by the 'id' numerically.
        usort($processedData, function($a, $b) {
            return intval($a['id']) <=> intval($b['id']);
        });

        // Convert the processed data array to a JSON string with pretty printing.
        $jsonData = json_encode($processedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        // Save the JSON data to the output file in the storage directory.
        Storage::put($outputFile, $jsonData);

        $this->info("Successfully converted " . count($processedData) . " files to '{$outputFile}'.");
        $this->info("You can find the output file at: storage/app/{$outputFile}");

        return Command::SUCCESS;
    }
}
