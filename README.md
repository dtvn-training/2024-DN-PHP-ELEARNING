# 2024-DN-PHP-ELEARNING

## Information

> Update later.

## Install

This guide will walk you through the steps to clone and set up this project.

### Prerequisites

Ensure you have the following tools installed on your machine:

- **Git**: For cloning the repository.
- **Node.js & npm**: For managing frontend dependencies and running the React app.
- **Composer**: For managing PHP dependencies.
- **PHP**: The backend server (Laravel) will require PHP.
- **MySQL**: Database server to store application data.

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

1. **Navigate to the server directory**:

    ```bash
    cd server
    ```

2. **Install PHP dependencies using Composer**:

    ```bash
    php composer.phar install
    ```

3. **Set Up Environment Variables**:

    - `.env` will be provide later.

4. **Generate the application key**:

    ```bash
    php artisan key:generate
    ```

5. **Set Up MySQL Database**:
    - Make sure your MySQL server is running.
    - Create a database using your preferred method (e.g., MySQL Workbench, CLI, or phpMyAdmin).
    - Add the database name, username, and password to the `.env` file.

6. **Run the Laravel Development Server**:

    ```bash
    php artisan serve
    ```

The server will be available at `http://127.0.0.1:8000`.

### 3. Set Up the Frontend (React)

1. **Navigate to the client directory**:

    ```bash
    cd ../client
    ```

2. **Install the required dependencies**:

    ```bash
    npm install
    ```

3. **Run the React development server**:

    ```bash
    npm run dev
    ```

The frontend should be available at `http://localhost:[PORT]`.

> Full
>
> ```bash
> cd server
> php composer.phar install
> php artisan key:generate
> cd ../client
> npm install
> ```

### 4. Other

Additional setup instructions and conventions will be provided in the README files located within the source directories. Please refer to these files before taking any further actions.
