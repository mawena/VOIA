let userData = null;

$("button#connexion").on("click", function () {
  window.location.pathname = "/connexion";
});

let updateMdp = (data) => {
  $("#mdp_modify_form #state").hide();
  let mdp = document.querySelectorAll("#mdp_modify_form input")[0].value;
  let mdpconf = document.querySelectorAll("#mdp_modify_form input")[1].value;
  let minCar = 8;
  if (mdp != "") {
    if (mdp.length >= minCar) {
      if (mdp == mdpconf) {
        data["oldPassword"] = data["password"];
        data["password"] = mdp;
        let form = new FormData();
        for (var key in data) {
          form.append(key, data[key]);
        }
        $.ajax({
          url: "/apis/users/update/" + data["token"],
          type: "POST",
          data: form,
          processData: false,
          contentType: false,
          success: function (data) {
            console.log(data);
            $("#mdp_modify_form").hide();
            $($(".passwordrecovery")[2]).show();
          },
          error: function (data) {
            console.log(data);
            alert("error");
          },
        });
      } else {
        $("#mdp_modify_form #state").text(
          "Pas de correspondance entre les mots de passe entrés"
        );
        $("#mdp_modify_form #state").slideDown();
      }
    } else {
      $("#mdp_modify_form #state").text(
        "Le mot de passe valide doit depasser 8 caractères"
      );
      $("#mdp_modify_form #state").slideDown();
    }
  } else {
    $("#mdp_modify_form #state").text("Le mot de passe est obligatoire");
    $("#mdp_modify_form #state").slideDown();
  }
};

$("#validate_username_button").on("click", function (e) {
  $("#state").hide();
  if ($("#recovery_form input").val() != "") {
    let form = new FormData();
    form.append("username", $("#recovery_form input").val());
    $.ajax({
      url: "/apis/users/getByUsername",
      type: "POST",
      data: form,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.status == "success") {
          userData = data.data;
          console.log(userData);
          $($(".passwordrecovery")[0]).hide();
          $($(".passwordrecovery")[1]).show();
        } else {
          $("#state").text(data.message);
          $("#state").slideDown();
        }
      },
      error: function (data) {
        alert("error");
        console.log(data);
      },
    });
  } else {
    console.log("vide");
  }
});

$("#modify_pwd_button").on("click", function () {
  updateMdp(userData);
});
