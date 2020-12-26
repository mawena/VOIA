<?php

use App\Libraries\functions;
use App\Libraries\Complements;

helper('url');
$functions = new Complements();
?>

<div>
  <?php if (strstr(uri_string(), "dashboard")) : ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue fixed-top"  style="background: grey;">
    <?php else : ?>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue" style="background: grey;">
      <?php endif ?>
      <a id="VOIA_logo" href="/"><img src="/Images/VOIA_logo_100x100.png" alt="Logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php $session = \Config\Services::session(); ?>
      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
          <?php if ($session->get('currentAdmin') !== NULL) : ?>
            <?php echo $functions->get_nav_li($content = "Tableau de bord", $href = "/admin/dashboard", $active = "dashboard", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fas fa-columns"); ?>
          <?php endif ?>
        </ul>
        <!-- <div id="form-nav-center"> -->
        <form class="form-inline my-2 my-lg-0 nav-form" id="nav-form" action='/admin' method="post">
          <input name="formation_search" class="form-control mr-sm-2" type="text" placeholder="Chercher des membres">
          <button class="btn btn-secondary my-2 my-sm-0 nav-btn-submit" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <!-- </div> -->
        <?php if ($session->get('currentAdmin') !== NULL) : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/admin/deconnexion"><i class="fas fa-sign-out-alt"> Deconnexion</i></a>
        <?php else : ?>
          <a class="nav-link btn pull-right nav-btn-orange" href="/admin/connexion"><i class="fas fa-sign-in-alt">Connexion</i></a>
        <?php endif ?>
      </div>
      </nav>
</div>