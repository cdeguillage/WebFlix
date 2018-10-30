<?php

    // Utilisateur
    $admin = false;

    // Connection à la base de données
    require_once(__DIR__.'/config/database.php');

    // BDD : On va chercher la movie sélectionnée
    if (!empty($_GET['id']))
    {
        $id_movie = intval($_GET['id']);
        $query = $db->prepare('SELECT * FROM movie WHERE id = :id_movie');
        $query->bindValue(':id_movie', $id_movie, PDO::PARAM_STR);
        $query->execute();
        $movie = $query->fetch();

        // movie introuvable - On se redirige vers la liste des movies (Erreur 404)
        if (!($movie))
        {
            // Erreur 404
            require(__DIR__.'/404.php');
        }

        // Title
        $currentPageTitle = 'Voir le film';

        // Header du site web
        require_once(__DIR__.'/partials/header.php');
?>

    <main class="container">

        <h1 class="text-primary page-title"><?= $movie['title']; ?></h1>

        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center align-center">
                                <img class=" img-size" src="<?= $movie['cover']; ?>" alt="<?php echo $movie['title']; ?>">
                            </div><!-- ./col -->
                            <div class="col">
                                <iframe src="<?php echo $movie['video_link']; ?>"
                                        style="width:640px; height:360px"
                                        frameborder=0
                                        scrolling="no"
                                        allowfullscreen>
                                    Du contenu pour les navigateurs qui ne supportent pas les iframes.
                                </iframe>
                            </div><!-- ./col -->
                        </div><!-- ./row -->

                        <h5 class="card-title text-justify">Date de sortie : <?php echo substr($movie['released_at'], 0, 10); ?></h6>
                        <h6 class="card-title text-justify"><?php echo $movie['description']; ?></h6>

                    </div><!-- ./card-body -->
                </div><!-- ./card -->
            </div><!-- ./col-md -->
        </div><!-- /.row -->
    </main><!-- /.container -->

<?php

    }  //empty(id)
    else
    {
        // Erreur 404
        require(__DIR__.'/404.php');
    }

    // Footer du site web
    require_once(__DIR__.'/partials/footer.php');
?>
