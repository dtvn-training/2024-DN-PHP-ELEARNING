import os
import shutil
import urllib.request
from pathlib import Path
import zipfile
import platform

BASE_DIR = Path(__file__).parent
FFMPEG_DIR = BASE_DIR / "ffmpeg"
FFMPEG_BIN_DIR = FFMPEG_DIR / "bin"

FFMPEG_WINDOWS_URL = "https://www.gyan.dev/ffmpeg/builds/ffmpeg-release-essentials.zip"
FFMPEG_LINUX_URL = "https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-i686-static.tar.xz"

IS_WINDOWS = platform.system() == "Windows"

def download_file(url, destination):
    print(f"Downloading FFmpeg binaries from {url}...")
    urllib.request.urlretrieve(url, destination)
    print(f"Downloaded to {destination}.")

def extract_ffmpeg_archive(archive_path, extract_to):
    print(f"Extracting FFmpeg binaries to {extract_to}...")
    if archive_path.suffix == ".zip":
        with zipfile.ZipFile(archive_path, "r") as zip_ref:
            zip_ref.extractall(extract_to)
    elif archive_path.suffix == ".xz":
        import tarfile
        with tarfile.open(archive_path, "r:xz") as tar_ref:
            tar_ref.extractall(extract_to)
    print("Extraction complete.")

def move_ffmpeg_binaries(extracted_dir):
    print("Organizing FFmpeg binaries...")
    FFMPEG_BIN_DIR.mkdir(parents=True, exist_ok=True)

    for root, _, files in os.walk(extracted_dir):
        for file in files:
            if file in ["ffmpeg.exe", "ffprobe.exe", "ffmpeg", "ffprobe"]:
                src = Path(root) / file
                dst = FFMPEG_BIN_DIR / file
                shutil.move(src, dst)
                print(f"Moved {file} to {FFMPEG_BIN_DIR}")

def cleanup_temp(archive_path, extract_to):
    print("Cleaning up temporary files...")
    if archive_path.exists():
        archive_path.unlink()
    if extract_to.exists():
        shutil.rmtree(extract_to)
    print("Cleanup complete.")

def main():
    archive_name = "ffmpeg_binaries.zip" if IS_WINDOWS else "ffmpeg_binaries.tar.xz"
    archive_path = BASE_DIR / archive_name
    extract_to = BASE_DIR / "ffmpeg_temp"

    try:
        url = FFMPEG_WINDOWS_URL if IS_WINDOWS else FFMPEG_LINUX_URL
        download_file(url, archive_path)

        extract_ffmpeg_archive(archive_path, extract_to)

        move_ffmpeg_binaries(extract_to)

        print(f"FFmpeg binaries are ready at: {FFMPEG_BIN_DIR}")

    finally:
        cleanup_temp(archive_path, extract_to)

if __name__ == "__main__":
    main()
