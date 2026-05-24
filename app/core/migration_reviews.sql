-- Migration: Create reviews table and add unique index to user_progress
-- Date: 2026-05-24

-- 1. Create reviews table
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `roadmap_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_review` (`student_id`, `roadmap_id`),
  KEY `fk_review_roadmap` (`roadmap_id`),
  CONSTRAINT `reviews_fk_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_fk_roadmap` FOREIGN KEY (`roadmap_id`) REFERENCES `roadmaps` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Add unique index to user_progress to prevent duplicate completion records
ALTER TABLE `user_progress` ADD UNIQUE KEY `unique_progress` (`student_id`, `roadmap_id`, `step_id`);
