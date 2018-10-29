# WebFlix

On veut créer un nouveau NetFlix.

## Projet :
- Créer un dépôt GitHub.
- Faire le lien entre le dépôt local.
- Penser à la BDD.

## Pages :
###--- LOT 1 ---
- Accueil -> Liste de films triés par catégorie.
- Voir un film (movie_single.php?id=4) -> On veut voir un film.
- Ajouter un film (movie_add.php) -> On peut ajouter un film dans la BDD.

### --- LOT 2 ---
- Modifier un film (movie_edit.php?id=4) -> On peut modifier un film dans la BDD.
- Supprimer un film (movie_delete.php?id=4) -> On peut supprimer un film dans la BDD. On doit avoir un bouton supprimer sur la liste des films, on clique, on supprime le film en question et on revient sur la liste des films.
- Film random (movie_random.php) -> On affiche 4 films de manière aléatoire.

### --- LOT 3 ---
- Inscription (register.php) -> Formulaire d'inscription (email, username, mot de passe, confirmer le mot de passe).
- Connexion (login.php) -> Formulaire de connexion (mail, mot de passe).
- Mot de passe oublié (forget.php) -> 1er formulaire où on saisit l'email, s'il existe, on envoie un lien à l'utilisateur par mail pour redéfinir son mot de passe. Ce lien doit être unique et optionnellement valide seulement 24h (sinon 404). Si le lien est valide, on arrive sur un 2éme formulaire où on redéfinit son mot de passe (mot de passe, confirmer le mot de passe).

### --- LOT 4 ---
- Les pages Voir, Ajouter, Modifier, Supprimer un film ne sont accessible que par quelqu'un qui est connecté.

## Structure BDD :
- Movie : id, title, description, video_link, cover, released_at, category_id
- Category : id, name
- User : id, username, email, password, token,  token_expiration
