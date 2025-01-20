<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

use App\Contracts\MaterialInterface;

use App\Models\GetLessonIdModel;
use App\Models\MaterialListModel;
use App\Models\MaterialCreateModel;
use App\Models\MaterialModifyModel;
use App\Models\MaterialDeleteModel;

class MaterialRepository implements MaterialInterface
{
    /**
     * List materials for a specific lesson.
     *
     * @param int $lesson_id
     * @return array|null
     */
    public function list(int $lesson_id): ?array
    {
        return MaterialListModel::execute($lesson_id);
    }

    /**
     * Create a new material.
     *
     * @param array $material_data
     * @return int|null
     */
    public function create(array $material_data): ?int
    {
        return MaterialCreateModel::execute($material_data);
    }

    /**
     * Modify an existing material.
     *
     * @param array $material_data
     * @return bool|null
     */
    public function modify(array $material_data): ?bool
    {
        return MaterialModifyModel::execute($material_data);
    }

    /**
     * Delete a material.
     *
     * @param int $material_id
     * @return bool|null
     */
    public function delete(int $material_id): ?bool
    {
        return MaterialDeleteModel::execute($material_id);
    }

    /**
     * Get the file path for a material based on material ID and file name.
     *
     * @param int $material_id
     * @param string $name
     * @return string|null
     */
    public function get(int $material_id, string $name): ?string
    {
        $filePath = resource_path("materials/$material_id/$name");
        return !file_exists($filePath) ? null : $filePath;
    }

    /**
     * Upload a file (image or video) for a material and save it to the resources folder.
     *
     * @param int $material_id
     * @param UploadedFile $file
     * @return bool|null
     */
    public function set(int $material_id, UploadedFile $file): ?bool
    {
        set_time_limit(0);
        $fileName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();

        if (
            !str_starts_with($mimeType, 'image/')
            && !str_starts_with($mimeType, 'video/')
        ) {
            Log::warning("Unsupported file type: $mimeType for material_id: $material_id");
            return false;
        }

        $targetPath = resource_path("materials/$material_id");
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $isSaved = $file->move($targetPath, $fileName) ? true : false;

        $isModified = MaterialModifyModel::execute([
            'material_id' => $material_id,
            'material_content' => $fileName,
        ]);

        return $isSaved && $isModified;
    }

    public function generate(int $material_id, string $material_content): ?bool
    {
        set_time_limit(0);

        $videoPath = resource_path("materials/$material_id/$material_content");

        $baseName = pathinfo($material_content, PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd-His');
        $language = "en-US";
        $outputFolderName = "{$timestamp}-{$baseName}";

        $pythonScriptPath = base_path('../service/generate-transcript/generate.py');
        $outputFolderPath = resource_path("materials/$material_id/$outputFolderName");
        $outputFilePath = "$outputFolderPath/raw_transcript.txt";

        Log::info("$outputFilePath");

        if (!File::exists($outputFolderPath)) {
            File::makeDirectory($outputFolderPath, 0755, true);
        }

        if (!File::exists($outputFilePath)) {
            File::put($outputFilePath, '');
        }

        $command = "python \"$pythonScriptPath\" \"$videoPath\" \"$outputFilePath\" \"$language\"";

        Log::info("Executing Python command: $command");

        $output = shell_exec($command);

        if ($output) {
            $transcriptContent = file_get_contents($outputFilePath);

            return MaterialCreateModel::execute([
                'material_id' => $material_id,
                'material_content' => $transcriptContent,
                'type_id' => 3,
                'lesson_id' => GetLessonIdModel::viaMaterialId($material_id),
            ]) ? true : false;
        }

        return false;
    }

    public function improve(int $material_id, string $material_content, string $prompt): ?bool
    {
        set_time_limit(0);

        $prePrompt = "Improve the following text while maintaining the same length and depth as the original content. Avoiding any addition or omission.";
        $currentPrompt = isset($prompt) && trim($prompt) !== '' ? $prompt : $prePrompt;

        $apiKey = env('GERMINI_API_KEY');
        $geminiApiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "$currentPrompt
                        Structure the text professionally in Markdown format with h1, h2, h3.
                        Using code, qoute(> c), bold(** c **), italic(* content *) style if it's needed.
                        For code should use:
                        ```bash
                        code content 
                        ```
                        Front end render will use DOMPurify.sanitize(content, { USE_PROFILES: { html: true } }), so it's code, try to avoid code line that could be reomove by it, better use html special char like &123;
                        Avoid adding introductions, conclusions, or extra commentary.
                        Here is the text:\n\n\"{$material_content}\""]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(3600)
            ->post("$geminiApiUrl?key=$apiKey", $payload);

        if ($response->failed()) {
            throw new \Exception('Gemini API failed: ' . $response->body());
        }

        $improved_content = $response->json()['candidates'][0]['content']['parts'][0]['text'];

        if ($improved_content) {
            return MaterialModifyModel::execute([
                'material_id' => $material_id,
                'material_content' => $improved_content,
            ]) ? true : false;
        }

        return true;
    }
}
