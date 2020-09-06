<div class="container">
<div class="container-fluid">
    <!-- <div class="card-columns d-none d-md-block"> -->
    <?php helper('text'); ?>
    <?php foreach ($formations as $formations_item) : ?>
        <div class="card mb-3">
            <h3 class="card-header"><?= esc($formations_item['name']) ?></h3>
            <div class="card-body">
                <h6 class="card-subtitle text-muted">Durée de la formation :
                    <?= esc($formations_item['duration_month']) ?> mois</h6>
            </div>
        </div>

        <div class="card-bg">

            <div class="image-card">
                <a" href="/formations/<?= esc($formations_item['slug'], 'url'); ?>"><img src="/Images/formations_pictures/<?= $formations_item['slug'] ?>.jpg" alt="Card image"></a>
            </div>
            
            <div class="card-body">
                <p class="p-card"> <?= word_limiter($formations_item['description'], 50, "..."); ?></p>
            </div>

        </div>

        <div class="modal-footer">
            <a class="btn btn-primary" id="orange-color" href="/formations/<?= esc($formations_item['slug'], 'url') ?>">Voir plus</a>
        </div>
        <div>
        </div>
    <?php endforeach; ?>
</div>
</div>