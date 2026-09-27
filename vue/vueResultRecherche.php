<h1>Résultats de la recherche</h1>

<?php
for ($i = 0; $i < count($listeHotels); $i++) {
    $lesServices = getServicesByIdHotel($listeHotels[$i]['idHotel']);
    $lesPhotos = getPhotosByIdHotel($listeHotels[$i]['idHotel']);
    ?>

    <div class="card">
        <div class="photoCard">
            <?php if (count($lesPhotos) > 0) { ?>
                <img src="photos/<?= $lesPhotos[0]["cheminPhoto"] ?>" alt="photo de l'hôtel" />
            <?php } ?>
        </div>
        <div class="descrCard">
            <?php echo "<a href='./?action=detail&idHotel=" . $listeHotels[$i]['idHotel'] . "'>" . $listeHotels[$i]['nomHotel'] . "</a>"; ?>
            <br />
            <?= $listeHotels[$i]["adresseHotel"] ?>
            <br />
            <?= $listeHotels[$i]["codePostal"] ?>
            <?= $listeHotels[$i]["villeHotel"] ?>
        </div>
        <div class="tagCard">
            <ul id="tagFood">
                <?php for ($j = 0; $j < count($lesServices); $j++) { ?>
                    <li class="tag"><span class="tag">#</span><?= $lesServices[$j]["descriptionService"] ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <?php
}
?>
