<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class GenerateTranscriptController extends Controller
{
    /**
     * Generate transcript from video file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateTranscript(Request $request)
    {
        // Validate the 'name' query parameter
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            // Retrieve the video name and construct the video file path
            $videoName = $request->query('name');
            $videoPath = resource_path("videos/$videoName");

            // Log the video path for tracking
            Log::info("Requested video: $videoName. Video path: $videoPath");

            // Check if the video file exists
            if (!file_exists($videoPath)) {
                Log::warning("Video file not found: $videoPath");

                return response()->json([
                    'message' => 'Video file not found.',
                ], 404);
            }

            // Specify the path to the Python script
            $pythonScriptPath = base_path('../service/generate-transcript/generate.py');

            // Log the execution of the Python script
            Log::info("Executing Python script: $pythonScriptPath");

            // Set up the process to run the Python script with the video path as an argument
            $process = new Process(['py', $pythonScriptPath, $videoPath]);
            $process->run();

            // If the process did not run successfully, log the error details
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Get the output from the Python script (the generated transcript file path)
            $transcriptFile = $process->getOutput();

            // Log the output from the Python script
            Log::info("Transcript generated: $transcriptFile");

            return response()->json([
                'message' => 'Transcript generated successfully.',
                'transcript' => $transcriptFile,
            ], 200);
        } catch (\Exception $e) {
            // Log the exception message, video name, and other relevant details for debugging
            Log::error('Transcript generation failed for video: ' . $request->query('name'));
            Log::error('Error message: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while generating the transcript.',
            ], 500);
        }
    }
}
