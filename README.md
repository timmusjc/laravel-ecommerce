# 🛒 Laravel E-Commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

A modern, fast, and responsive e-commerce platform built on **Laravel 11**. The project features a complete product catalog, shopping cart, admin panel, and is fully prepared for Production deployment using Docker.

## ✨ Key Features

*   **Product Catalog:** Convenient categorization, rich product pages with image galleries.
*   **Cart & Orders:** Seamless and intuitive purchasing flow for users.
*   **Admin Panel:** Full management of products, categories, orders, and users.
*   **SEO Optimization:** Automated `sitemap.xml` generation and dynamic meta tags for products.
*   **Modern Frontend:** Styled with Tailwind CSS and bundled via Vite.
*   **Security:** CSRF & XSS protection, secure password hashing, and HTTPS-ready out of the box.

---

## 💻 Local Installation (Windows & Linux)

To ensure the simplest setup without PHP or database version conflicts, we use **Docker** (Laravel Sail) for local development.

### Requirements:
*   [Docker Desktop](https://www.docker.com/products/docker-desktop/) (for Windows) or Docker Engine (for Linux).
*   [Git](https://git-scm.com/).
*   *Note: WSL2 must be enabled on Windows.*

### Step-by-Step Setup:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/timmusjc/laravel-ecommerce.git
   cd laravel-ecommerce

2. **Configure the environment file:**
    ```bash
    cp .env.example .env

3. **Install Composer dependencies (via a temporary container):**
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs

4. **Start the project containers:**
    ```bash
    ./vendor/bin/sail up -d

5. **Generate the application key and seed the database:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate --seed
    ./vendor/bin/sail artisan storage:link

6. **Build the frontend (Tailwind + Vite):**
    ```bash
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev

**Done! Your store is now available at** http://localhost

## 🚀 Production Deployment (Linux / Oracle Cloud ARM)
Below is a real-world case of deploying this application on a free **Oracle Cloud ARM server** (12GB RAM, 2 Core Ampere) using **Docker Compose and Nginx Proxy Manager (NPM).**
### Architecture:
*   **Nginx Proxy Manager:** Acts as the reverse proxy (the "gatekeeper"), accepting traffic on ports 80/443, automatically issuing SSL certificates from Let's Encrypt, and routing requests to the appropriate containers based on subdomains.
*   **Docker Compose:** An isolated environment containing Nginx, PHP-FPM, and MySQL.
### Deployment Instructions:

1. **Server Preparation**
Install Docker and Docker Compose on your Ubuntu/Debian server. Install and start the Nginx Proxy Manager container.

2. **Code delivery**
You can use git clone, or if the project was compiled locally, send the files directly via SCP:
    ```bash
    scp -i ~/.ssh/your-key.key -r ./project_folder ubuntu@your_server_ip:/home/ubuntu/sklep/

3. **Configure .env for Production**
In the project folder on the server, open .env and set up the URLs (replace with your actual domain):
    ```bash
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=[https://shop.yourdomain.com](https://shop.yourdomain.com)
    ASSET_URL=[https://shop.yourdomain.com](https://shop.yourdomain.com)

4. **Run Docker Containers**
From the project directory, execute:
    ```bash
    docker compose up -d --build

Create a symbolic link for the storage directory directly inside the container:
    ```bash
    docker compose exec app php artisan storage:link

5. **Configure Nginx Proxy Manager**
    1. **Open the NPM dashboard (usually port 81).**
    2. **Add a new Proxy Host.**
    3. **Domain Names: shop.yourdomain.com.**
    4. **Forward Hostname / IP: The internal Docker network IP (usually 172.17.0.1) or the container name.**
    5. **Forward Port: The port mapped in your docker-compose.yml (e.g., 8000).**
    6. **Go to the SSL tab, select Request a new SSL Certificate, and enable Force SSL.**

## If you liked this project or the DevOps deployment architecture, please consider giving this repository a ⭐️!
