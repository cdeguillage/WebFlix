<?php

    // Titre de la page / Utilisateur
    $currentPageTitle = "Se connecter";

    $admin = false;

    // Connection à la base de données
    require_once(__DIR__.'/config/database.php');

    // Header du site web
    require_once(__DIR__.'/partials/header.php');

    $email = $success = null;

    if (isSubmit()) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $errors = [];
        
        $user = validUser($email, $password);
        
        if ($user) {
            login($user);
            redirect('.');
        }
        if (!$user) {
            $errors['email'] = 'Erreur d\'authentification';
        }
    }
?>

    <div class="container">

        <h1 class="offset-3 col-md-6 text-primary page-title"><?php echo $currentPageTitle; ?></h1>

        <div class="row">
            <div class="offset-3 col-md-6 bg-white p-3">
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : null; ?>" type="email" name="email" value="<?php echo $email; ?>">
                        <?php if (isset($errors['email'])) { ?>
                            <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input class="form-control" type="password" name="password">
                    </div>
                    <button class="btn btn-block btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>

<?php
// Le fichier footer.php est inclus sur la page
require_once(__DIR__.'/partials/footer.php');
?>