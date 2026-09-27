<h1>Mon profil</h1>

Mon adresse électronique : <?= $util["mailC"] ?> <br />
Mon pseudo : <?= $util["pseudo"] ?> <br />

<hr>

Les hôtels que j'aime : <br />
<?php for ($i = 0; $i < count($mesHotelsAimes); $i++) { ?>
    <a href="./?action=detail&idHotel=<?= $mesHotelsAimes[$i]["idHotel"] ?>">
        <?= $mesHotelsAimes[$i]["nomHotel"] ?>
    </a><br />
<?php } ?>

<hr>

Les services que je recherche :
<ul id="tagFood">
    <?php for ($i = 0; $i < count($mesServicesAimes); $i++) { ?>
        <li class="tag"><span class="tag">#</span><?= $mesServicesAimes[$i]["descriptionService"] ?></li>
    <?php } ?>
</ul>

<hr>

Mes réservations :
<?php if (count($mesReservations) == 0) { ?>
    <p>Vous n'avez aucune réservation pour le moment.</p>
<?php } else { ?>
    <ul>
        <?php foreach ($mesReservations as $resa) { ?>
            <li>
                <a href="./?action=detail&idHotel=<?= $resa['idHotel'] ?>">
                    <?= $resa['nomHotel'] ?>
                </a>
                — <?= $resa['nomChambre'] ? $resa['nomChambre'] : 'Chambre n°' . $resa['idChambre'] ?>
                (étage <?= $resa['etage'] !== null ? $resa['etage'] : '?' ?>)
                <br />
                Du <?= $resa['dateReservation'] ?> au <?= $resa['dateLiberation'] ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<hr>
<a href="./?action=deconnexion">Se déconnecter</a>
