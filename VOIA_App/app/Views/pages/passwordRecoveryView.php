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
            drhesygheishihi
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


    <script>
        let userData = null

        let updateMdp = (data) => {
            $("#mdp_modify_form #state").hide()
            let mdp = document.querySelectorAll("#mdp_modify_form input")[0].value
            let mdpconf = document.querySelectorAll("#mdp_modify_form input")[1].value
            let minCar = 8
            if (mdp != "") {
                if (mdp.length >= minCar) {
                    if (mdp == mdpconf) {
                        data["oldPassword"] =  data["password"]
                        data["password"] = mdp
                        let form = new FormData()
                        for (var key in data) {
                            form.append(key, data[key]);
                        }
                        $.ajax({
                            url: "/apis/users/update/" + data['token'],
                            type: 'POST',
                            data: form,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log(data)
                                console.log("update")
                            },
                            error: function(data) {
                                console.log(data)
                                alert('error')
                            }
                        })
                    } else {
                        $("#mdp_modify_form #state").text("Pas de correspondance entre les mots de passe entrés")
                        $("#mdp_modify_form #state").slideDown()
                    }
                } else {
                    $("#mdp_modify_form #state").text("Le mot de passe valide doit depasser 8 caractères")
                    $("#mdp_modify_form #state").slideDown()
                }
            } else {
                $("#mdp_modify_form #state").text("Le mot de passe est obligatoire")
                $("#mdp_modify_form #state").slideDown()
            }
        }

        $("#validate_username_button").on("click", function(e) {
            $("#state").hide()
            if ($("#recovery_form input").val() != "") {
                let form = new FormData()
                form.append("username", $("#recovery_form input").val())
                $.ajax({
                    url: '/apis/users/passwordrecovery',
                    type: "POST",
                    data: form,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == "success") {
                            userData = data.data
                            console.log(userData)
                            $($(".passwordrecovery")[0]).hide()
                            $($(".passwordrecovery")[1]).show()
                        } else {
                            $("#state").text(data.message)
                            $("#state").slideDown()
                        }
                    },
                    error: function(data) {
                        alert("error")
                        console.log(data)
                    }
                })
            } else {
                console.log("vide")
            }
        })



        $('#modify_pwd_button').on("click", function() {
            updateMdp(userData)
        })
    </script>
</body>