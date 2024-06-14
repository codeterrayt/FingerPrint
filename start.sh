#!/bin/bash

# Run migrations in the background
nohup service mysql start
php artisan migrate --force &

# Start Laravel development server in the background
nohup php artisan serve --host=0.0.0.0 &

# Start queue worker in the background
php artisan queue:work --timeout=0 &

# Keep container running
tail -f /dev/null
