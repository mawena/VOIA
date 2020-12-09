<?php

use App\Libraries\functions;
use App\Libraries\Complements;

helper('url');
$functions = new Complements();
?>

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
          <?php echo $functions->get_nav_li($content = "Acceuil", $href = "/", $active = "/", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fas fa-home"); ?>
          <?php echo $functions->get_nav_li($content = "Cours", $href = "/cours", $active = "cours", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fas fa-book"); ?>
          <?php if ($session->get('currentUser') !== NULL) : ?>
            <?php echo $functions->get_nav_li($content = "Tableau de bord", $href = "/dashboard", $active = "dashboard", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fas fa-columns"); ?>
            <?php echo $functions->get_nav_li($content = "Paramètres", $href = "#settings", $active = "settings", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fas fa-cog"); ?>
          <?php endif ?>
        </ul>
        <!-- <div id="form-nav-center"> -->
        <form class="form-inline my-2 my-lg-0 nav-form" id="nav-form" action='/cours' method="post">
          <input name="formation_search" class="form-control mr-sm-2" type="text" placeholder="Chercher des cours">
          <button class="btn btn-secondary my-2 my-sm-0 nav-btn-submit" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <!-- </div> -->
        <?php if ($session->get('currentUser') === NULL) : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/connexion"><i class="fas fa-sign-in-alt">Connexion</i></a>
          <!-- <a class="nav-link btn pull-right nav-btn-orange" href="/inscription"><i class="fas fa-user-plus"> Inscription</i></a> -->
        <?php else : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/deconnexion"><i class="fas fa-sign-out-alt"> Deconnexion</i></a>
        <?php endif ?>
      </div>
      </nav>
</div>