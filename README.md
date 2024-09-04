### Panduan Instalasi Backend

1. **Clone Repository**

    ```bash
    git clone https://github.com/aqwamhm/employee-crud-backend
    cd employee-crud-backend
    ```

2. **Install Dependencies**

    ```bash
    composer install
    ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Kemudian, buka file `.env` dan sesuaikan konfigurasi database:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<NAMA_DATABASE>
    DB_USERNAME=<USERNAME_DATABASE>
    DB_PASSWORD=<PASSWORD_DATABASE>
    ```

    Jalankan perintah berikut untuk mengenerate App Key & JWT secret key:

    ```bash
    php artisan key:generate
    php artisan jwt:secret
    ```

4. **Jalankan Migrasi Database**

    ```bash
    php artisan migrate
    ```

5. **Menjalankan Pengujian**

    ```bash
    php artisan test
    ```

6. **Jalankan Aplikasi**

    ```bash
    php artisan serve
    ```

    Aplikasi akan berjalan di `http://localhost:8000` secara default.

7. **Generate Dummy Data**

    Untuk mengenerate data dummy, jalankan perintah berikut:

    ```bash
    php artisan migrate:fresh --seed
    ```

    Ini akan membuat dua akun pengguna:

    - **admin@example.com** dengan password `admin123`
    - **superadmin@example.com** dengan password `superadmin123`
