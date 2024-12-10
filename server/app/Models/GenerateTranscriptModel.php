<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GenerateTranscriptModel extends Model
{
    /**
     * Process video to generate text transcription.
     *
     * @param string $videoPath
     * @param string $outputBasePath
     * @return string The transcript path
     * @throws \Exception
     */
    public function processVideoToText($videoPath, $outputBasePath, $speedFactor)
    {
        set_time_limit(0);
        
        $timestamp = now()->format('Ymd-His');
        $videoName = pathinfo($videoPath, PATHINFO_FILENAME);

        $uniqueFolderName = "{$timestamp}-{$videoName}";
        $uniqueFolder = "{$outputBasePath}/$uniqueFolderName";

        if (!mkdir($uniqueFolder, 0755, true) && !is_dir($uniqueFolder)) {
            throw new \Exception("Failed to create unique folder: {$uniqueFolder}");
        }
        
        $tempFolder = "{$uniqueFolder}/temp";
        $chunksFolder = "{$tempFolder}/chunks";

        $this->prepareDirectories([$tempFolder, $chunksFolder]);

        $audioPath = $this->extractAudio(
            $videoPath,
            $tempFolder
        );

        $preprocessedAudioPath = $this->preprocessAudio(
            $audioPath,
            "{$tempFolder}/clean_audio.wav",
            $speedFactor
        );

        $chunks = $this->splitAudioIntoChunks(
            $preprocessedAudioPath,
            $chunksFolder
        );

        file_put_contents(
            "{$uniqueFolder}/raw_transcript.txt",
            trim($this->transcribeChunks($chunks))
        );

        $this->deleteDirectory($tempFolder);

        return "transcripts/{$uniqueFolderName}";
    }

    /**
     * Prepare directories by creating them if they don't exist.
     */
    private function prepareDirectories(array $directories)
    {
        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    private function preprocessAudio($inputAudioPath, $outputAudioPath, $speedFactor)
    {
        if ($speedFactor <= 0 || $speedFactor > 2.0) {
            throw new \InvalidArgumentException("Speed factor must be between 0.5 and 2.0.");
        }

        $atempoFilter = $speedFactor <= 2.0 ? "atempo={$speedFactor}" : "atempo=2.0,atempo=" . ($speedFactor / 2);

        $command = "wsl ffmpeg -i " . escapeshellarg($this->convertToWslPath($inputAudioPath)) .
            " -af \"{$atempoFilter}\" -ar 16000 -ac 1 " . escapeshellarg($this->convertToWslPath($outputAudioPath));

        Log::info("Preprocessing Command: $command");
        exec($command . " 2>&1", $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception("Failed to preprocess audio: " . implode("\n", $output));
        }

        return $outputAudioPath;
    }

    /**
     * Extract audio from video using FFmpeg.
     */
    private function extractAudio($videoPath, $tempFolder)
    {
        $audioPath = "{$tempFolder}/audio.wav";
        $command = "wsl ffmpeg -i " . escapeshellarg($this->convertToWslPath($videoPath)) .
            " -ac 1 -ar 16000 " . escapeshellarg($this->convertToWslPath($audioPath));

        exec($command . " 2>&1", $output, $returnVar);
        Log::info("FFmpeg Command: $command");

        if ($returnVar !== 0) {
            throw new \Exception("Failed to extract audio from video.");
        }

        return $audioPath;
    }

    /**
     * Split audio into manageable chunks.
     */
    private function splitAudioIntoChunks($audioPath, $chunksFolder)
    {
        $audioPathWSL = $this->convertToWslPath($audioPath);
        $chunksFolderWSL = $this->convertToWslPath($chunksFolder);

        $durationCommand = "wsl ffprobe -i " . escapeshellarg($audioPathWSL) .
            " -show_entries format=duration -v quiet -of csv=p=0";

        Log::info("Preprocessing Command: $durationCommand");

        exec($durationCommand, $output, $returnVar);

        if ($returnVar !== 0 || empty($output)) {
            throw new \Exception("Failed to determine audio duration.");
        }

        $totalDuration = (float) $output[0];
        $chunkDuration = 60;
        $chunks = [];

        for ($start = 0; $start < $totalDuration; $start += $chunkDuration) {
            $end = min($start + $chunkDuration, $totalDuration);
            $outputChunk = "{$chunksFolder}/chunk_{$start}_{$end}.wav";
            $command = "wsl ffmpeg -i " . escapeshellarg($audioPathWSL) .
                " -ss {$start} -t " . ($end - $start) . " -c copy " .
                escapeshellarg($this->convertToWslPath($outputChunk));

            Log::info("Preprocessing Command: $command");
            exec($command . " 2>&1", $chunkOutput, $chunkReturnVar);

            if ($chunkReturnVar === 0) {
                $chunks[] = $outputChunk;
            }
        }

        return $chunks;
    }

    /**
     * Transcribe each chunk and compile results.
     */
    private function transcribeChunks(array $chunks)
    {
        $transcription = "";

        foreach ($chunks as $chunk) {
            $chunkTranscription = $this->transcribeAudio($chunk);
            if ($chunkTranscription !== false) {
                $transcription .= $chunkTranscription . " ";
            }
        }

        return trim($transcription);
    }

    /**
     * Transcribe audio using PocketSphinx.
     */
    private function transcribeAudio($audioPath)
    {
        $command = "wsl pocketsphinx_continuous -infile " .
            escapeshellarg($this->convertToWslPath($audioPath)) . " -logfn /dev/null";

        Log::info("Preprocessing Command: $command");

        exec($command . " 2>&1", $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception("Failed to transcribe audio.");
        }

        return implode(' ', array_filter($output, function ($line) {
            return !empty(trim($line)) && !preg_match('/^INFO:|^DEBUG:/', $line);
        }));
    }

    /**
     * Convert a Windows path to a WSL-compatible path.
     */
    private function convertToWslPath($path)
    {
        return str_replace(['C:\\', '\\'], ['/mnt/c/', '/'], $path);
    }

    /**
     * Delete a directory and its contents.
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $item) {
            if ($item !== '.' && $item !== '..') {
                $path = "{$dir}/{$item}";
                is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
            }
        }

        rmdir($dir);
    }
}