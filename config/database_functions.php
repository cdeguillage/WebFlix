<?php

// Génére la liste des catégories
function getCategory(int $id = null)
{
    global $db;

    $sql = "SELECT * FROM `category`";

    if (!empty($id))
        $sql .= " WHERE id = :id";

    $query = $db->prepare($sql);

    if (!empty($id))
        $query->bindValue(":id", $id, PDO::PARAM_STR);

    $query->execute();
    return $query->fetchAll();
}

// Génére la liste des catégories pour le filtre et pour les films enregistrés dans la BDD
function getCategoryFilter(int $id = null)
{
    global $db;

    // Récupération du filtre page et prération filtre SQL
    $filtre_query = (!empty($id)) ? "AND c.id = ".$id : "";

    // BDD : On va chercher la liste des categories
    $query = $db->query( str_replace('#FILTRE_QUERY#',
                                     $filtre_query,
                                     ' SELECT c.*,
                                            ( SELECT COUNT(1)
                                                FROM movie cm
                                                WHERE cm.category_id = c.id
                                                    AND cm.visible <> 0
                                            GROUP BY cm.category_id
                                            ) AS count_movie
                                        FROM category c
                                        WHERE EXISTS( SELECT 1
                                                        FROM movie m
                                                        WHERE m.category_id = c.id
                                                        AND m.visible <> 0
                                                    )
                                                #FILTRE_QUERY#
                                    ORDER BY c.name
                                     '
                                    ));
    return $query->fetchAll();
}

