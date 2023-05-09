# Install project dependencies
composer install

# Create database
php bin/console doctrine:database:create

# Create migration
php bin/console make:migration

# Run migration
php bin/console doctrine:migrations:migrate

# Run data fixtures
php bin/console doctrine:fixtures:load

# Run project
php -s 127.0.0.1:8000 -t public
