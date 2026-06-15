-- ============================================================
-- Lamico Group — Database Setup
-- Run this ONCE in cPanel > phpMyAdmin
-- ============================================================

CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(255) NOT NULL,
  `slug`        VARCHAR(255) NOT NULL UNIQUE,
  `icon`        VARCHAR(10)  NOT NULL DEFAULT '🏢',
  `short_desc`  TEXT,
  `full_desc`   TEXT,
  `order_num`   INT DEFAULT 0,
  `active`      TINYINT(1) DEFAULT 1,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `filename`    VARCHAR(255) NOT NULL,
  `caption`     VARCHAR(255),
  `category`    VARCHAR(100) NOT NULL DEFAULT 'general',
  `service_id`  INT,
  `active`      TINYINT(1) DEFAULT 1,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(255) NOT NULL,
  `client_role` VARCHAR(255),
  `company`     VARCHAR(255),
  `message`     TEXT NOT NULL,
  `rating`      TINYINT DEFAULT 5,
  `service_id`  INT,
  `active`      TINYINT(1) DEFAULT 1,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `bookings` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(255) NOT NULL,
  `email`       VARCHAR(255) NOT NULL,
  `phone`       VARCHAR(50),
  `service`     VARCHAR(255),
  `date`        DATE,
  `message`     TEXT,
  `status`      ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `contacts` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(255) NOT NULL,
  `email`       VARCHAR(255) NOT NULL,
  `phone`       VARCHAR(50),
  `subject`     VARCHAR(255),
  `message`     TEXT NOT NULL,
  `read_at`     TIMESTAMP NULL,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─── Seed default services ────────────────────────────────
INSERT INTO `services` (`name`, `slug`, `icon`, `short_desc`, `full_desc`, `order_num`) VALUES
('Gold-Stone Constructions',         'construction', '🏗️', 'Civil engineering, estate development, and infrastructure solutions tailored for modern Nigeria.',     'We specialize in delivering high-quality construction projects across Nigeria — from residential estates and commercial buildings to roads, bridges, and public infrastructure. Our team of engineers, architects, and project managers ensures every project meets international standards while reflecting local needs.',        1),
('Gold Dust Press',                  'media',        '📰', 'Full-scale publishing, creative design, and brand amplification through visual and editorial content.', 'Gold Dust Press is our media and publishing arm. We handle everything from corporate branding and graphic design to magazine publishing, book production, and digital content creation. Whether you need a campaign, a corporate profile, or a full editorial project, we deliver with precision and creativity.',         2),
('Rashtech Global Solutions Network','ict',          '💻', 'Scalable software, data-driven platforms, and governance tools for public and private sectors.',       'Rashtech builds technology that works for Africa. We develop custom software solutions, enterprise platforms, e-government tools, and data analytics systems. Our clients range from government agencies to private enterprises seeking digital transformation and competitive advantage through technology.',            3),
('Lamico Interbiz Resources',        'commerce',     '🌍', 'The engine room of trade and logistics — facilitating domestic and international commerce.',           'Lamico Interbiz manages our trade, enterprise, and logistics operations. We connect businesses to local and international markets, provide supply chain solutions, and handle import/export logistics. Our network spans multiple African countries, enabling seamless cross-border commerce for our partners.',        4);

-- ─── Seed default testimonials ────────────────────────────
INSERT INTO `testimonials` (`client_name`, `client_role`, `company`, `message`, `rating`) VALUES
('David Johnson',  'Operations Director', 'LogiCorp Africa',   'Lamico Group transformed our logistics capabilities completely. Their team is professional, innovative, and genuinely cares about results.', 5),
('Emily Carter',   'CEO',                 'Prestige Realty',   'Working with Lamico on our real estate project was seamless from start to finish. Their attention to detail and customer focus is unmatched.',   5),
('Chukwuemeka A.', 'CTO',                 'NigeriaGovTech',    'Rashtech delivered our governance platform on time and within budget. The quality of their work and their technical depth impressed us greatly.', 5);
