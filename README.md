# Task Management API

This repository contains the implementation of a Task Management API using Laravel. The API supports user authentication and allows users to create and retrieve tasks with associated notes and attachments.

## Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/sahil-dhawan-asr/techup-assignment.git
    cd task-management-api
    ```

2. **Install dependencies:**

    ```sh
    composer install
    ```

3. **Set up the environment:**

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure the `.env` file** with your database and other configurations.

5. **Run migrations:**

    ```sh
    php artisan migrate
    ```

6. **Install and configure Laravel Sanctum:**

    ```sh
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
    ```

7. **Seed the database for a test user:**
    ```sh
    php artisan db:seed
    ```

## Authentication

###

For validation form requests is used

### Register a new user

-   **Endpoint:** `POST /register`
-   **Body:**
    ```json
    {
        "name": "User Name",
        "email": "user@example.com",
        "password": "password"
    }
    ```

### Login and get a token

-   **Endpoint:** `POST /login`
-   **Body:**
    ```json
    {
        "email": "user@example.com",
        "password": "password"
    }
    ```

### Logout and revoke a token

-   **Endpoint:** `POST /logout`
-   **Header:**
    ```json
    {
        "Authorization": "Bearer your_token"
    }
    ```

## Tasks

### Create a task with notes and attachments

-   **Endpoint:** `POST /tasks`
-   **Header:**
    ```json
    {
        "Authorization": "Bearer your_token"
    }
    ```
-   **Body:**
    ```json
    {
        "subject": "Task Subject",
        "description": "Task Description",
        "start_date": "2024-06-01",
        "due_date": "2024-06-30",
        "status": "New",
        "priority": "High",
        "notes": [
            {
                "subject": "Note 1",
                "note": "Note 1 content",
                "attachments": [file1, file2]
            },
            {
                "subject": "Note 2",
                "note": "Note 2 content",
                "attachments": [file3]
            }
        ]
    }
    ```

### Retrieve all tasks with notes

-   **Endpoint:** `GET /tasks`
-   **Header:**
    ```json
    {
        "Authorization": "Bearer your_token"
    }
    ```

## Filters

You can filter tasks by status, due date, priority, and notes using query parameters:

-   `filter[status]`: Filter by task status (e.g., `New`, `Incomplete`, `Complete`)
-   `filter[due_date]`: Filter tasks due on or before a specific date (e.g., `2024-06-30`)
-   `filter[priority]`: Filter by task priority (e.g., `High`, `Medium`, `Low`)

## Sorting

Tasks are ordered by priority (`High` first) and then by the maximum count of notes.

## Test User

Execute the database seeder to create a test user:

```sh
php artisan db:seed
```

**Test User Credentials:**

-   **Email:** `admin@techuplabs.com`
-   **Password:** `12345678`

## Contact

---

Feel free to contact if you need any clarifications or further assistance.

---
