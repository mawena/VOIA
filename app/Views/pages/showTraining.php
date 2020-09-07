<h4 style="font-size: 40px;text-align: center; text-decoration: underline;"><?= esc(strtoupper($title)); ?>:</h4>
<br>
<br>
<?php if (!empty($formation) && is_array($formation)) : ?>
    <div class="card mb-3">
        <h3 class="card-header"><?= esc($training_item['name']) ?></h3>
        <div class="card-body">
            <div>
                <?php if ($training_item['certified']) { ?>
                    <h5>Formation Certifié</h5>
                <?php } ?>
                <h5 class="card-subtitle">Durée de la formation :<?= esc($training_item['duration_hour']) ?> mois</h5>

            </div>
        </div>

        <div class="card-bg bg-blue">
            <div class="image-card">
                <a" href="/formations/<?= esc($training_item['slug'], 'url'); ?>"><img src="/Images/training/<?= $training_item['slug'] ?>.png" alt="Card image"></a>
                    <!-- <a" href="/formations/<?= esc($training_item['slug'], 'url'); ?>"><img src="/Images/training/training.webp" alt="Card image"></a> -->
            </div>

            <div class="card-body" style="color: white;">
                <p class="p-card"> <?= word_limiter($training_item['description'], 75, "..."); ?></p>
            </div>

        </div>

        <div class="modal-footer bg-blue">
            <a class="btn btn-primary" id="btn-orange" href="/formations/<?= esc($training_item['slug'], 'url') ?>">Voir plus</a>
        </div>
    </div>
<?php else : ?>
    <h3>Aucune formation n'est diponible pour le moment</h3>
<?php endif ?>