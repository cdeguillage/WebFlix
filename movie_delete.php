<?php

    // Titre de la page / Utilisateur
    $currentPageTitle = "Surrpimer un film";

    // Utilisateur
    $admin = false;

    // Connection à la base de données
    require_once(__DIR__.'/config/database.php');

    // Header du site web
    require_once(__DIR__.'/partials/header.php');


    if (!empty($_GET)) {
        $id = $_GET['id'];

        // Film
        $query = $db->prepare('SELECT * FROM `movie` WHERE id = :id');
        $query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        $movie = $query->fetch();

        if ($query->rowCount() !== 0)
        {
            $query = $db->prepare('
                        UPDATE `movie`
                           SET `visible`     = 0
                         WHERE `id`          = :id
            ');
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();

            redirect('.');

        }
    }
?>


<?php
    // Footer du site web
    require_once(__DIR__.'/partials/footer.php');
?>
