import sys
import os
import shutil
import random
import string
from datetime import datetime
from concurrent.futures import ThreadPoolExecutor

ffmpeg_bin_folder = os.path.join(os.path.dirname(__file__), "ffmpeg", "bin")
ffmpeg_path = os.path.join(ffmpeg_bin_folder, "ffmpeg.exe")
ffprobe_path = os.path.join(ffmpeg_bin_folder, "ffprobe.exe")

os.environ["PATH"] = f"{ffmpeg_bin_folder};" + os.environ.get("PATH", "")

from pydub import AudioSegment
from pydub.silence import split_on_silence
import speech_recognition as sr
import moviepy as mp
from moviepy import VideoFileClip

mp.ffmpeg_tools.ffmpeg_executable = ffmpeg_path
AudioSegment.converter = ffmpeg_path
AudioSegment.ffprobe = ffprobe_path

# Initialize recognizer
r = sr.Recognizer()

SUPPORTED_LANGUAGES = {
    "en-US": "English",
    "vi-VN": "Vietnamese",
    "es-ES": "Spanish",
    "fr-FR": "French",
    "de-DE": "German",
}

def generate_random_string(length=24):
    return ''.join(random.choices(string.ascii_lowercase + string.digits, k=length))

def convert_video_to_audio(video_path, audio_output_path):
    """Convert the entire video file to a single audio file."""
    try:
        video = VideoFileClip(video_path)
        video.audio.write_audiofile(audio_output_path)
        video.close()
    except Exception as e:
        raise RuntimeError(f"Error extracting audio: {e}")

def split_audio_by_duration(audio_path, chunk_duration=60_000):  # Duration in milliseconds
    """Split audio into fixed-duration chunks."""
    sound = AudioSegment.from_file(audio_path)
    chunks = [sound[i:i + chunk_duration] for i in range(0, len(sound), chunk_duration)]
    return chunks

def transcribe_audio_chunk(chunk, temp_audio_folder, chunk_index, language="en-US"):
    """Transcribe a single audio chunk."""
    chunk_filename = os.path.join(temp_audio_folder, f"chunk_{chunk_index}.wav")
    chunk.export(chunk_filename, format="wav")

    with sr.AudioFile(chunk_filename) as source:
        audio_data = r.record(source)
        try:
            text = r.recognize_google(audio_data, language=language)
        except sr.UnknownValueError:
            text = ""
        except sr.RequestError as e:
            text = f"Error: {e}"
    return text

def process_audio_chunks_in_parallel(audio_chunks, temp_audio_folder, language="en-US"):
    """Process audio chunks concurrently for transcription."""
    with ThreadPoolExecutor(max_workers=1) as executor:
        chunk_results = list(executor.map(
            lambda params: transcribe_audio_chunk(*params),
            [(chunk, temp_audio_folder, i, language) for i, chunk in enumerate(audio_chunks)]
        ))
    return "".join(chunk_results)

def main(video_path, output_path, language="en-US"):
    timestamp = datetime.now().strftime("%Y%m%d-%H%M%S")
    random_string = generate_random_string()
    temp_folder = os.path.join(os.path.dirname(__file__), f"{timestamp}-{random_string}")
    temp_audio_folder = os.path.join(temp_folder, "temp_audio")

    os.makedirs(temp_audio_folder, exist_ok=True)

    try:
        # Convert video to audio
        audio_path = os.path.join(temp_folder, "full_audio.wav")
        convert_video_to_audio(video_path, audio_path)

        # Split audio into chunks
        audio_chunks = split_audio_by_duration(audio_path, chunk_duration=60_000)

        # Process chunks in parallel
        final_transcript = process_audio_chunks_in_parallel(audio_chunks, temp_audio_folder, language)

        #  Write the final transcript to the output file
        with open(output_path, "w", encoding="utf-8") as f:
            f.write(final_transcript)

    except Exception as e:
        print(f"Error: {e}")
    finally:
        try:
            if os.path.exists(temp_folder):
                shutil.rmtree(temp_folder)
        except Exception as e:
            print(f"Cleanup Error: {e}")

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: python script.py <video_path> <output_path> [language_code]")
        sys.exit(1)

    video_path = sys.argv[1]
    output_path = sys.argv[2]
    language = sys.argv[3] if len(sys.argv) > 3 and sys.argv[3] in SUPPORTED_LANGUAGES else "en-US"

    main(video_path, output_path, language)