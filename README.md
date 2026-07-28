# MIS AIMS - Beta Deployment Guide

This guide provides step-by-step instructions on how to deploy the MIS AIMS application on a XAMPP server for beta testing over your local network using the IP `192.168.3.12`.

## Prerequisites
- **XAMPP** installed (with Apache and MySQL modules running)
- **Composer** installed globally
- **Node.js** and **npm** installed

---

## Step 1: Database Setup
1. Open your XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to phpMyAdmin in your browser (usually `http://localhost/phpmyadmin`).
3. Create a new database for the system (e.g., `mis_aims`).

## Step 2: Configure Environment Variables
1. Navigate to your project folder.
2. Copy the `.env.example` file and rename the copy to `.env`.
3. Open the `.env` file in a text editor and update the following settings to match your beta environment:

   ```env
   APP_NAME="MIS AIMS"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://192.168.3.12:8000
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mis_aims
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Make sure `DB_DATABASE` matches the database you created in Step 1. Leave `DB_PASSWORD` blank if you haven't set a root password in XAMPP).*

## Step 3: Install PHP Dependencies
1. Open your terminal (or Command Prompt) as Administrator.
2. Navigate to your project folder using `cd` (e.g., `cd C:\xampp\htdocs\mis-aims`).
3. Install the required PHP packages:
   ```bash
   composer install
   ```
4. Generate the application key (this will update your `.env` file):
   ```bash
   php artisan key:generate
   ```

## Step 4: Run Migrations and Seeders
In the same terminal, run the database migrations to create the tables, and seed the initial data (like your admin account):
```bash
php artisan migrate:fresh --seed
```

## Step 5: Install NPM Dependencies & Start Vite Server
Because you are running the app across a local network for beta testing, Vite needs to be told to listen on your specific network IP.

1. Install the Node.js packages:
   ```bash
   npm install
   ```
2. Start the Vite development server on your network IP:
   ```bash
   npm run dev -- --host 192.168.3.12
   ```
   *(Keep this terminal window open. This ensures your CSS and JS assets are served properly to anyone accessing the site from another device).*

## Step 6: Serve the Application
You have two options for serving the application PHP code:

### Option A: Using PHP Artisan Serve (Recommended for Beta)
1. Open **a new, second terminal window** (leave `npm run dev` running in the first one).
2. Navigate back to your project directory.
3. Serve the application on your network IP:
   ```bash
   php artisan serve --host=192.168.3.12 --port=8000
   ```
4. **Access the app:** Anyone on the network can now visit **`http://192.168.3.12:8000`**.

### Option B: Using XAMPP Apache Directly
If you placed the project inside your XAMPP `htdocs` folder (e.g., `htdocs/mis-aims`):
1. Ensure your `APP_URL` in `.env` is set to `http://192.168.3.12/mis-aims/public`.
2. You do **not** need to run `php artisan serve`.
3. **Access the app:** Anyone on the network can visit **`http://192.168.3.12/mis-aims/public`**.
*(Note: You still need to keep the `npm run dev -- --host 192.168.3.12` terminal running in the background).*
