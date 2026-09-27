<h1>Réserver — <?= $unHotel['nomHotel'] ?></h1>

<?php if ($msg != "") { ?>
    <p id="alerte"><?= $msg ?></p>
<?php } ?>

<?php if ($etape == "dates") { ?>

    
    <form action="./?action=reservation&idHotel=<?= $unHotel['idHotel'] ?>" method="POST">
        <input type="hidden" name="step"    value="dates" />
        <input type="hidden" name="idHotel" value="<?= $unHotel['idHotel'] ?>" />

        <label for="dateArrivee">Date d'arrivée</label><br />
        <input type="date" id="dateArrivee" name="dateArrivee"
               min="<?= date('Y-m-d') ?>"
               value="<?= isset($dateArrivee) ? $dateArrivee : '' ?>" /><br />

        <label for="dateDepart">Date de départ</label><br />
        <input type="date" id="dateDepart" name="dateDepart"
               min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
               value="<?= isset($dateDepart) ? $dateDepart : '' ?>" /><br />

        <input type="submit" value="Voir les chambres disponibles" />
    </form>

<?php } elseif ($etape == "chambres") { ?>

    
    <p style="color:var(--muted); font-size:14px; margin-bottom:20px;">
        Du <strong><?= $dateArrivee ?></strong> au <strong><?= $dateDepart ?></strong>
        — <strong><?= count($chambresDispos) ?></strong> chambre(s) disponible(s)
    </p>

    <div style="display:flex; flex-wrap:wrap; gap:20px;">
    <?php foreach ($chambresDispos as $chambre) { ?>
        <div style="width:260px; background:#fff; border-radius:14px; border:0.5px solid var(--or-border); overflow:hidden; box-shadow:var(--shadow);">

            
            <?php if (!empty($chambre['photos'])) { ?>
                <img src="photos/<?= $chambre['photos'][0]['cheminPhotoChambre'] ?>"
                     alt="photo chambre"
                     style="width:100%; height:160px; object-fit:cover;" />
            <?php } else { ?>
                <div style="width:100%; height:160px; background:#261b0d; display:flex; align-items:center; justify-content:center; color:var(--or); font-size:32px;">🛏</div>
            <?php } ?>

            <div style="padding:14px;">
                <div style="font-family:'Playfair Display',serif; font-size:16px; font-weight:600; margin-bottom:4px;">
                    <?= $chambre['nomChambre'] ? $chambre['nomChambre'] : 'Chambre n°'.$chambre['idChambre'] ?>
                </div>
                <?php if ($chambre['etage'] !== null) { ?>
                    <div style="font-size:12px; color:var(--muted); margin-bottom:12px;">Étage <?= $chambre['etage'] ?></div>
                <?php } ?>

                
                <?php if (count($chambre['photos']) > 1) { ?>
                    <div style="display:flex; gap:6px; margin-bottom:12px; flex-wrap:wrap;">
                    <?php for ($p = 1; $p < count($chambre['photos']); $p++) { ?>
                        <img src="photos/<?= $chambre['photos'][$p]['cheminPhotoChambre'] ?>"
                             style="width:56px; height:40px; object-fit:cover; border-radius:6px; border:1px solid var(--or-border);" />
                    <?php } ?>
                    </div>
                <?php } ?>

                <form action="./?action=reservation&idHotel=<?= $unHotel['idHotel'] ?>" method="POST">
                    <input type="hidden" name="step"        value="chambre" />
                    <input type="hidden" name="idHotel"     value="<?= $unHotel['idHotel'] ?>" />
                    <input type="hidden" name="idChambre"   value="<?= $chambre['idChambre'] ?>" />
                    <input type="hidden" name="dateArrivee" value="<?= $dateArrivee ?>" />
                    <input type="hidden" name="dateDepart"  value="<?= $dateDepart ?>" />
                    <input type="submit" value="Choisir cette chambre" style="width:100%;" />
                </form>
            </div>
        </div>
    <?php } ?>
    </div>

    <br />
    <a href="./?action=reservation&idHotel=<?= $unHotel['idHotel'] ?>" style="font-size:13px;">← Changer les dates</a>

<?php } ?>

<br /><br />
<a href="./?action=detail&idHotel=<?= $unHotel['idHotel'] ?>" style="font-size:13px;">← Retour à l'hôtel</a>
