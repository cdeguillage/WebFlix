<?php

// Fichier de configuration  -Variables globales-

$siteName = 'WebFlix';
$slogan = 'Votre gallerie de films en ligne';

// Page courante et titre de la balisa title
// $currentPageTitle = (empty($currentPageTitle)) ? NULL : $currentPageTitle;
$currentPageUrl = basename($_SERVER['REQUEST_URI'], '.php');
