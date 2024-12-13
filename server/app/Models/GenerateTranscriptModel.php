<?php

namespace App\Models;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class GenerateTranscriptModel
{
    /**
     * Run the Python script to generate a transcript for a given video.
     * "en-US": "English"
     * "vi-VN": "Vietnamese"
     * "es-ES": "Spanish"
     * "fr-FR": "French"
     * "de-DE": "German"
     *
     * @param string $videoPath
     * @param string $videoName
     * @param string $language
     * @return string|null
     * @throws \Exception
     */
    public static function generateTranscript($videoPath, $videoName, $language = "en-US")
    {
        $baseName = pathinfo($videoName, PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd-His');
        $outputFolderName = "{$timestamp}-{$baseName}";

        $pythonScriptPath = base_path('../service/generate-transcript/generate.py');
        $outputFolderPath = resource_path("transcripts/$outputFolderName");

        // Ensure the output folder exists
        if (!File::exists($outputFolderPath)) {
            File::makeDirectory($outputFolderPath, 0755, true);
        }

        // Ensure the raw_transcript.txt file exists (create if not)
        $outputFilePath = $outputFolderPath . DIRECTORY_SEPARATOR . 'raw_transcript.txt';
        if (!File::exists($outputFilePath)) {
            File::put($outputFilePath, '');  // Create an empty file initially if it doesn't exist
        }

        // Log the file permissions and absolute path for debugging
        Log::info("Absolute output file path: " . realpath($outputFilePath));
        Log::info("File writable: " . (is_writable($outputFilePath) ? 'Yes' : 'No'));

        // Prepare the command to execute the Python script using shell_exec
        $command = "python \"$pythonScriptPath\" \"$videoPath\" \"$outputFilePath\" \"$language\"";

        // Log the command
        Log::info("Executing Python command: $command");

        // Run the Python script and capture the output
        $output = shell_exec($command);

        // Check if there's any error message in the output
        if ($output === null) {
            throw new \Exception("Failed to execute Python script. No output returned.");
        }

        // Log the output of the Python script
        Log::info("Python script output: $output");

        Log::info("Transcript generated in file: $outputFilePath");

        return $outputFolderName;
    }
}
