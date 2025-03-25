#!/bin/bash

# Update package lists
echo "Updating package lists..."
sudo apt update

# Install Apache, MySQL, PHP, and required PHP extensions
echo "Installing Apache, MySQL, PHP, and extensions..."
sudo apt install -y apache2 mysql-server php libapache2-mod-php php-mysql wget unzip

# Enable and start Apache and MySQL
echo "Enabling and starting Apache and MySQL services..."
sudo systemctl enable apache2
sudo systemctl start apache2
sudo systemctl enable mysql
sudo systemctl start mysql

# Set GitHub raw file URLs
GITHUB_BASE_URL="https://raw.githubusercontent.com/senakasjp/sql-xss-vlunerability/main"
INDEX_FILE="index.php"
SQL_FILE="vulnapp.sql"

# Navigate to web root
cd /var/www/html

# Backup default index.html
sudo mv index.html index.html.bak

# Download index.php
echo "Downloading index.php..."
sudo wget -O index.php "$GITHUB_BASE_URL/$INDEX_FILE"

# Download the SQL file
echo "Downloading vulnapp.sql..."
sudo wget -O vulnapp.sql "$GITHUB_BASE_URL/$SQL_FILE"

# Secure MySQL (non-interactive)
echo "Configuring MySQL root password..."
sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root'; FLUSH PRIVILEGES;"

# Import the SQL database
echo "Importing the sample database..."
mysql -u root -proot < vulnapp.sql

# Set permissions for /var/www/html
echo "Setting permissions..."
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

echo "Setup complete. Visit http://localhost to test the vulnerable app."
