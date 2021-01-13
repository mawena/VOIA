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
            <?php if ($session->get('currentUser')  == NULL) : ?>
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

<script type="module">

    import {server_url} from "/JS/config.js"

    $("#state").hide()
    $("input.btn").on('click', function(e) {
        let connexion_data = new FormData(document.getElementById("connexion-form"))
        e.preventDefault()
        $.ajax({
            url: '/apis/users/connexion',
            type: "POST",
            data: connexion_data,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                if (data.status == "success") {
                    $("#state").hide()
                    let user = data.data
                    let userForm = new FormData;
                    userForm.append("token", user.token);
                    userForm.append("username", user.username);
                    userForm.append("last_name", user.last_name);
                    userForm.append("first_name", user.first_name);
                    userForm.append("email", user.email);
                    userForm.append("matricule", user.matricule);
                    userForm.append("type", user.type);

                    setTimeout(function() {
                        $.ajax({
                            url: "/apis/session/users/connect/" + data.data.token,
                            type: "POST",
                            data: userForm,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data.status == "success") {
                                    window.location.href = "/dashboard";
                                } else if (data.status == "failed") {
                                    window.location.href = "/connexion";
                                }
                            }
                        });
                    }, 450);
                } else if (data.status == "failed") {
                    $("#state").show()
                    $("#state").removeClass("success")
                    $("#state").addClass("error")
                    $("#state").text(data.message)
                }
            },
            error: function(data) {
                $("#state").show()
                $("#state").removeClass("success")
                $("#state").addClass("error")
                $("#state").text("Erreur de connexion ! Veuillez re-essayer !")
                console.log(data)
            }
        })

    })
</script>