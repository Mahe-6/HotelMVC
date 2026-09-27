<h1>Recherche d'un hôtel</h1>


<div class="anchor-tabs" style="margin-bottom:24px;">
    <a href="./?action=recherche&critere=nom"      <?= $critere=='nom'      ? 'style="color:var(--or);border-bottom-color:var(--or);"' : '' ?>>Par nom</a>
    <a href="./?action=recherche&critere=adresse"  <?= $critere=='adresse'  ? 'style="color:var(--or);border-bottom-color:var(--or);"' : '' ?>>Par adresse</a>
    <a href="./?action=recherche&critere=services" <?= $critere=='services' ? 'style="color:var(--or);border-bottom-color:var(--or);"' : '' ?>>Par services</a>
</div>

<form action="./?action=recherche&critere=<?= $critere ?>" method="POST">

    <?php switch ($critere) {
        case "nom": ?>
            <label for="nomHotel">Nom de l'hôtel</label><br />
            <input type="text" id="nomHotel" name="nomHotel"
                   placeholder="ex : Ritz" value="<?= $nomHotel ?>" />
        <?php break;

        case "adresse": ?>
            <label for="villeHotel">Ville</label><br />
            <input type="text" id="villeHotel" name="villeHotel"
                   placeholder="ex : Paris" value="<?= $villeHotel ?>" /><br />
            <label for="codePostal">Code postal</label><br />
            <input type="text" id="codePostal" name="codePostal"
                   placeholder="ex : 75001" value="<?= $codePostal ?>" /><br />
            <label for="adresseHotel">Rue</label><br />
            <input type="text" id="adresseHotel" name="adresseHotel"
                   placeholder="ex : Place Vendôme" value="<?= $adresseHotel ?>" />
        <?php break;

        case "services": ?>
            <div style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--or-dark); margin-bottom:14px;">
                Sélectionnez les services souhaités
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:8px;">
            <?php foreach ($tousLesServices as $service) { ?>
                <label style="display:flex; align-items:center; gap:6px; background:var(--or-bg); border:1px solid var(--or-border); border-radius:999px; padding:6px 14px; cursor:pointer; font-size:13px; color:var(--or-dark); font-weight:500; text-transform:none; letter-spacing:0;">
                    <input type="checkbox" name="services[]"
                           value="<?= $service['idService'] ?>"
                           <?= in_array($service['idService'], $idsServices) ? 'checked' : '' ?> />
                    <?= $service['descriptionService'] ?>
                </label>
            <?php } ?>
            </div>
        <?php break;
    } ?>

    <br />
    <input type="submit" value="Rechercher" />
</form>
