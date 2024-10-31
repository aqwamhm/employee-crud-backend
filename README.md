### Backend Installation Guide

1. **Clone the Repository**

    ```bash
    git clone https://github.com/aqwamhm/employee-crud-backend
    cd employee-crud-backend
    ```

2. **Install Dependencies**

    ```bash
    composer install
    ```

3. **Environment Configuration**
   Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Then, open the `.env` file and adjust the database configuration:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<DATABASE_NAME>
    DB_USERNAME=<DATABASE_USERNAME>
    DB_PASSWORD=<DATABASE_PASSWORD>
    ```

    Run the following commands to generate the App Key and JWT secret key:

    ```bash
    php artisan key:generate
    php artisan jwt:secret
    ```

4. **Run Database Migrations**

    ```bash
    php artisan migrate
    ```

5. **Run Tests**

    ```bash
    php artisan test
    ```

6. **Run the Application**

    ```bash
    php artisan serve
    ```

    The application will run on `http://localhost:8000` by default.

7. **Generate Dummy Data**

    To generate dummy data, run the following command:

    ```bash
    php artisan migrate:fresh --seed
    ```

    This will create two user accounts:

    - **admin@example.com** with password `admin123`
    - **superadmin@example.com** with password `superadmin123`

### Frontend Setup

After setting up the backend, ensure that the frontend is also properly configured. Follow the instructions in the [frontend repository](https://github.com/aqwamhm/employee-crud-react) to clone, configure, and run the frontend application.
