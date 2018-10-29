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
        $currentPageTitle = 'Détail du film';

        // Header du site web
        require_once(__DIR__.'/partials/header.php');
?>

    <main class="container">

        <h1 class="page-title">Ma movie <?= $movie['name']; ?></h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="<?= $movie['image']; ?>" alt=<?php echo $movie['name']; ?>>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <a href="<?= 'movie_single.php?id='.$movie['id']; ?>" class="btn btn-primary">Commandez</a>
                    </div>
                </div>
            </div>
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
