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

    .perlage-pic {
        width: 40%;
        height: auto;
        margin: 10px;
        box-shadow: 0px 0px 10px black;
        border-radius: 5px;
        transition: .3s ease-in-out;
    }

    .perlage-pic:hover {
        scale: 1.03;
        transition: .3s ease-in-out;
        cursor: pointer;
    }

    @media all and (max-width : 900px) {
        .perlage-pic {
            width: 80%;
            height: auto;
        }
    }
</style>
<div class="container">
    <div class="container-fluid">
        <!-- <div class="card-columns d-none d-md-block"> -->
        <?php helper('text'); ?>
        <h2 style="text-decoration: underline"><?= esc($title); ?> : <?= esc($currentFormation); ?></h2>
        <br>
        <div class="marquee-rtl">
            <div>Bénéficiez de toutes ces <a href="/"> <strong style="color:black;">formations</strong> </a> à 10.000 Fcfa selon le niveau pour lequel vous optez</div>
        </div>
        <div id="cours-list">
            <?php if (!empty($courses)) : ?>
                <?php if (is_array($courses)) : ?>
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
                    <?php if ($courses == "perlage") {
                        $images = scandir('Images/IMAGES-FORMATION');
                        foreach ($images as $key => $value) {
                            if (!in_array($value, [".", ".."]) && $value != null) {
                                echo ("<img class='perlage-pic' src='/Images/IMAGES-FORMATION/" . $value . "' />");
                            }
                        }
                    } ?>
                <?php endif ?>
            <?php else : ?>
                <h3>Aucun résultat</h3>
            <?php endif ?>
        </div>
    </div>
</div>