<h4 style="font-size: 40px;text-align: center; text-decoration: underline;"><?= esc(strtoupper($title)); ?>:</h4>
<br>
<br>
<?php if (!empty($course_item) && is_array($course_item)) : ?>
    <div class="card mb-3">
        <h3 class="card-header"><?= esc($course_item['name']) ?></h3>
        <div class="card-body">
            <div>
                <h5 class="card-subtitle">Durée :<?= esc($course_item['duration_hour']) ?> <?php echo ($course_item['duration_hour'] > 1) ? "heures" : "heure" ?></h5>

            </div>
        </div>

        <div class="card-bg bg-blue"  >
            <div class="image-card">
                <a" href="/cours/<?= esc($course_item['slug'], 'url'); ?>"><img src="/Images/cours/<?= $course_item['slug'] ?>.png" alt="Card image"></a>
            </div>

            <div class="card-body" style="color: white;">
                <p class="p-card" style="font-size:15px;text-align:justify;" > <?= esc($course_item['description']); ?></p>

            </div>

        </div>
    </div>
<?php else : ?>
    <h3 style="text-align: center; color: red;">Le Cours n'est pas diponible pour le moment</h3>
<?php endif ?>