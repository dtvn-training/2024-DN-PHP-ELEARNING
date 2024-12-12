import sys
import os
import shutil
import random
import string
from datetime import datetime

# Set ffmpeg and ffprobe paths relative to the script
ffmpeg_bin_folder = os.path.join(os.path.dirname(__file__), "ffmpeg", "bin")
ffmpeg_path = os.path.join(ffmpeg_bin_folder, "ffmpeg.exe")
ffprobe_path = os.path.join(ffmpeg_bin_folder, "ffprobe.exe")

# Add ffmpeg to PATH
os.environ["PATH"] = f"{ffmpeg_bin_folder};" + os.environ.get("PATH", "")

# Debug PATH
print("PATH environment variable:", os.environ.get("PATH"))

# Import pydub and moviepy after setting the environment
from pydub import AudioSegment
from pydub.silence import split_on_silence
import speech_recognition as sr
import moviepy as mp
from moviepy import VideoFileClip

# Set the paths in moviepy
mp.ffmpeg_tools.ffmpeg_executable = ffmpeg_path

# Set the paths in pydub
AudioSegment.converter = ffmpeg_path
AudioSegment.ffprobe = ffprobe_path

# Print paths for debugging
print(f"MoviePy FFmpeg Path: {mp.ffmpeg_tools.ffmpeg_executable}")
print(f"Pydub FFmpeg Path: {AudioSegment.converter}")
print(f"Pydub FFprobe Path: {AudioSegment.ffprobe}")

# Initialize the speech recognizer
r = sr.Recognizer()

def generate_random_string(length=24):
    """Generate a random string of lowercase letters and digits."""
    return ''.join(random.choices(string.ascii_lowercase + string.digits, k=length))

def transcribe_audio(path):
    """Transcribe audio using Google Speech Recognition."""
    with sr.AudioFile(path) as source:
        audio_listened = r.record(source)
        text = r.recognize_google(audio_listened)
    return text

def get_large_audio_transcription_on_silence(audio_path, temp_folder):
    """Transcribe large audio files by splitting them into smaller chunks."""
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
            text = transcribe_audio(chunk_filename)
        except sr.UnknownValueError:
            text = ""
        except Exception as e:
            text = ""
            print(f"Error processing chunk {i}: {e}")
        else:
            text = f"{text.capitalize()}. "
            whole_text += text
    return whole_text

def split_video_into_chunks(video_path, chunk_duration=60, temp_folder="temp_video"):
    """Split a video into smaller chunks."""
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
            print(f"Error splitting video at {start_time}-{end_time}: {e}")
    return video_chunks

def main(video_path, output_path):
    # Generate a unique temporary folder name
    timestamp = datetime.now().strftime("%Y%m%d-%H%M%S")
    random_string = generate_random_string()
    temp_folder = os.path.join(os.path.dirname(__file__), f"{timestamp}-{random_string}")
    temp_video_folder = os.path.join(temp_folder, "temp_video")
    temp_audio_folder = os.path.join(temp_folder, "temp_audio")

    # Create directories
    os.makedirs(temp_video_folder, exist_ok=True)
    os.makedirs(temp_audio_folder, exist_ok=True)

    try:
        # Split video into 1-minute chunks
        video_chunks = split_video_into_chunks(video_path, 60, temp_video_folder)

        full_transcript = ""

        for video_chunk in video_chunks:
            # Extract audio from video chunk
            audio_filename = os.path.join(temp_audio_folder, os.path.basename(video_chunk) + ".wav")
            try:
                video = VideoFileClip(video_chunk)
                video.audio.write_audiofile(audio_filename)
                video.close()
            except Exception as e:
                print(f"Error extracting audio from {video_chunk}: {e}")
                continue

            # Transcribe the audio
            try:
                transcript = get_large_audio_transcription_on_silence(audio_filename, temp_audio_folder)
                print(transcript)
                full_transcript += transcript
            except Exception as e:
                print(f"Error transcribing audio for {audio_filename}: {e}")

        # Save the complete transcript
        with open(output_path, "w", encoding="utf-8") as f:
            f.write(full_transcript)

        # Return the folder name
        print(os.path.basename(temp_folder))

    except Exception as e:
        print(f"Unexpected error: {e}")
    finally:
        # Clean up temporary files
        try:
            if os.path.exists(temp_folder):
                shutil.rmtree(temp_folder)
        except Exception as e:
            print(f"Error cleaning up temporary files: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python generate.py <video_path> <output_path>")
        sys.exit(1)
    video_path = sys.argv[1]
    output_path = sys.argv[2]
    main(video_path, output_path)