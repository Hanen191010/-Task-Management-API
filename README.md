## Task Management API

### Overview

This project is a Task Management API built using Laravel as a framework. The API provides CRUD (Create, Read, Update, Delete) operations for tasks and users. It also implements a role-based access control system, allowing users to be either Admins, Managers, or Users, each with different privileges.

### Features

* Task Management:
    * Create new tasks
    * View list of tasks
    * View details of a specific task
    * Update a task
    * Delete a task (Soft Delete)
    * Assign a task to another user (Manager only)
* User Management:
    * Create new users
    * View list of users
    * Update user information (Admin only)
    * Delete a user (Soft Delete)
* Role-based Access Control:
    * Ability to manage tasks based on roles (Admin, Manager, User)
* Filtering:
    * Ability to filter tasks based on priority and status
* Date Handling:
    * Formatting of date fields (due_date) using Accessors and Mutators
* Soft Deletes:
    * Ability to retrieve tasks and users after deletion

### How to use the API

* Endpoints:
    * Tasks
        * `POST /tasks`: Create a new task
        * `GET /tasks`: View list of tasks
        * `GET /tasks/{id}`: View details of a specific task
        * `PUT /tasks/{id}`: Update a task
        * `DELETE /tasks/{id}`: Delete a task
        * `POST /tasks/{id}/assign`: Assign a task to a user
    * Users
        * `POST /users`: Create a new user
        * `GET /users`: View list of users
        * `GET /users/{id}`: View details of a specific user
        * `PUT /users/{id}`: Update user information
        * `DELETE /users/{id}`: Delete a user

### Requirements

* Laravel 8+
* PHP 7.3+
* MySQL or PostgreSQL
* npm (for JS file creation)

### Instructions:

1. Clone the repository:
    
    git clone https://github.com/Hanen191010/Book_library.git
    
2. Install dependencies:
    
    composer install
    
3. Create a new database:
    * Create a new database in your database server.
4. Update database credentials:
    * Open `.env` file and update the database credentials.
5. Run migrations:
    
    php artisan migrate
    
6. Run seeders:
    
    php artisan db:seed
    
7. Start the development server:
    
    php artisan serve
    
8. Access the API endpoints:
    * Use the provided Postman collection to test the API endpoints.


### Additional Information

* JSON Schema files for API endpoints will be added soon.
* More tests will be added to the API.
* More features like JWT (JSON Web Token) authentication and CORS (Cross-Origin Resource Sharing) will be added later