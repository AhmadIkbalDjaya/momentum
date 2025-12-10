# Momentum - Computer Based Test Website 🖥️

![thumbnail](docs/thumbnail.webp)

Momentum is a powerful Computer Based Test (CBT) platform that streamlines online exam administration. Built with three distinct user roles — **Admin**, **School Admin**, and **Student** — it delivers a seamless, modern testing experience with real-time monitoring and comprehensive management tools.

---

## Features ✨

### Admin

- **School Data Management:** Add, edit, and delete school data.
- **Student Data Management:** Add, edit, and delete student data.
- **School Admin Account Management:** Create and manage admin accounts for specific schools.
- **Quiz Creation:**
    - Add name, code, school category (Junior High/Senior High), quiz type (Multiple Choice, Essay, True-False).
    - Set start time, end time, and exam duration.
    - Input questions for the created quiz.
- **Quiz Recapitulation:**
    - View summary of quiz results completed by students.
- **Real-time Exam Monitoring:**
    - Monitor student online/offline status.
    - View number of answered questions and remaining time for each student.

### School Admin

- **Student & Quiz Data Management:** Similar features to the main admin, but limited to the managed school only.

### Student

- **Exam Access:**
    - Enter quiz code to start the exam.
    - Working time is limited according to admin settings.
- **Quiz History:** View list of exams taken along with result details.

---

## Tech Stack 🛠️

- **Frontend:** Livewire 3, Alpine.js, Tailwind CSS
- **Backend:** Laravel 10
- **Database:** MySQL
- **Realtime Communication:** Pusher
- **Admin Panel:** Laravel Filament
- **Deployment:** GitHub Actions

---

## Prerequisites 🛠️

Make sure you have:

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL
- Git

---

## Installation 🛠️

1.  Clone this repository:
    ```bash
    git clone https://github.com/AhmadIkbalDjaya/momentum.git
    cd momentum
    ```
2.  Install dependencies using Composer:
    ```bash
    composer install
    ```
3.  Install Node.js dependencies:
    ```bash
    npm install
    ```
4.  Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```
5.  Configure database connection in `.env`:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=username
    DB_PASSWORD=password
    ```
6.  **Realtime Communication Configuration**
    Get your Pusher API Key and Secret at [Pusher Dashboard](https://dashboard.pusher.com/apps).
    Fill in the values in `.env`:
    ```bash
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=
    PUSHER_SCHEME=
    PUSHER_APP_CLUSTER=
    ```
7.  Run database migrations:
    ```bash
    php artisan migrate --seed
    ```
    optional: Seed the database with test data:
    ```bash
    php artisan db:seed --class=DevSeeder
    ```
8.  Run the development servers:
    ```bash
    php artisan serve
    ```
    In another terminal, run:
    ```bash
    npm run dev
    ```

---

## Usage 💻

- **Admin Login:** Access data and quiz management features through the admin dashboard at `/admin`.
- **School Admin Login:** Access limited features according to school management permissions at `/admin`.
- **Student Login:** Take exams using quiz codes and view exam history on the student dashboard.

---

## Screenshots 📸

| Login                            | Home                           | Profile                              |
| -------------------------------- | ------------------------------ | ------------------------------------ |
| ![Login](docs/preview/login.png) | ![Home](docs/preview/home.png) | ![Profile](docs/preview/profile.png) |

| Quiz List                                  | Quiz Detail                                    | Quiz Work                                  |
| ------------------------------------------ | ---------------------------------------------- | ------------------------------------------ |
| ![Quiz List](docs/preview/quiz%20list.png) | ![Quiz Detail](docs/preview/quiz%20detail.png) | ![Quiz Work](docs/preview/quiz%20work.png) |

---

## Database Design 🗄️

Below is the database design for this project:

![Database Design](docs/database/dbdiagram.png)

---
