<div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-blue"> <a id="VOIA_logo" href="/"><img src="/Images/VOIA_logo_100x100.png" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php $session = \Config\Services::session(); ?>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link" href="/"><i class="fas fa-home"> Acceuil</i></span></a></li>
        <li class="nav-item"><a class="nav-link" href="/formations"><i class="fas fa-book"> Formations</i></a></li>
        <?php if ($session->get('currentUser') !== NULL) : ?>
          <li class="nav-item"><a class="nav-link" href="/dashboard"><i class="fas fa-columns"> Dashboard</i></a></li>
        <?php endif ?>
      </ul>
      <!-- <div id="form-nav-center"> -->
      <form class="form-inline my-2 my-lg-0 nav-form" id="nav-form" action='/formations' method="post">
        <input name="formation_search" class="form-control mr-sm-2" type="text" placeholder="Chercher des cours">
        <button class="btn btn-secondary my-2 my-sm-0 nav-btn-submit" type="submit"><i class="fas fa-search"></i></button>
      </form>
      <!-- </div> -->
      <?php if ($session->get('currentUser') !== NULL) : ?>
        <a class="nav-link btn pull-right nav-btn-orange" href="/deconnexion"><i class="fas fa-sign-out-alt"> Deconnexion</i></a>
      <?php else : ?>
        <a class="nav-link btn pull-right nav-btn-orange" href="/connexion"><i class="fas fa-sign-in-alt">Connexion</i></a>
        <a class="nav-link btn pull-right nav-btn-orange" href="/inscription"><i class="fas fa-user-plus"> Inscription</i></a>
      <?php endif ?>
    </div>
  </nav>
</div>