SELECT m.*, c.name as category_name FROM movie m, category c WHERE m.category_id = c.id;

SELECT c.*, (SELECT COUNT(1) FROM movie cm WHERE cm.category_id = c.id GROUP BY cm.category_id) AS count_movie FROM category c WHERE EXISTS(SELECT 1 FROM movie m WHERE m.category_id = c.id) ORDER BY c.name;
