# =====================================
# PHP-FPM Container Configuration
# =====================================
# 
# This Dockerfile demonstrates modern PHP containerization practices
# Perfect for GitHub Copilot to learn container-based development patterns
#
# DevOps Learning Points:
# - Multi-stage builds and base image selection
# - Package management and security updates
# - Volume mounting for development workflows
# - Health checks for container monitoring
# - Security through proper permissions
#
# @author Dosen DevOps Course
# @version 1.0

# Use official PHP-FPM image (version 8.1 for stability)
# GitHub Copilot Learning: Official images provide security updates and best practices
FROM php:8.1-fpm

# Set working directory inside container
# GitHub Copilot Learning: Consistent working directory simplifies path management
WORKDIR /var/www/html

# Install system dependencies required for PHP and applications
# GitHub Copilot Learning: Package management and cleanup for smaller images
RUN apt-get update && apt-get install -y \
    git \                    # Version control tools
    curl \                   # HTTP client for health checks
    libpng-dev \            # PNG image processing library
    libonig-dev \           # Oniguruma regex library for mbstring
    libxml2-dev \           # XML processing library
    zip \                   # Archive utilities
    unzip \                 # Archive extraction
    default-mysql-client \  # MySQL client tools for debugging
    && rm -rf /var/lib/apt/lists/*  # Clean package cache to reduce image size

# Install required PHP extensions
# GitHub Copilot Learning: PHP extension installation for database and web functionality
# pdo_mysql: MySQL database connectivity via PDO
# mbstring: Multibyte string handling (UTF-8 support)
# gd: Image manipulation library
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# TIDAK COPY file di sini - kita pakai volume mounting
# Jadi kalau mahasiswa edit code, langsung keliatan perubahannya
# tanpa perlu rebuild image

# Set permission untuk direktori (akan di-override sama volume)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Health check buat mastiin PHP-FPM jalan dengan baik
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm -t || exit 1

# Jalanin PHP-FPM di foreground
CMD ["php-fpm"]