<link rel="stylesheet" href="/Css/login.css">

<style>
    .error {
        color: red;
        background-color: white;
    }

    .success {
        color: green;
        background-color: white;
    }

    #state {
        display: none;
        text-align: center;
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
        font-weight: bold;
    }
</style>

<div>
    <?php $session = \Config\Services::session(); ?>

    <form id="connexion-form">
        <div class="login-box">
            <?php if ($session->get('currentSuperAdmin')  == NULL) : ?>
                <h1><?= esc($title) ?></h1>
                <div class="text-box">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" id="Identifiant" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="text-box">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="Password" placeholder="Mot de passe" required>
                </div>
                <div id="state">
                </div>
                <input class="btn" type="submit" value="Connexion">
            <?php else : ?>
                <h1>Vous êtes déja connecté !</h1>
            <?php endif ?>
        </div>
    </form>
</div>

<script type="module" src="/JS/connexionAdmin.js"></script>