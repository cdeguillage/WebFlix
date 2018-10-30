ALTER TABLE `webflix`.`movie` 
ADD COLUMN `visible` TINYINT NULL DEFAULT 1 AFTER `category_id`;
