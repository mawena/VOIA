<?php helper('text'); ?>
<link rel="stylesheet" href="/Css/trainings.css">

<style>
    #home-presentation,
    #home-presentation>* {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: justify;
    }

    #home-presentation {
        margin: 20px;
    }

    h2 {
        font-weight: bold;
        text-align: center;
        margin: 50px;
    }

    #home-presentation>div:nth-child(1)>div {
        font-weight: bold;
        font-size: 15px;
        text-align: center;
    }



    @media all and (min-width: 701px) {
        #prix {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 50px;
        }

        #prix img {
            width: 50%;
            margin: -30px;
            border-radius: 50%;
            border: 10px solid white;
            transition: .3s linear;
        }

        #prix img:hover {
            scale: 1.1;
            border-radius: 5px;
            z-index: 1;
        }

        #prix img:nth-child(1) {
            width: 40%;
            height: auto;
        }

        #prix img:nth-child(2) {
            width: 40%;
            height: auto;
        }

        #prix2 {
            display: none;
        }
    }

    @media all and (max-width: 700px) {
        #prix {
            display: none;
        }

        #prix2 {
            border: 5px solid white;
        }
    }

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

    <div id="home-presentation">
        <div>
            <h2>Bienvenue
                <hr />
            </h2>
            <div style="text-align: justify;">
                Bienvenue au programme de Vulgarisation de l’Outil Informatique en Afrique(VOIA). <br />
                En participant à notre formation sur les métiers du digital, bénéficiez de connaissances pratiques sur 7 modules en plus de l’opportunité de gagner le téléphone ci-dessous.
            </div>

        </div>
    </div>
    <div id="prix">
        <img src="/Images/pic-test/phone1.jpg" alt="phone">
        <img src="/Images/pic-test/phone2.jpg" alt="phone">
        <img src="/Images/pic-test/phone3.jpg" alt="phone">
    </div>

    <div id="prix2" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="/Images/pic-test/phone1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="/Images/pic-test/phone2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="/Images/pic-test/phone3.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#prix2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#prix2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>

    <div style="text-align:justify;margin-top:40px;font-size:15px">
        <h4 style="font-weight: bold;text-transform: uppercase;">Objectifs</h4>
        <div style="font-weight: bold;">
            Former 10.000 personnes sur les opportunités du numérique et un usage lucratif des Smartphones en 2021 afin de contribuer à leur épanouissement et lutter contre le chômage.
        </div>
        <hr />
    </div>

    <h2><?= esc($title); ?></h2>
    <div class="marquee-rtl">
        <div>Bénéficiez de toutes ces <a href="/"> <strong style="color:black;">formations</strong> </a> à 5.000 Fcfa ou 10.000 Fcfa selon le niveau pour lequel vous optez</div>
    </div>

    <div class="card-wrapper">
        <?php

        function idSelect($list)
        {
            $id = '';

            switch (count($list)) {
                case 1:
                    $id = "card-1";
                    break;

                default:
                    $id = "card-2";
                    break;
            }

            return $id;
        }
        ?>

        <?php foreach ($trainings as $training_item) : ?>
            <div class="card" id=<?php echo idSelect($trainings); ?>>
                <img src="/Images/trainings/<?= esc($training_item['slug'] . '_bg.png') ?>" alt="card background" class="card-img">
                <img src="/Images/trainings/<?= esc($training_item['slug']); ?>.png" alt="profile image" class="profile-img">
                <h1><?= esc($training_item['name']) ?></h1>
                <p class="job-title">
                    Durée de la formation : <?= esc($training_item['duration_month']) ?> mois
                </p>
                <?php if ($training_item['certified']) { ?>
                    <p class="job-title">
                        Formation Certifiée
                    </p>
                <?php } ?>
                <p class="about">
                    <?= word_limiter($training_item['description'], 300, "..."); ?>
                </p>
                <a href="/cours/list/<?= esc($training_item['slug']) ?>" class="btn">Voir Plus</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    $('#cgu button.btn.btn-secondary').on("click", function(e) {
        $("#cgu-box").slideUp()
    })
</script>