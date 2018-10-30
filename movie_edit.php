<?php

    // Titre de la page / Utilisateur
    $currentPageTitle = "Modifier un film";

    // Utilisateur
    $admin = false;

    // Connection à la base de données
    require_once(__DIR__.'/config/database.php');

    // Header du site web
    require_once(__DIR__.'/partials/header.php');

    // Traitement du formulaire
    $title = $description = $video_link = $cover = $released_at = $category = $category_id = null;

    // Liste des catégories
    $query = $db->prepare('SELECT * FROM `category`');
    $query->execute();
    $category_array = $query->fetchAll();

    // Insertion dans la BDD
    if (!empty($_POST)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $video_link = $_POST['video_link'];
        $cover = $_FILES['cover'];
        $released_at = $_POST['released_at'];
        $category_id = $_POST['category_id'];

        // Pour la gestion des erreurs
        $errors = [];

        // Vérifier le nom
        if (empty($title))
        {
            $errors['title'] = 'Le titre n\'est pas valide';
        }

        // Vérifier la description
        if (strlen($description) < 10)
        {
            $errors['description'] = 'La description n\'est pas valide';
        }

        // Vérifier le lien de la video
        if (strlen($video_link) < 10)
        {
            $errors['video_link'] = 'Le lien vers la video n\'est pas valide';
        }
        // Vérifier la catégorie
        $query = $db->prepare('SELECT * FROM `category` WHERE `id` = :category_id');
        $query->bindValue(':category_id', $category_id, PDO::PARAM_STR);
        $query->execute();
        $category_query = $query->fetch();

        if (empty($category_id) || !in_array($category_id, $category_query))
        {
            $errors['category_id'] = 'La catégorie n\'est pas valide';
        }

        // Upload de le la pochette
        $file = $cover['tmp_name']; // Emplacement du fichier temporaire
        $fileName = "assets/img/cover/".$cover['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);   // Permet d'ouvrir un fichier
        $mimeType = finfo_file($finfo, $file);
        $allowedExtensions = ['image/jpg', 'image/jpeg', 'image/png'];
        // Si l'extension n'est pas autorisée, il y a une erreur
        if (!in_array($mimeType, $allowedExtensions))
        {
            $errors['cover'] = 'Ce type de fichier n\'est pas autorisé';
        }

        // On vérifie la taille de le la pochette (en Ko) - 3Mo maxi
        if ($cover['size'] / 1024 > 3096)
        {
            $errors['size'] = 'La pochette est trop lourde';
        }

        // On télécharge
        if (!isset($errors['cover']))
        {
                // On déplace le fichier uploadé où on le souhaite
                move_uploaded_file($file, __DIR__."/".$fileName);
        }

        // Aucune erreur dans le formulaire - On insère
        if (empty($errors)) {
            $query = $db->prepare('
                        INSERT INTO movie (`title`, `description`, `video_link`, `cover`, `released_at`, `category_id`) VALUES (:title, :description, :video_link, :cover, :released_at, :category_id)
            ');
            $query->bindValue(':title', $title, PDO::PARAM_STR);
            $query->bindValue(':description', $description, PDO::PARAM_STR);
            $query->bindValue(':video_link', $video_link, PDO::PARAM_STR);
            $query->bindValue(':cover', $fileName, PDO::PARAM_STR);
            $query->bindValue(':released_at', $released_at, PDO::PARAM_STR);
            $query->bindValue(':category_id', $category_id, PDO::PARAM_STR);
            
            if ($query->execute()) {
                $primary = true;
                // Envoyer un mail ?
                // Logger la création du film
            }

        }

    }

?>
    <main class="container">

        <h1 class="text-primary page-title-adm"><?= $currentPageTitle ?></h1>

        <?php if (isset($primary) && $primary) { ?>
            <div class="alert alert-primary alert-dismissible fade show">
                Le film <strong><?php echo $title; ?></strong> a bien été ajouté avec l'id <strong><?php echo $db->lastInsertId(); ?></strong> !
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class='card-body bg-white'>
                <div class="row">
                    <!-- Colonne 1 -->
                    <div class="col">
                        <div class="form-group p-3">
                            <label for="title">Titre :</label>
                            <input type="text" name="title" id="title" class="form-control <?php echo isset($errors['title']) ? 'is-invalid' : null; ?>" value="<?php echo $title; ?>">
                            <?php if (isset($errors['title'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['title'];
                                echo '</div>';
                            } ?>



                            <label for="released_at">Date de sortie :</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="material-icons mi-md-color">calendar_today</i></span>
                            </div>
                            <input type="date" name="released_at" id="released_at" class="form-control <?php echo isset($errors['released_at']) ? 'is-invalid' : null; ?>" value="<?php echo $released_at; ?>">
                            <?php if (isset($errors['released_at'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['released_at'];
                                echo '</div>';
                            } ?>
                            </div>

                            <label for="video_link">Lien du film :</label>
                            <input type="text"  name="video_link" id="video_link" class="form-control <?php echo isset($errors['video_link']) ? 'is-invalid' : null; ?>" value="<?php echo $video_link; ?>">
                            <?php if (isset($errors['video_link'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['video_link'];
                                echo '</div>';
                            } ?>

                            <label for="cover">Pochette :</label>
                            <input type="file" name="cover" id="cover" class="form-control" value="<?php echo empty($cover) ? '' : $cover['name']; ?>">
                            <?php if (isset($errors['cover'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['cover'];
                                echo '</div>';
                            } ?>
                        </div>
                    </div>

                    <!-- Colonne 2 -->
                    <div class="col">
                        <div class="form-group p-3">
                            <label for="category_id">Catégorie :</label>
                            <select name="category_id" id="category_id" class="form-control <?php echo isset($errors['category_id']) ? 'is-invalid' : null; ?>">
                                <option value="">Choisir la catégorie</option>
                                <?php foreach($category_array as $category_row) { ?>
                                    <option <?php echo ($category_id === $category_row['id'] ? 'selected' : ''); ?> value="<?php echo $category_row['id']; ?>" selected><?php echo $category_row['name']; ?></option>
                                <?php } ?>
                            </select>
                            <?php if (isset($errors['category_id'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['category_id'];
                                echo '</div>';
                            } ?>

                            <label for="description">Description :</label>
                            <textarea name="description" id="description" class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : null; ?>" rows="7" minlength="10" maxlength="255"><?php echo $description; ?></textarea>
                            <?php if (isset($errors['description'])) {
                                echo '<div class="invalid-feedback">';
                                echo $errors['description'];
                                echo '</div>';
                            } ?>
                        </div>
                    </div>
                    </div>
                        <button type="submit" class="btn btn-primary btn-block text-uppercase">Ajouter</button>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.card-body -->
        </form>
    </main><!-- /.container -->

<?php
    // Footer du site web
    require_once(__DIR__.'/partials/footer.php');
?>
