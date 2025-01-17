<?php

namespace App\Repositories;

use App\Contracts\TranscriptInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\CreateMaterialModel;


class TranscriptRepository implements TranscriptInterface
{
    protected CreateMaterialModel $createMaterialModel;
    public function __construct(CreateMaterialModel $createMaterialModel)
    {
        $this->createMaterialModel = $createMaterialModel;
    }

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
    public function generate($aid, $material_info, $language = "en-US")
    {
        set_time_limit(0);
        $course_id = $material_info['course_id'];
        $lesson_id = $material_info['lesson_id'];
        $video_name = $material_info['video_name'];

        $path = resource_path("$course_id/$lesson_id/");
        $videoPath = resource_path("$course_id/$lesson_id/$video_name");
        $pythonScriptPath = base_path('../service/generate-transcript/generate.py');

        $timestamp = now()->format('Ymd-His');
        $outputFolderName = "{$timestamp}-{$video_name}";

        $outputFolderPath = "$path/$outputFolderName";
        $outputFilePath = $outputFolderPath . DIRECTORY_SEPARATOR . 'raw_transcript.txt';

        if (!File::exists($outputFolderPath)) {
            File::makeDirectory($outputFolderPath, 0755, true);
        }

        if (!File::exists($outputFilePath)) {
            File::put($outputFilePath, '');
        }

        $command = "python \"$pythonScriptPath\" \"$videoPath\" \"$outputFilePath\" \"$language\"";

        Log::info("Executing Python command: $command");

        $output = shell_exec($command);

        if ($output === null) {
            throw new \Exception("Failed to execute Python script. No output returned.");
        }

        $transcriptContent = File::get($outputFilePath);

        return $this->createMaterialModel->createMaterial([
            'material_content' => $transcriptContent,
            'type_id' => 3,
            'lesson_id' => $lesson_id,
        ]);
    }

    public function improve($aid, $material_info)
    {
        // Implement the improve method
    }
}
