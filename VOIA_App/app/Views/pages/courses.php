<div class="container">
    <div class="container-fluid">
        <!-- <div class="card-columns d-none d-md-block"> -->
        <?php helper('text'); ?>

        <h2 style="text-decoration: underline"><?= esc($title); ?>:</h2>
        <br>
        <?php if (!empty($courses) && is_array($courses)) : ?>
            <?php foreach ($courses as $course_item) : ?>
                <div class="card mb-3 bg-blue">
                    <h3 class="card-header bg-orange"><?= esc($course_item['name']) ?></h3>
                    <div class="card-body bg-blue">
                        <div>
                            <?php if ($course_item['certified']) { ?>
                                <h5>Formation Certifié</h5>
                            <?php } ?>
                            <h5 class="card-subtitle">Durée : <?= esc($course_item['duration_hour']) ?> heures</h5>

                        </div>
                    </div>

                    <div class="card-bg bg-blue">
                        <div class="image-card">
                            <a" href="/cours/<?= esc($course_item['slug'], 'url'); ?>"><img src="/Images/cours/<?= $course_item['slug'] ?>.png" alt="Card image"></a>
                        </div>

                        <div class="card-body" style="color: white;">
                            <p class="p-card"> <?= word_limiter($course_item['description'], 75, "..."); ?></p>
                        </div>

                    </div>

                    <div class="modal-footer bg-blue">
                        <a class="btn nav-btn-orange" id="btn-orange" href="/cours/<?= esc($course_item['slug'], 'url') ?>">Voir plus</a>
                    </div>
                </div>
                <br>
                <br>
                <br>
            <?php endforeach; ?>
        <?php else : ?>
            <h3>Aucun résultat</h3>
        <?php endif ?>
    </div>
</div>