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

def transcribe_audio(path, language="en-US"):
    with sr.AudioFile(path) as source:
        audio_listened = r.record(source)
        try:
            text = r.recognize_google(audio_listened, language=language)
        except sr.UnknownValueError:
            text = ""
        except sr.RequestError as e:
            text = f"Error: {e}"
    return text

def get_large_audio_transcription_on_silence(audio_path, temp_folder, language="en-US"):
    sound = AudioSegment.from_file(audio_path)
    chunks = split_on_silence(
        sound,
        min_silence_len=500,
        silence_thresh=sound.dBFS - 14,
        keep_silence=500,
    )
    whole_text = ""
    for i, audio_chunk in enumerate(chunks, start=1):
        chunk_filename = os.path.join(temp_folder, f"chunk_{i}.wav")
        try:
            audio_chunk.export(chunk_filename, format="wav")
            text = transcribe_audio(chunk_filename, language)
        except Exception as e:
            text = ""
        else:
            text = f"{text.capitalize()}. "
            whole_text += text
    return whole_text

def split_video_into_chunks(video_path, chunk_duration=60, temp_folder="temp_video"):
    video = VideoFileClip(video_path)
    duration = int(video.duration)

    video_chunks = []
    for start_time in range(0, duration, chunk_duration):
        end_time = min(start_time + chunk_duration, duration)
        chunk_filename = os.path.join(temp_folder, f"chunk_{start_time}_{end_time}.mp4")
        try:
            video.subclipped(start_time, end_time).write_videofile(chunk_filename, codec="libx264", audio_codec="aac")
            video_chunks.append(chunk_filename)
        except Exception as e:
            pass
    return video_chunks

def process_video_chunk(video_chunk, temp_audio_folder, language="en-US"):
    """Process a single video chunk: extract audio and transcribe it."""
    audio_filename = os.path.join(temp_audio_folder, os.path.basename(video_chunk) + ".wav")
    try:
        video = VideoFileClip(video_chunk)
        video.audio.write_audiofile(audio_filename)
        video.close()
    except Exception as e:
        return ""  # Return empty string on failure
    
    try:
        transcript_text = get_large_audio_transcription_on_silence(audio_filename, temp_audio_folder, language)
    except Exception as e:
        transcript_text = ""
    
    return transcript_text  # Return the transcription text

def main(video_path, output_path, language="en-US"):
    timestamp = datetime.now().strftime("%Y%m%d-%H%M%S")
    random_string = generate_random_string()
    temp_folder = os.path.join(os.path.dirname(__file__), f"{timestamp}-{random_string}")
    temp_video_folder = os.path.join(temp_folder, "temp_video")
    temp_audio_folder = os.path.join(temp_folder, "temp_audio")

    os.makedirs(temp_video_folder, exist_ok=True)
    os.makedirs(temp_audio_folder, exist_ok=True)

    try:
        video_chunks = split_video_into_chunks(video_path, 60, temp_video_folder)

        # Use ThreadPoolExecutor to process chunks concurrently
        with ThreadPoolExecutor(max_workers=1) as executor:
            # Submit tasks and collect results from each thread
            results = list(executor.map(lambda chunk: process_video_chunk(chunk, temp_audio_folder, language), video_chunks))

        # Join the final transcript text
        final_transcript = "".join([t for t in results if t])

        # Write the final transcript to the output file
        with open(output_path, "w", encoding="utf-8") as f:
            f.write(final_transcript)

    except Exception as e:
        pass
    finally:
        try:
            if os.path.exists(temp_folder):
                shutil.rmtree(temp_folder)
        except Exception as e:
            pass

if __name__ == "__main__":
    if len(sys.argv) < 3:
        sys.exit(1)

    video_path = sys.argv[1]
    output_path = sys.argv[2]
    language = sys.argv[3] if len(sys.argv) > 3 and sys.argv[3] in SUPPORTED_LANGUAGES else "en-US"

    main(video_path, output_path, language)
