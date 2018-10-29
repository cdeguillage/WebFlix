<?php
    // Title
    $currentPageTitle = 'Liste des films';

    // Utilisateur
    $admin = false;

    // Header du site web
    require_once(__DIR__.'/partials/header.php');

    // BDD : On va chercher la liste des movies
    $query = $db->query('SELECT * FROM movie WHERE visible = 1 ORDER BY id DESC');
    $movies = $query->fetchAll();
?>

    <main class="container">
        <h1 class="page-title">WebFlix</h1>

        <div class="row">
            <?php
            foreach($movies as $movie) { ?>
                <div class="col-md-3">
                    <div class="mb-4">

                        <div class="card-img-top-container card-transparance">
                            <span class="card-price"><?= formatPrice($movie['price']); ?></span>
                            <img class="card-img-top card-img-top-zoom-effect" src="<?php echo $movie['image'] === NULL ? 'assets/img/movies/no-logo.png' : $movie['image']; ?>" alt=<?php echo $movie['name']; ?>>
                        </div>
                        
                        <div class="card-body bg-white card-round">
                            <h3 class="card-title movie-name"><?php echo $movie['name']; ?></h3>
                            <a href="<?= 'movie_single.php?id='.$movie['id']; ?>" class="btn btn-danger">Commandez</a>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div><!-- /.row -->
    </main><!-- /.container -->

<?php
    // Footer du site web
    require_once(__DIR__.'/partials/footer.php');
?>
