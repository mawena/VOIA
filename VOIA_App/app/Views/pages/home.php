<?php helper('text'); ?>
<link rel="stylesheet" href="/Css/trainings.css">
<div class="container">
    <h1 class="heading"><?= esc($title); ?>:</h1>
    <div class="card-wrapper">
        <?php foreach ($trainings as $training_item) : ?>

            <div class="card">
                <img src="/Images/backgrounds/bg-2.jpg" alt="card background" class="card-img">
                <img src="/Images/trainings/<?= esc($training_item['slug']); ?>.png" alt="profile image" class="profile-img">
                <h1><?= esc($training_item['name']) ?></h1>

                
                <p class="job-title">
                    Durée de la formation :<?= esc($training_item['duration_month']) ?> mois
                </p>

                <?php if ($training_item['certified']) { ?>
                    <p class="job-title">
                        Formation Certifié
                    </p>
                <?php } ?>

                <p class="about">
                    <?= word_limiter($training_item['description'], 50, "..."); ?>
                </p>
                    <a href="#" class="btn">Voir Plus</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>