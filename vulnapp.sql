
-- vulnapp.sql
CREATE DATABASE IF NOT EXISTS vulnapp;
USE vulnapp;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Sample insecure user accounts
INSERT INTO users (username, password) VALUES
('admin', 'admin123'),
('test', 'test123'),
('alice', 'alice123'),
('bob', 'bob123'),
('charlie', 'charlie123'),
('dave', 'dave123'),
('eve', 'eve123'),
('frank', 'frank123'),
('grace', 'grace123'),
('heidi', 'heidi123'),
('ivan', 'ivan123'),
('judy', 'judy123'),
('mallory', 'mallory123'),
('oscar', 'oscar123'),
('trent', 'trent123'),
('victor', 'victor123');