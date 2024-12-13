<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImproveTranscriptModel extends Model
{
    private $apiKey;
    private $geminiApiUrl;

    public function __construct()
    {
        $this->apiKey = env('GERMINI_API');
        $this->geminiApiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';
    }

    /**
     * Improve the given transcript using Gemini API.
     * 
     * @param string $transcriptPath
     * @return string Improved transcript
     * @throws \Exception
     */
    public function improveTranscript(string $transcriptPath, string $prompt): string
    {
        $rawTranscriptFile = resource_path("transcripts/{$transcriptPath}/raw_transcript.txt");

        if (!file_exists($rawTranscriptFile)) {
            throw new \Exception("Transcript file not found: $rawTranscriptFile");
        }

        $transcriptContent = file_get_contents($rawTranscriptFile);

        if (empty($transcriptContent)) {
            throw new \Exception("Transcript content is empty.");
        }
        
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "$prompt
                        Structure the text professionally in Markdown format. Avoid adding introductions, conclusions, or extra commentary.
                        Here is the text:\n\n\"{$transcriptContent}\""]
                    ]
                ]
            ]
        ];

        try {
            // Make the API call
            Log::info("Gemini API with prompt: $prompt");
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(3600)
              ->post("$this->geminiApiUrl?key=$this->apiKey", $payload);

            // Log raw response for debugging
            Log::info('Gemini API Success');

            if ($response->failed()) {
                throw new \Exception('Gemini API failed: ' . $response->body());
            }

            $responseBody = $response->json();

            // Extract the improved transcript from the response
            if (isset($responseBody['candidates'][0]['content']['parts'][0]['text'])) {
                $content = $responseBody['candidates'][0]['content']['parts'][0]['text'];
            
                $transcriptFilePath = resource_path("transcripts/{$transcriptPath}/transcript.txt");

                $directory = dirname($transcriptFilePath);

                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
            
                file_put_contents($transcriptFilePath, $content);
            
                return $content;

            } else {
                throw new \Exception('Unexpected Gemini API response structure: ' . json_encode($responseBody));
            }
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            throw new \Exception("Failed to improve transcript using Gemini API.");
        }
    }
}
