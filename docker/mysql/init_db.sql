CREATE USER admin@'%' IDENTIFIED WITH mysql_native_password BY 'dev';
GRANT ALL PRIVILEGES ON *.* TO admin@'%';
