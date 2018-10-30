<?php
  // Inclusion du fichier functions
  require_once(__DIR__.'/../config/functions.php');
  // Fichier de configuration globale
  require_once(__DIR__.'/../config/config.php');
  // Connection à la base de données
  require_once(__DIR__.'/../config/database.php');
?>

<!doctype html>
<html lang="fr">
  <head>
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../../../favicon.ico"> -->

    <title>
    <?php
      if (empty($currentPageTitle))  // Si on est sur index
      {
        echo $siteName." - ".$slogan;
      }
      else   // Si on est sur autre page que index
      {
        echo $currentPageTitle." - ".$siteName;
      }
    ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="assets/css/starter-template.css">
    <link rel="stylesheet" href="assets/css/style.css">


    <!-- Datetimepicker -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> -->

    <!-- JS LOAD -->
    <script src="assets/js/script_load.js"></script>


  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark <?php echo $admin === false ? 'bg-primary ' : 'bg-success '; ?>fixed-top">

      <a class="navbar-brand" href="index.php"><?=$siteName;?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-webflix">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-webflix">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php echo $currentPageUrl === 'index' ? 'active' : ''; ?>">
            <a class="nav-link" href="index.php">Gallerie</a>
          </li>
          <li class="nav-item <?php echo $currentPageUrl === 'movie_add' ? 'active' : ''; ?>">
            <a class="nav-link" href="movie_add.php">Ajouter un film</a>
          </li>
        </ul>
      </div>

    </nav>