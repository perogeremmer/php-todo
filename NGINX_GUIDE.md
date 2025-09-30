# Nginx Configuration Guide for Students

## Overview
This project uses **Nginx** as a web server with **PHP-FPM** to process PHP files. This is a modern, production-ready setup that separates web serving from PHP processing.

## Architecture
```
Browser → Nginx (Port 8080) → PHP-FPM (Port 9000) → MySQL (Port 3306)
```

## Understanding nginx.conf

Our simplified `nginx.conf` file has these main sections:

### 1. Basic Server Configuration
```nginx
server {
    listen 80;                          # Listen on port 80 (HTTP)
    server_name localhost;              # Server name
    root /var/www/html;                 # Document root directory
    index index.php index.html;        # Default files to serve
```
- **listen 80**: Nginx listens on port 80 inside the container
- **root**: Where your website files are located
- **index**: Which files to serve when accessing a directory

### 2. Main Location Block
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
- Handles all incoming requests
- First tries to serve the file directly
- If file doesn't exist, forwards to index.php (useful for routing)

### 3. PHP Processing
```nginx
location ~ \.php$ {
    try_files $uri =404;
    fastcgi_pass php:9000;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```
- **`~ \.php$`**: Matches all files ending with .php
- **fastcgi_pass php:9000**: Sends PHP requests to PHP-FPM container on port 9000
- **SCRIPT_FILENAME**: Tells PHP-FPM where the PHP file is located

### 4. Static Files
```nginx
location ~* \.(css|js|png|jpg|jpeg|gif|ico)$ {
    expires 30d;
    add_header Cache-Control "public";
}
```
- Handles CSS, JavaScript, images
- Caches files for 30 days for better performance

### 5. Security
```nginx
location ~ /\. {
    deny all;
}
```
- Blocks access to hidden files like `.env`, `.git`
- Important for security

## Why Nginx + PHP-FPM?

### Advantages:
1. **Better Performance**: Nginx is faster at serving static files
2. **Scalability**: Can handle more concurrent connections
3. **Separation of Concerns**: Web server and PHP processor are separate
4. **Industry Standard**: Most modern PHP applications use this setup

### Comparison with Apache:
- **Apache**: Web server and PHP processor in one (mod_php)
- **Nginx + PHP-FPM**: Separate web server and PHP processor

## Docker Setup

### Services:
1. **nginx**: Web server (built from Dockerfile.nginx)
2. **php**: PHP-FPM processor (built from Dockerfile)
3. **mysql**: Database
4. **phpmyadmin**: Database management tool

### Communication:
- Nginx forwards PHP requests to `php:9000`
- PHP connects to database at `mysql:3306`
- Docker networks allow containers to communicate by name

## Testing the Setup

1. **Start containers**:
   ```bash
   docker-compose up -d
   ```

2. **Test main application**:
   - Open http://localhost:8080
   - Should show the Todo List application

3. **Test static files**:
   - CSS/JS files should load properly
   - Check browser developer tools

4. **Test PHP processing**:
   - Create, edit, delete todos
   - All should work smoothly

## Common Issues for Students

### 1. "502 Bad Gateway"
- PHP-FPM container might not be running
- Check: `docker-compose ps`

### 2. CSS/JS not loading
- Check static file location block in nginx.conf
- Verify file paths are correct

### 3. Database connection errors
- Ensure MySQL container is healthy
- Check environment variables in docker-compose.yml

## Learning Exercise

Try modifying the nginx.conf:
1. Add a new location block for `/api/` requests
2. Change cache time for static files
3. Add basic authentication to a specific path

## Resources for Further Learning
- [Nginx Beginner's Guide](http://nginx.org/en/docs/beginners_guide.html)
- [PHP-FPM Documentation](https://www.php.net/manual/en/install.fpm.php)
- [Docker Compose Documentation](https://docs.docker.com/compose/)