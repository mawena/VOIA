import { server_url } from "/JS/config.js";

$("#state").hide();

$("input.btn").on("click", function (e) {
  let connexion_data = new FormData(document.getElementById("connexion-form"));
  e.preventDefault();
  $.ajax({
    url: "/apis/superadmins/connexion",
    type: "POST",
    data: connexion_data,
    processData: false,
    contentType: false,
    success: function (data) {
      console.log(data);
      if (data.status == "success") {
        $("#state").hide();
        let user = data.data;
        let userForm = new FormData();
        userForm.append("token", user.token);
        userForm.append("username", user.username);
        userForm.append("last_name", user.last_name);
        userForm.append("first_name", user.first_name);
        userForm.append("email", user.email);
        userForm.append("matricule", user.matricule);

        setTimeout(function () {
          $.ajax({
            url: "/apis/session/superadmins/connect/" + data.data.token,
            type: "POST",
            data: userForm,
            processData: false,
            contentType: false,
            success: function (data) {
              if (data.status == "success") {
                window.location.href = "/admin/dashboard";
              } else if (data.status == "failed") {
                window.location.href = "/admin/connexion";
              }
            },
          });
        }, 450);
      } else if (data.status == "failed") {
        $("#state").show();
        $("#state").removeClass("success");
        $("#state").addClass("error");
        $("#state").text(data.message);
      }
    },
    error: function (data) {
      $("#state").show();
      $("#state").removeClass("success");
      $("#state").addClass("error");
      $("#state").text("Erreur de connexion ! Veuillez re-essayer !");
      console.log(data);
    },
  });
});
