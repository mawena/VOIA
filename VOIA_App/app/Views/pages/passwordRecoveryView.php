<meta charset="UTF-8">
<title>fefq</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .passwordrecovery {
        margin: 20px;
        margin-top: 10vh;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;

    }

    #recovery_form {
        padding: 10px
    }

    #recovery_form>* {
        margin: 5px;
        width: 100%;
    }

    #recovery_form input {
        /* width: 40%; */
        padding: 15px;
    }

    #state {
        text-align: center;
        padding: 10px;
        color: red;
        background-color: white;
        border-radius: 5px;
        display: none;
    }

    @media screen and (max-width: 700px) {
        #recovery_form input {
            width: 100%;
        }
    }
</style>

<body>
    <div class="passwordrecovery">
        <h1>
            <?= esc($title) ?>
            <hr>
        </h1>
        <div id="recovery_form">
            <div style="font-weight: bold;">
                Suivez le processus ci-dessous pour récuperer l'usage de votre compte VOIA
            </div>
            <input type="text" placeholder="Nom d'utilisateur">
            <button id="validate_username_button" class="btn btn-success"> Continuer </button>
        </div>

        <span id='state'>
        </span>
    </div>

    <div class="passwordrecovery" id="mdp_modify_form" style="display: none;">
        <h1>Nouveau mot de passe
            <hr>
        </h1>
        <div id="recovery_form">
            <div style="font-weight: bold;text-align:center;">Veuillez entrez le nouveau mot de passe</div>
            <input type="password" placeholder="Mot de passe">
            <input type="password" placeholder="Confirmer le mot de passe">
            <button id="modify_pwd_button" class="btn btn-success"> Modifier le mot de passe </button>
        </div>
        <span id='state'>
        </span>
    </div>

    <div class="passwordrecovery" style="display: none;text-align:center">
        <h3>Mot de passe modifié avec succès</h3>
        <button class="btn btn-success" id="connexion"> Connexion </button>
    </div>

    <script src="/JS/pass.js" ></script>
</body>