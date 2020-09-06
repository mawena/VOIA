<h4 style="font-size: 40px;text-align: center; text-decoration: underline;"><?= esc(strtoupper($title)); ?>:</h4>
<br>
<br>
<?php if (!empty($formation) && is_array($formation)) : ?>
    <div class="main">
        <img class="float-left" src="/Images/formations_pictures/<?= esc($formation['slug']) ?>.jpg" alt="<?= esc($formation['slug']) ?>" width="40%">
        <div style="margin-left: 45%;">
            <h3 class="underline"><?= esc($formation['name']); ?></h3><br>
            <h4>Durée de formation : <?= esc($formation['duration_month']) ?> mois</h4>
            <br>
            <div>
                <?= esc($formation['description']); ?>
                <br>
                <br>
                <span></span><?= esc($formation['trainers']) ?>
            </div>
        </div>
        <br>
    </div>
    <hr>
<?php else : ?>
    <h3>Aucune formation n'est diponible pour le moment</h3>
<?php endif ?>