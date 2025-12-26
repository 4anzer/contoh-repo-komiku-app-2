
-- Komiku minimal database schema
CREATE DATABASE IF NOT EXISTS komiku_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE komiku_db;

-- users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('user','admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- genres
CREATE TABLE genres (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) UNIQUE
) ENGINE=InnoDB;

-- comics
CREATE TABLE comics (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  synopsis TEXT,
  cover VARCHAR(255),
  status ENUM('ongoing','completed') DEFAULT 'ongoing',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- comic_genres (many-to-many)
CREATE TABLE comic_genres (
  comic_id INT,
  genre_id INT,
  PRIMARY KEY (comic_id, genre_id),
  FOREIGN KEY (comic_id) REFERENCES comics(id) ON DELETE CASCADE,
  FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- chapters
CREATE TABLE chapters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comic_id INT,
  chapter_number VARCHAR(50),
  title VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (comic_id) REFERENCES comics(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- pages (images)
CREATE TABLE pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  chapter_id INT,
  `order` INT,
  file VARCHAR(255),
  FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- bookmarks
CREATE TABLE bookmarks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  comic_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY (user_id, comic_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (comic_id) REFERENCES comics(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ratings
CREATE TABLE ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  comic_id INT,
  rating TINYINT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY (user_id, comic_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (comic_id) REFERENCES comics(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- sample admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin','admin@example.com', '$2y$10$wH1qQ6Vv1d0xq6b1F1w9xu1QK1Q9Hy1aQZ0mZJ2JQ0Z9cV1B1Y8XG', 'admin');

-- sample genre
INSERT INTO genres (name) VALUES ('Action'), ('Adventure'), ('Romance'), ('Comedy');

