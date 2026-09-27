<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titre ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            @import url("css/base1.css");
            @import url("css/form1.css");
            @import url("css/cgu1.css");
            @import url("css/corps1.css");
        </style>
    </head>
    <body>

    <header id="site-header">

        
        <nav id="main-nav">
            <a href="./?action=liste" class="nav-logo">Séjour</a>
            <ul class="nav-links">
                <li><a href="./?action=liste">Accueil</a></li>
                <li><a href="./?action=recherche">Recherche</a></li>
                <li><a href="./?action=cgu">CGU</a></li>
                <?php if (isLoggedOn()) { ?>
                    <li><a href="./?action=profil" class="nav-cta">Mon Profil</a></li>
                <?php } else { ?>
                    <li><a href="./?action=connexion" class="nav-cta">Connexion</a></li>
                <?php } ?>
            </ul>
        </nav>

        <?php if (isset($heroHotel)) { ?>
        
        <div class="hero-content">
            <div class="hero-eyebrow">
                <?= $heroHotel['villeHotel'] ?> · <?= $heroHotel['codePostal'] ?>
            </div>
            <h1 class="hero-title"><?= $heroHotel['nomHotel'] ?></h1>
            <div class="hero-stars">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?= $i <= $heroHotel['note'] ? '★' : '☆' ?>
                <?php } ?>
            </div>
            <div class="hero-actions">
                <a href="./?action=reservation&idHotel=<?= $heroHotel['idHotel'] ?>" class="btn-primary">
                    Réserver une chambre
                </a>
                <a href="./?action=aimer&idHotel=<?= $heroHotel['idHotel'] ?>" class="btn-ghost">
                    <?= $heroHotel['aime'] ? '♥ Aimé' : '♡ J\'aime' ?>
                </a>
            </div>
        </div>
        <?php } ?>

    </header>

    <div id="corps">
