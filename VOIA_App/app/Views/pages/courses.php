<style>
    .marquee-rtl {
        max-width: 60em;
        margin: 1em auto 2em;
        border: 1px solid #FFF;
        overflow: hidden;
        box-shadow: 0 .25em .5em #CCC, inset 0 0 1em .25em #CCC;
    }

    .marquee-rtl> :first-child {
        display: inline-block;
        padding: 10px;
        padding-left: 100%;
        white-space: nowrap;
        animation: defilement-rtl 15s infinite linear;
        font-weight: bold;
    }

    @keyframes defilement-rtl {
        0% {
            transform: translate3d(0, 0, 0);
        }

        100% {
            transform: translate3d(-100%, 0, 0);
        }
    }
</style>
<div class="container">
    <div class="container-fluid">
        <!-- <div class="card-columns d-none d-md-block"> -->
        <?php helper('text'); ?>
        <h2 style="text-decoration: underline"><?= esc($title); ?>:</h2>
        <br>
        <div class="marquee-rtl">
            <div>Bénéficiez de toutes ces <a href="/"> <strong style="color:black;">formations</strong> </a> à 5.000 Fcfa ou 10.000 Fcfa selon le niveau pour lequel vous optez</div>
        </div>
        <div id="cours-list">
            <?php if (!empty($courses) && is_array($courses)) : ?>
                <?php foreach ($courses as $course_item) : ?>
                    <div class="cours">
                        <h3 class="card-header bg-orange"><?= esc($course_item['name']) ?></h3>
                        <div class="card-body bg-blue">
                            <div style="color:white;">
                                <?php if ($course_item['certified']) { ?>
                                    <h5>Formation Certifié</h5>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="cours-details-body bg-blue">
                            <div class="image-card">
                                <a" href="/cours/<?= esc($course_item['slug'], 'url'); ?>"><img src="/Images/cours/<?= $course_item['slug'] ?>.png" alt="Card image"></a>
                            </div>
                            <div class="card-body" style="color: white; text-align:justify;font-weight:bold;">
                                <p class="p-card"> <?= word_limiter($course_item['description'], 75, "..."); ?></p>
                            </div>
                        </div>
                        <div class="modal-footer bg-blue">
                            <a class="btn nav-btn-orange" id="btn-orange" href="/cours/<?= esc($course_item['slug'], 'url') ?>">Voir plus</a>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php else : ?>
                <h3>Aucun résultat</h3>
            <?php endif ?>
        </div>
    </div>
</div>