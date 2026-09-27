<?php

?>
<div class="anchor-tabs">
    <a href="#hotel">L'hôtel</a>
    <a href="#adresse">Adresse</a>
    <a href="#photos">Photos</a>
    <a href="#crit">Critiques</a>
</div>


<section id="hotel">
    <div style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--or-dark); margin-bottom:10px;">
        Services proposés
    </div>
    <ul id="tagService">
        <?php for ($j = 0; $j < count($lesServices); $j++) { ?>
            <li class="tag"><span class="tag">#</span><?= $lesServices[$j]["descriptionService"] ?></li>
        <?php } ?>
    </ul>
</section>


<div id="principal" style="margin-top:28px;">
    <?php if (count($lesPhotos) > 0) { ?>
        <img src="photos/<?= $lesPhotos[0]["cheminPhoto"] ?>" alt="photo de l'hôtel" />
    <?php } ?>
    <p style="margin-top:16px; color:var(--muted); font-size:15px; line-height:1.7;">
        <?= $unHotel['descriptionHotel']; ?>
    </p>
</div>


<h2 id="adresse">Adresse</h2>
<p style="color:var(--muted); font-size:15px;">
    <?= $unHotel['adresseHotel']; ?><br />
    <?= $unHotel['codePostal']; ?> <?= $unHotel['villeHotel']; ?>
</p>


<h2 id="photos">Photos</h2>
<ul id="galerie">
    <?php for ($i = 0; $i < count($lesPhotos); $i++) { ?>
        <li><img class="galerie" src="photos/<?= $lesPhotos[$i]["cheminPhoto"] ?>" alt="" /></li>
    <?php } ?>
</ul>


<h2 id="crit">Critiques</h2>

<?php if ($msgCritique != "") { ?>
    <p id="alerte"><?= $msgCritique ?></p>
<?php } ?>


<?php if ($peutCritiquer) { ?>
    <div style="background:#faf8f4; border:0.5px solid var(--or-border); border-radius:14px; padding:20px; margin-bottom:24px; max-width:500px;">
        <div style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--or-dark); margin-bottom:14px;">
            Laisser une critique
        </div>
        <form action="./?action=detail&idHotel=<?= $unHotel['idHotel'] ?>" method="POST">
            <input type="hidden" name="action_critique" value="ajouter" />

            <label>Note (1 à 5)</label><br />
            <div style="display:flex; gap:8px; margin:8px 0 16px;">
                <?php for ($n = 1; $n <= 5; $n++) { ?>
                    <label style="display:flex; align-items:center; gap:4px; background:var(--or-bg); border:1px solid var(--or-border); border-radius:8px; padding:6px 12px; cursor:pointer; font-size:13px; color:var(--or-dark); text-transform:none; letter-spacing:0; font-weight:600;">
                        <input type="radio" name="note" value="<?= $n ?>" required />
                        <?= $n ?> ★
                    </label>
                <?php } ?>
            </div>

            <label for="commentaireForm">Commentaire</label><br />
            <textarea id="commentaireForm" name="commentaire" placeholder="Votre avis sur cet hôtel..."></textarea><br />
            <input type="submit" value="Publier ma critique" style="margin-top:10px;" />
        </form>
    </div>
<?php } elseif ($mailC != "" && $dejaCritique) { ?>
    <p style="font-size:13px; color:var(--muted); font-style:italic; margin-bottom:16px;">
        Vous avez déjà rédigé une critique pour cet hôtel.
    </p>
<?php } elseif ($mailC != "" && !aDejaReserveHotel($mailC, $unHotel['idHotel'])) { ?>
    <p style="font-size:13px; color:var(--muted); font-style:italic; margin-bottom:16px;">
        Vous devez avoir réservé cet hôtel pour laisser une critique.
    </p>
<?php } elseif ($mailC == "") { ?>
    <p style="font-size:13px; color:var(--muted); font-style:italic; margin-bottom:16px;">
        <a href="./?action=connexion">Connectez-vous</a> pour laisser une critique.
    </p>
<?php } ?>


<ul id="critiques">
    <?php if (count($critiques) == 0) { ?>
        <li style="color:var(--muted); font-size:14px; font-style:italic; list-style:none;">
            Aucune critique pour le moment.
        </li>
    <?php } ?>
    <?php for ($i = 0; $i < count($critiques); $i++) { ?>
        <li>
            <span>
                <?= $critiques[$i]["mailC"] ?>
                <?php if ($critiques[$i]["note"]) { ?>
                    <span style="color:var(--or); font-size:13px; letter-spacing:1px;">
                        <?= str_repeat('★', $critiques[$i]["note"]) ?><?= str_repeat('☆', 5 - $critiques[$i]["note"]) ?>
                    </span>
                <?php } ?>
                <?php if ($critiques[$i]["mailC"] == $mailC) { ?>
                    <a href="./?action=detail&idHotel=<?= $unHotel['idHotel'] ?>&supprimerCritique=1"
                        style="color:#c0392b; font-size:12px; margin-left:auto;">Supprimer</a>
                <?php } ?>
            </span>
            <div style="margin-top:6px; font-size:14px; color:var(--text);">
                <?= htmlspecialchars($critiques[$i]["commentaire"]) ?>
            </div>
        </li>
    <?php } ?>
</ul>
