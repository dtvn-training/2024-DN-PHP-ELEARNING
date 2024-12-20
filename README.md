# 2024-DN-PHP-ELEARNING

## Information

> Update later.

## Install

This guide will walk you through the steps to clone and set up this project.

### Prerequisites

Ensure you have the following tools installed on your machine:

- **[Git](https://git-scm.com/downloads)**: For cloning the repository.
- **[Node.js & npm](https://nodejs.org/en/download/package-manager)**: For managing frontend dependencies and running the React app.
- **[PHP](https://www.apachefriends.org/download.html)**: The backend server (Laravel) will require PHP.
- **[MySQL](https://dev.mysql.com/downloads/mysql/)**: Database server to store application data.
- **[Python](https://www.python.org/downloads/)**: For running external service.

### 1. Clone the Repository

First, clone the project repository:

```bash
git clone https://github.com/dtvn-training/2024-DN-PHP-ELEARNING.git <project_folder>
cd <project_folder>
```

Then, make sure you are on the right branch before modify source:

```bash
git checkout <branch_name>
```

### 2. Set Up the Backend (Laravel)

1. **Navigate to the root directory**

2. **Install Python dependencies**:

    ```bash
    pip install pydub speechrecognition moviepy
    ```

3. **Install PHP dependencies using Composer**:

    ```bash
    php composer.phar install --working-dir=./server
    ```

4. **Get ffmpeg:**

    ```bash
    python ./service/generate-transcript/ffmpeg_build.py
    ```

5. **Run the Laravel Development Server**:

    ```bash
    cd server
    php artisan serve
    ```

The server will be available at `http://127.0.0.1:8000`.

### 3. Set Up the Frontend (React)

1. **Navigate to the client directory**:

    ```bash
    cd client
    ```

2. **Install the required dependencies**:

    ```bash
    npm install
    ```

3. **Run the React development server**:

    ```bash
    npm run dev
    ```

The frontend should be available at `http://localhost:5173`.

> **Note:** `5173` is default port that frontend running, may different in orther comupter, run twice times, or orther conditions.

### 4. Other

Additional setup instructions and conventions will be provided in the README files located within the source directories. Please refer to these files before taking any further actions.
