<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# License

Cloud Storage Application is a web-based file storage and management system inspired by Google Drive. It allows users to create folders, upload files, manage their data, and perform various operations such as searching, downloading, and deleting files.

This project is built using Vue.js for the frontend, Laravel for the backend, and Docker Compose for containerization. The application is hosted on Yandex Cloud, which provides cloud storage and hosting services.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation and Setup](#installation-and-setup)
- [Environment Variables](#environment-variables)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## Features

- **Creating Folders at Unlimited Depth**: Organize your files in a hierarchical structure with nested folders.
- **Uploading Files and Folders**: Upload individual files or entire folders with ease.
- **Deleting and Downloading Files**: Manage your files by deleting or downloading them as needed.
- **Searching for Files**: Quickly locate files using the search functionality.

## Technologies Used

- **Frontend**: Vue.js  
- **Backend**: Laravel (PHP Framework)  
- **Containerization**: Docker Compose  
- **Cloud Services**: Yandex Cloud (for storage and hosting)  
- **Database**: MySQL (or any database supported by Laravel)  
- **Other Tools**: Axios (for API communication), Vuex (for state management)

## Installation and Setup

### Prerequisites

Before you begin, ensure you have the following installed on your machine:

- Docker  
- Docker Compose  
- Node.js (for frontend development)  
- Composer (for Laravel dependencies)  

### Steps to Run Locally

#### Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```

#### Set Up Environment Variables

Copy the `.env.example` file to `.env` and configure it with your credentials:

```bash
cp .env.example .env
```

Update the following variables in the `.env` file:

- Database credentials  
- Yandex Cloud storage credentials  
- Application URL  

#### Build and Run Containers

Use Docker Compose to build and run the application:

```bash
docker-compose up --build
```

#### Install Dependencies

Inside the running containers, install frontend and backend dependencies:

**For the frontend (Vue.js):**

```bash
docker exec -it <frontend-container-name> npm install
```

**For the backend (Laravel):**

```bash
docker exec -it <backend-container-name> composer install
```

#### Generate Application Key

Generate the Laravel application key:

```bash
docker exec -it <backend-container-name> php artisan key:generate
```

#### Run Migrations

Apply database migrations:

```bash
docker exec -it <backend-container-name> php artisan migrate
```

#### Access the Application

Open your browser and navigate to `http://localhost`.

## Environment Variables

The `.env` file contains the following critical variables:

- `APP_URL`: Base URL of the application  
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Database configuration  
- `YANDEX_CLOUD_BUCKET`, `YANDEX_CLOUD_ACCESS_KEY`, `YANDEX_CLOUD_SECRET_KEY`: Yandex Cloud storage credentials
