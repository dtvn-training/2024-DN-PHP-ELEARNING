from moviepy import VideoFileClip
import sys
import speech_recognition as sr
import os
from pydub import AudioSegment
from pydub.silence import split_on_silence
from datetime import datetime
import shutil

r = sr.Recognizer()

timestamp = datetime.now().strftime("%Y%m%d-%H%M%S")
base_folder = f"output-{timestamp}"
audio_folder = os.path.join(base_folder, "audio-chunks")
video_folder = os.path.join(base_folder, "video-chunks")
os.makedirs(audio_folder, exist_ok=True)
os.makedirs(video_folder, exist_ok=True)

def transcribe_audio(path):
    with sr.AudioFile(path) as source:
        audio_listened = r.record(source)
        text = r.recognize_google(audio_listened)
    return text

def get_large_audio_transcription_on_silence(path):
    sound = AudioSegment.from_file(path)  
    chunks = split_on_silence(sound,
        min_silence_len=500,
        silence_thresh=sound.dBFS-14,
        keep_silence=500,
    )
    whole_text = ""
    for i, audio_chunk in enumerate(chunks, start=1):
        chunk_filename = os.path.join(audio_folder, f"chunk{i}.wav")
        audio_chunk.export(chunk_filename, format="wav")
        try:
            text = transcribe_audio(chunk_filename)
        except sr.UnknownValueError as e:
            print("Error:", str(e))
        else:
            text = f"{text.capitalize()}. "
            print(chunk_filename, ":", text)
            whole_text += text
    return whole_text

def split_video_into_chunks(video_path, chunk_duration=60):
    video = VideoFileClip(video_path)
    duration = int(video.duration)

    video_chunks = []
    for start_time in range(0, duration, chunk_duration):
        end_time = min(start_time + chunk_duration, duration)
        chunk_path = os.path.join(video_folder, f"chunk_{start_time}_{end_time}.mp4")
        video.subclipped(start_time, end_time).write_videofile(chunk_path, codec="libx264")
        video_chunks.append(chunk_path)
    return video_chunks

def generate_transcript_for_video(video_path):

    video_chunks = split_video_into_chunks(video_path)

    full_transcription = ""

    for video_chunk in video_chunks:
        print(f"Processing chunk: {video_chunk}")
        chunk_audio_path = os.path.join(audio_folder, f"{os.path.basename(video_chunk)}.wav")

        video = VideoFileClip(video_chunk)
        video.audio.write_audiofile(chunk_audio_path)
        
        transcription = get_large_audio_transcription_on_silence(chunk_audio_path)
        full_transcription += transcription

    return full_transcription

if __name__ == '__main__':
    video_path = sys.argv[1]

    if not os.path.exists(video_path):
        print(f"Video file not found: {video_path}")
        sys.exit(1)

    transcription = generate_transcript_for_video(video_path)
    
    print(transcription)

    try:
        shutil.rmtree(base_folder)
    except OSError as e:
        print(f"Error: {e} : {e.strerror}")
