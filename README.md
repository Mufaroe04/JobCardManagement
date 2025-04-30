http://127.0.0.1:8000/

username mufaromanyama@gmail.com
password mufaromanyama
after navigating to the folder 
commands for running : php artisan serve 
# Job Card Management System

## Description

This is a web application for managing job cards. It allows users to track and manage tasks, assignments, and progress. This was created as a practice project.

## Installation and Setup Instructions

These instructions assume you have Git, PHP, and a database system (MySQL, PostgreSQL, etc.) installed on your system.

1.  **Clone the repository:**

    ```bash
    git clone [https://github.com/Mufaroe04/JobCardManagement.git](https://github.com/Mufaroe04/JobCardManagement.git)
    cd JobCardManagement
    ```

2.  **Install dependencies:**

    * **For PHP projects (Laravel, etc.):**

        ```bash
        composer install
        ```

    * **For Node.js projects (Vite, React, Vue, etc.):**

        ```bash
        npm install  # or yarn install
        ```

3.  **Set up the environment:**

    * **For Laravel:**

        ```bash
        cp .env.example .env
        php artisan key:generate
        ```

        * Open the `.env` file and configure the database connection settings. You will need to provide values for `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

    * **For other frameworks,** follow their specific environment setup instructions.

4.  **Database setup:**

    * Create a new, empty database in your database system (MySQL, PostgreSQL, etc.). The name should match the `DB_DATABASE` value in your `.env` file.
    * Import the provided database export file (`database.sql`) into your newly created database. You can use a database management tool (like phpMyAdmin, pgAdmin, Dbeaver) or the command-line client for your database system. For example, using the MySQL command-line client:

        ```bash
        mysql -u your_username -p your_database_name < database.sql
        ```

        Replace `your_username` and `your_database_name` with your actual database username and database name. You will be prompted for your database password.

    * Run the database migrations:

        ```bash
        php artisan migrate
        ```

5.  **Serve the application:**

    * **For Laravel:** Run the command below and navigate to the link

        ```bash
        php artisan serve
        ```

    * **For projects using Vite (React, Vue, etc.):**Run the command below and navigate to the link

        ```bash
        npm run dev # or yarn dev
        ```

    * **For other frameworks,** use their specific server start commands (e.g., `npm start` for many Node.js projects).

##  Using the Application

* **Login/Registration:** Users can register and log in to the system.
* **User Management:** Admin users can manage other users.
* **Job Cards:** The core functionality for managing job cards.

## Important Notes

* This application requires PHP and a database system (MySQL, PostgreSQL, etc.) installed on your system.
* The  `.env`  file contains sensitive information (like database credentials). Ensure it is configured correctly and not exposed publicly.
* The  `php artisan serve`  command is for development purposes. For production, you'll need to configure a web server like Apache or Nginx.
