<h1>Liste des Hôtels</h1>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 8px;">
<?php
for ($i = 0; $i < count($listeHotel); $i++) {
    $lesPhotos = getPhotosByIdHotel($listeHotel[$i]['idHotel']);
    ?>

    <div style="background:#fff; border-radius:16px; box-shadow:0 4px 18px rgba(26,18,9,0.07); border:0.5px solid rgba(201,168,76,0.18); overflow:hidden; display:flex; flex-direction:column; transition:transform 0.25s ease, box-shadow 0.25s ease;"
         onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 36px rgba(26,18,9,0.13)'"
         onmouseout="this.style.transform='';this.style.boxShadow='0 4px 18px rgba(26,18,9,0.07)'">

        
        <div style="overflow:hidden; height:200px; background:#261b0d; flex-shrink:0;">
            <?php if (count($lesPhotos) > 0) { ?>
                <img src="photos/<?= $lesPhotos[0]["cheminPhoto"] ?>"
                     alt="photo de l'hôtel"
                     style="width:100%; height:100%; object-fit:cover; display:block;" />
            <?php } ?>
        </div>

        
        <div style="padding:16px 18px 10px; flex:1;">
            <a href="./?action=detail&idHotel=<?= $listeHotel[$i]['idHotel'] ?>"
               style="font-family:'Playfair Display',serif; font-size:17px; font-weight:600; color:#1c1410; text-decoration:none; display:block; margin-bottom:8px; line-height:1.3;">
                <?= $listeHotel[$i]['nomHotel'] ?>
            </a>
            <div style="font-size:13px; color:#7a6a55; line-height:1.6;">
                <?= $listeHotel[$i]["adresseHotel"] ?><br />
                <?= $listeHotel[$i]["codePostal"] ?> <?= $listeHotel[$i]["villeHotel"] ?>
            </div>
        </div>

    </div>

    <?php
}
?>
</div>
