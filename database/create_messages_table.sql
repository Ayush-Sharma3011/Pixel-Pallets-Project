-- Create messages table if it doesn't exist
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `partnership_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `partnership_id` (`partnership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add last_activity column to partnerships table if it doesn't exist
ALTER TABLE `partnerships` 
ADD COLUMN IF NOT EXISTS `last_activity` datetime DEFAULT NULL AFTER `created_at`,
ADD COLUMN IF NOT EXISTS `initial_message` text DEFAULT NULL AFTER `last_activity`;

-- Create indexes if they don't exist
ALTER TABLE `partnerships` 
ADD INDEX IF NOT EXISTS `idx_startup_id` (`startup_id`),
ADD INDEX IF NOT EXISTS `idx_corporate_id` (`corporate_id`); 