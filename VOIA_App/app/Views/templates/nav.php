<?php

use App\Libraries\functions;
use App\Libraries\Complements;
use App\Libraries\Helper;

helper('url');
$functions = new Complements();
?>
<style>
  #cours-dropdown {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: 10px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: .2s ease-in-out;
  }

  #cours-dropdown:hover {
    scale: 0.9;
    transition: .2s ease-in-out;
  }
</style>

<div>
  <?php if (strstr(uri_string(), "dashboard")) : ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue fixed-top">
    <?php else : ?>
      <nav class="navbar navbar-expand-lg navbar-dark bg-blue">
      <?php endif ?>
      <a id="VOIA_logo" href="/"><img src="/Images/VOIA_logo_100x100.png" alt="Logo" style="border-radius: 20px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php $session = \Config\Services::session(); ?>
      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">

          <li id="cours-dropdown" class="nav-item">
            <a href="/" class="nav-link"><i class="fas fa-home"></i> Accueil</a>
          </li>

          <li class="dropdown" id="cours-dropdown">
            <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-book"></i> Cours </span>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

              <a class="dropdown-item" href="/cours/list/communication-digitale">
                Communication Digitale
              </a>
              <a class="dropdown-item" href="/cours/list/perlage">
                Accessoires Pagnes et perlage
              </a>
              <a class="dropdown-item" href="/cours/list/sapo">
                Saponification
              </a>
            </div>
          </li>

          <?php if ($session->get('currentUser') !== NULL) : ?>
            <li id="cours-dropdown" class="nav-item">
              <a href="/dashboard" class="nav-link"><i class="fas fa-columns"></i> Tableau de bord</a>
            </li>
          <?php endif ?>
        </ul>

        <!-- <div id="form-nav-center"> -->
        <form class="form-inline my-2 my-lg-0 nav-form" id="nav-form" action='/cours' method="post">
          <input name="formation_search" class="form-control mr-sm-2" type="text" placeholder="Chercher des cours">
          <button class="btn btn-secondary my-2 my-sm-0 nav-btn-submit" type="submit"><i class="fas fa-search"></i></button>
        </form>

        <!-- </div> -->
        <?php if ($session->get('currentUser') !== NULL || $session->get('currentSuperAdmin') !== NULL) : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/deconnexion"><i class="fas fa-sign-out-alt"> Deconnexion</i></a>
        <?php else : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/connexion"><i class="fas fa-sign-in-alt"> Connexion</i></a>
          <span class="nav-link btn pull-right nav-btn-orange" id="inscription-button"><i class="fas fa-user-plus"> Inscription</i></span>
        <?php endif ?>
      </div>
      </nav>
</div>

<div id="popup-box">
  <div id="popup">
    <div>
      Bienvenue sur la plateforme de V O I A.
      Veuillez suivre les directives precisées ci-dessous.
    </div>
    <div>
      Avez vous un lien de parainage ?
    </div>

    <div id="popup-body">
      <div>
        <div>Oui</div>
        <div>
          Veuillez alors <strong>cliquer</strong> sur le lien que vous avez à votre disposition pour accéder directement à l'interface d'inscription de la plateforme <strong>VOIA</strong> pour pouvoir bénéficier de cette initiative.
        </div>
      </div>
      <div>
        <div>Non</div>
        <div>
          Veuillez, dans ce cas, cliquez sur le lien dessous suivant le paquet auquel vous desirez souscrire
          <div style="font-style:italic;text-align:center; margin: 10px;font-weight:bold">
            Frais d'inscription
            <div>
              1.000frs CFA à l'interieur du Togo
            </div>
            <div>
              2.500frs CFA hors du Togo
            </div>
          </div>
          <div style="text-align: center;">
            <a href="<?php echo Helper::getBaseUrl(); ?>/inscription/02051r02222/niveau-1">Niveau 1 (5.000frs CFA)</a>
            <br>
            <a href="<?php echo Helper::getBaseUrl(); ?>/inscription/02051r02222/niveau-2">Niveau 2 (10.000frs CFA)</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("#inscription-button").on("click", function(e) {
    $("#popup-box").fadeToggle()
    $("#popup-box").css({
      "display": "flex"
    })
  })

  $("#popup-box").on('click', function(e) {
    if (e.target.id === "popup-box") {
      $("#popup-box").fadeToggle()
    }
  })

  $("#popup-body > div > div:nth-child(1)").on('click', function(e) {
    if ($((e.currentTarget.parentElement.children)[1]).css("display") !== "none") {
      $((e.currentTarget.parentElement.children)[1]).slideToggle()
    } else {
      $("#popup-body > div > div:nth-child(2)").slideUp()
      $((e.currentTarget.parentElement.children)[1]).slideDown()
    }

  })
</script>