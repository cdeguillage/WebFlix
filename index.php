<?php
    // Title
    $currentPageTitle = 'Liste des films';

    // Utilisateur
    $admin = false;

    // Header du site web
    require_once(__DIR__.'/partials/header.php');

    // Récupération du filtre page et prération filtre SQL
    $filtre_query = (!empty($_GET)) ? "AND c.id = ".$_GET['filtre'] : "";

    // BDD : On va chercher la liste des categories
    $query = $db->query(str_replace('#FILTRE_QUERY#', $filtre_query, '
        SELECT c.*,
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
    '));
    $categories = $query->fetchAll();
?>

    <!-- Menu fixe / Catégories -->
    <div class="row fixed-menu">
        <div class="col-2">
            <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="index.php">Toutes catégories</a>
                        <span class="badge badge-primary badge-pill">*</span>
                    </li>
                <?php foreach($categories as $category) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="<?php echo 'index.php?filtre='.$category['id']; ?>"><?php echo $category['name']; ?></a>
                        <span class="badge badge-primary badge-pill"><?php echo $category['count_movie']; ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>


    <main class="container">
        <h1 class="text-primary page-title"><?php echo $currentPageTitle; ?></h1>
        <div class="row">
            <?php
            foreach($categories as $category) { ?>
                <div class="col-12"><div class="text-white category-title" id="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></div></div>
                <?php
                    // BDD : On va chercher la liste des movies
                    $query = $db->prepare('
                                SELECT m.*,
                                       c.name
                                  FROM `movie` m,
                                       `category` c
                                 WHERE m.category_id = c.id
                                   AND m.visible <> 0
                                   AND c.id = :category_id
                              ORDER BY c.name, m.title
                    ');
                    $query->bindValue(':category_id', $category['id'], PDO::PARAM_STR);
                    $query->execute();
                    $movies = $query->fetchAll();

                    foreach($movies as $movie) { ?>
                        <div class="col-md-2">
                            <div class="mb-4">

                                <div class="card-img-top-container card-transparance">
                                    <a href="<?= 'movie_single.php?id='.$movie['id']; ?>"><img class="card-img" src="<?php echo $movie['cover'] === NULL ? 'assets/img/cover/no-cover.png' : $movie['cover']; ?>" alt=<?php echo $movie['title']; ?>></a>
                                    <div class="camera"><i class="fas fa-video"></i></div>
                                </div>
                                
                                <div class="card-body bg-white">
                                    <h6 class="card-title text-center movie-name min-size"><?php echo $movie['title']; ?></h6>
                                    <div class="btn-block text-center">
                                        <a href="<?= 'movie_basket_add.php?id='.$movie['id']; ?>" class="btn btn-primary btn-sm" alt="Acheter"><i class="fas fa-shopping-basket"></i></a>
                                        <a href="<?= 'movie_edit.php?id='.$movie['id']; ?>" class="btn btn-primary btn-sm" alt="Editer"><i class="fas fa-edit"></i></a>
                                        <a href="<?= 'movie_delete.php?id='.$movie['id']; ?>" class="btn btn-danger btn-sm" alt="Supprimer"><i class="far fa-minus-square"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                <?php } ?>
            <?php } ?>
        </div><!-- /.row -->
    </main><!-- /.container -->

<?php
    // Footer du site web
    require_once(__DIR__.'/partials/footer.php');
?>
