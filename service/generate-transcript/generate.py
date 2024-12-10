import sys
import os
import warnings
from moviepy import VideoFileClip
from pydub import AudioSegment
from pydub.silence import split_on_silence
from datetime import datetime
import speech_recognition as sr
import shutil

warnings.filterwarnings("ignore", message="Couldn't find ffmpeg or avconv")

r = sr.Recognizer()

def transcribe_audio(path):
    with sr.AudioFile(path) as source:
        audio_listened = r.record(source)
        text = r.recognize_google(audio_listened)
    return text

def get_large_audio_transcription_on_silence(audio_path, temp_folder):
    sound = AudioSegment.from_file(audio_path)
    chunks = split_on_silence(sound,
        min_silence_len=500,
        silence_thresh=sound.dBFS-14,
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

def main(video_path):
    server_resource_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../server/resources/transcripts"))
    timestamp = datetime.now().strftime("%Y%m%d-%H%M%S")
    transcript_dir = os.path.join(server_resource_path, timestamp)

    os.makedirs(transcript_dir, exist_ok=True)

    temp_video_folder = os.path.join(transcript_dir, "temp_video")
    temp_audio_folder = os.path.join(transcript_dir, "temp_audio")
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
                full_transcript += transcript
            except Exception as e:
                print(f"Error transcribing audio for {audio_filename}: {e}")

        # Save the complete transcript
        transcript_file = os.path.join(transcript_dir, "transcript.txt")
        with open(transcript_file, "w", encoding="utf-8") as f:
            f.write(full_transcript)
        
        # Print relative path for integration
        relative_path = os.path.relpath(transcript_file, server_resource_path)
        print(f"transcripts/{relative_path}")

    except Exception as e:
        print(f"Unexpected error: {e}")
    finally:
        # Clean up temporary files
        try:
            if os.path.exists(temp_video_folder):
                shutil.rmtree(temp_video_folder)
            if os.path.exists(temp_audio_folder):
                shutil.rmtree(temp_audio_folder)
        except Exception as e:
            print(f"Error cleaning up temporary files: {e}")

if __name__ == "__main__":
    video_path = sys.argv[1]
    main(video_path)
