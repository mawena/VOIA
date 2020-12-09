<link rel="stylesheet" href="/Css/login.css">

<div id="popupBox">
    <div id="popup">
    </div>
</div>

<div>
    <form action="/connexion" method="post">
        <div class="login-box">
            <h1><?= esc($title) ?></h1>
            <div class="text-box">
                <i class="fa fa-envelope"></i>
                <input type="text" name="email" id="email" placeholder="Adresse mail" required value="gamligocharles@gmail.com">
            </div>
            <div class="text-box">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required value="licdovic">
            </div>
            <input class="btn" id="connexion" type="submit" value="Connexion">
        </div>
    </form>
</div>

<script>
    $("#connexion").on("click", function(e) {
        e.preventDefault();
        let newForm = new FormData();
        newForm.append("email", $("#email").val());
        newForm.append("password", $("#password").val());

        $("#connexion").after('<div class="loading animate"></div>');
        $("#connexion").slideToggle()

        $.ajax({
            url: "/apis/users/connexion",
            type: "POST",
            data: newForm,
            processData: false,
            contentType: false,
            success: function(data) {

                $("#popup").removeClass("success")
                $("#popup").removeClass("failed")
                $("#connexion").html('Connexion');
                $("#connexion").slideToggle();
                $(".loading").remove()

                if (data.status == "success") {
                    user = data.data
                    userForm = new FormData;
                    userForm.append("token", user.token);
                    userForm.append("username", user.username);
                    userForm.append("last_name", user.last_name);
                    userForm.append("first_name", user.first_name);
                    userForm.append("email", user.email);
                    userForm.append("matricule", user.matricule);

                    setTimeout(function() {
                        $.ajax({
                            url: "/apis/session/connect/" + data.data.token,
                            type: "POST",
                            data: userForm,
                            processData: false,
                            contentType: false,
                            success: function(dataSession) {
                                if (data.status == "success") {
                                    window.location.href = "/dashboard";
                                } else if (data.status == "failed") {
                                    window.location.href = "/connexion";
                                }
                            }

                        });
                    }, 450);

                } else if (data.status == "failed") {
                    $("#popup").addClass("failed")
                    $("#popup").html(data.message)

                    setTimeout(function() {
                        $("#popupBox").fadeIn(100);
                        $("#popupBox").css({
                            "display": "flex"
                        });
                        $("#popup").css({
                            "scale": "1"
                        });
                        $("#popupBox").on("click", function(e) {
                            if (e.target.id != "popup") {
                                $("#popup").css({
                                    "scale": "0"
                                });
                                $("#popupBox").fadeOut(200);
                            }
                        })
                    }, 300)
                }
            }
        });
    })
</script>