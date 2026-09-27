<h1>Réservation confirmée !</h1>

<p>Votre réservation a bien été enregistrée.</p>

<ul>
    <li><strong>Hôtel :</strong> <?= $unHotel['nomHotel'] ?>, <?= $unHotel['villeHotel'] ?></li>
    <li><strong>Chambre :</strong>
        <?= $laChambre['nomChambre'] ? $laChambre['nomChambre'] : 'Chambre n°' . $laChambre['idChambre'] ?>
        <?php if ($laChambre['etage'] !== null) { ?>
            (étage <?= $laChambre['etage'] ?>)
        <?php } ?>
    </li>
    <li><strong>Arrivée :</strong> <?= $dateArrivee ?></li>
    <li><strong>Départ :</strong> <?= $dateDepart ?></li>
</ul>

<br />
<a href="./?action=profil">Voir mes réservations dans mon profil</a>
<br /><br />
<a href="./?action=detail&idHotel=<?= $unHotel['idHotel'] ?>">← Retour à l'hôtel</a>
