<link rel="stylesheet" href="/Css/login.css">
<div>
    <?php $session = \Config\Services::session(); ?>
    <form action="/admin/connexion" method="post">
        <div class="login-box">
            <?php if ($session->get('currentAdmin')  == NULL) : ?>
                <h1><?= esc($title) ?></h1>
                <div class="text-box">
                    <i class="fa fa-user"></i>
                    <input type="text" name="Identifiant" id="Identifiant" placeholder="Identifiant" required>
                </div>
                <div class="text-box">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="Password" id="Password" placeholder="Mot de passe" required>
                </div>
                <input class="btn" type="submit" value="Inscription">
            <?php else : ?>
                <h1>Vous êtes déja connecté !</h1>
            <?php endif ?>
        </div>
    </form>
</div>