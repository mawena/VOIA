$("#confBox button.cancel").on("click", function (e) {
  $("#confBox").fadeOut();
});

//-------------------------   LES FONCTIONS DE CHANGEMENT DE PAGE

function show_waiting(params = "on") {
  if (params == "on") {
    $("#waiting").css({
      display: "block",
    });
    // $("#communicateurs-list").hide();
  } else if (params == "off") {
    $("#waiting").css({
      display: "none",
    });
  }
}

function show_communicateurs(params = "on") {
  if (params == "on") {
    $("#communicateurs").css({
      display: "block",
    });
    // $("#communicateurs-list").slideToggle();
  } else if (params == "off") {
    $("#communicateurs").css({
      display: "none",
    });
  }
}

function show_valides(params = "on") {
  if (params == "on") {
    $("#valides").css({
      display: "block",
    });
    // $("#communicateurs-list").hide();
  } else if (params == "off") {
    $("#valides").css({
      display: "none",
    });
  }
}

function show_hs(params = "on") {
  if (params == "on") {
    $("#hors-systeme").css({
      display: "block",
    });
    // $("#communicateurs-list").hide();
  } else if (params == "off") {
    $("#hors-systeme").css({
      display: "none",
    });
  }
}

// ----------------------------------------- changement de pages suivant le bouton cliqué ------------------------------

let changePage = () => {
  switch (window.location.hash) {
    case "#waiting":
      show_communicateurs("off");
      show_waiting();
      show_valides("off");
      show_hs("off");
      break;

    case "#valides":
      show_waiting("off");
      show_communicateurs("off");
      show_hs("off");
      show_valides();
      break;

    case "#communicateurs":
      show_waiting("off");
      show_communicateurs();
      show_hs("off");
      show_valides("off");
      break;

    case "#hors-systeme":
      show_waiting("off");
      show_communicateurs("off");
      show_valides("off");
      show_hs();
      break;

    default:
      window.location.hash = "#waiting";
      break;
  }
};

changePage();
window.addEventListener("hashchange", function (e) {
  changePage();
});

$(" a > li > i").on("click", function (e) {
  e.preventDefault();
  $(e.target.parentElement.parentElement.nextElementSibling).slideToggle();
  $(e.target).toggleClass("fa-chevron-circle-left");
  $(e.target).toggleClass("fa-chevron-circle-down");
});

//  fonction de suppression des elements en liste d'attente

let deleteWaitingUser = (node, token) => {
  $.ajax({
    url: "/apis/userswaiting/delete/" + token,
    type: "GET",
    processData: false,
    contentType: false,
    success: function (data) {
      console.log(data);
      if (data.status == "success") {
        $(node).remove();
        window.location.reload();
      }
    },
    error: function (data) {
      alert("Erreur ! Veuillez réessayer plus tard");
      console.log(data);
    },
  });
};

// Function de validation des elements en liste d'attente

let validateWaitingUser = (node, token) => {
  $.ajax({
    url: "/apis/userswaiting/validate/" + token,
    type: "GET",
    processData: false,
    contentType: false,
    success: function (data) {
      // console.log(data)
      if (data.status == "success") {
        $(node).remove();
        window.location.reload();
      }
    },
    error: function (data) {
      alert("Erreur ! Veuillez réessayer plus tard");
      // console.log(data)
    },
  });
};

let waiting_users = document.getElementsByClassName("waiting-user");

for (let index = 0; index < waiting_users.length; index++) {
  if (waiting_users.length > 0) {
    const element = waiting_users[index];
    element.children[1].children[0].addEventListener("click", function (e) {
      $("#confBox").fadeIn();
      $("#confBox").css({
        display: "flex",
      });
      $("#confBox .ok").on("click", function (e) {
        validateWaitingUser(
          element,
          element.children[0].children[1].textContent
        );
        $("#confBox").fadeOut();
      });
    });
    element.children[1].children[1].addEventListener("click", function (e) {
      $("#confBox").fadeIn();
      $("#confBox").css({
        display: "flex",
      });
      $("#confBox .ok").on("click", function (e) {
        deleteWaitingUser(element, element.children[0].children[1].textContent);
        $("#confBox").fadeOut();
      });
    });
  }
}

// -------------------------------------------------------------

let delete_user = (node, token) => {
  $.ajax({
    url: "/apis/users/delete/" + token,
    type: "GET",
    contentType: false,
    processData: false,
    success: function (data) {
      // console.log(data)
      if (data.status == "success") {
        $(node).remove();
        window.location.reload();
      } else if (data.status == "failed") {
        alert(data.message);
      }
    },
    error: function (data) {
      console.log(data.status);
      // alert("erreur")
      alert("Erreur ! Veuillez réessayer plus tard");
    },
  });
};
let validate_users = document.querySelectorAll(".user");
for (let index = 0; index < validate_users.length; index++) {
  if (validate_users.length > 0) {
    const element = validate_users[index];
    element.children[1].children[0].addEventListener("click", function (e) {
      // console.log(element.children[0].children[0].textContent)
      $("#confBox").fadeIn();
      $("#confBox").css({
        display: "flex",
      });
      $("#confBox .ok").on("click", function (e) {
        delete_user(element, element.children[0].children[0].textContent);

        $("#confBox").fadeOut();
      });
    });
  }
}

// ----------------------------------------------------------------------

let communicateurs = document.querySelectorAll("#communicateurs-list > div");

$(".communicateur-perso-detail").html("");
let show_communicateur_detail = (token) => {
  if (token !== null) {
    $.ajax({
      url: "/apis/users/get/" + token,
      type: "GET",
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.status != "failed") {
          // remplir les infos sur le communicateur
          let communicateur_detail =
            "<div>Nom & prénoms : " +
            data.first_name +
            " " +
            data.last_name +
            "</div><div>Email : " +
            data.email +
            "</div><div>Sexe : " +
            data.sex +
            "</div><div> Numero Whatsapp : " +
            data.whatsappNumber +
            "</div><div>Pays : " +
            data.country +
            "</div>";
          $(".communicateur-perso-detail").html(communicateur_detail);
          $.ajax({
            url: "/apis/users/godFather/godDauhters/" + token,
            type: "GET",
            processData: false,
            contentType: false,
            success: function (data) {
              $("#communicateur-detail").fadeIn();
              if (data.status != "failed") {
                // remplir les infos sur les fileuls
                let fileuls1 = "";
                let fileuls2 = "";
                let fileuls1_length = 0;
                let fileuls2_length = 0;

                if (data["niveau-1"]) {
                  fileuls1_length = data["niveau-1"].length;
                  for (
                    let index = 0;
                    index < data["niveau-1"].length;
                    index++
                  ) {
                    let element = data["niveau-1"][index];
                    let fileul =
                      '<div class="communicateur-fileul-detail card card-body bg-dark "><div>' +
                      element.first_name +
                      " " +
                      element.last_name +
                      "</div><div style='text-transform : uppercase;' >" +
                      element.type +
                      "</div><div> " +
                      element.email +
                      " </div><div> " +
                      element.phoneNumber +
                      " </div><div> " +
                      element.sex +
                      " </div><div> " +
                      element.country +
                      " </div></div>";
                    fileuls1 += fileul;
                  }
                }

                if (data["niveau-2"]) {
                  fileuls2_length = data["niveau-2"].length;

                  for (
                    let index = 0;
                    index < data["niveau-2"].length;
                    index++
                  ) {
                    let element = data["niveau-2"][index];
                    let fileul =
                      '<div class="communicateur-fileul-detail card card-body bg-dark "><div>' +
                      element.first_name +
                      " " +
                      element.last_name +
                      "</div><div style='text-transform : uppercase;' >" +
                      element.type +
                      "</div><div> " +
                      element.email +
                      " </div><div> " +
                      element.phoneNumber +
                      " </div><div> " +
                      element.sex +
                      " </div><div> " +
                      element.country +
                      " </div></div>";
                    fileuls2 += fileul;
                  }
                }

                let fil =
                  '<h5>Package 1 <span class="badge badge-primary">' +
                  fileuls1_length +
                  "</span> </h5><div>" +
                  fileuls1 +
                  '</div><hr/><h5>Package 2 <span class="badge badge-primary">' +
                  fileuls2_length +
                  "</span> </h5><div>" +
                  fileuls2 +
                  "</div>";
                $(".communicateur-fileul-list").html(fil);
              } else {
                $(".communicateur-fileul-list").html(data.message);
              }
            },
            error: function (data) {
              console.log(data);
              alert("Erreur ! Veuillez réessayer plus tard");
            },
          });
        } else {
          alert(data.message);
        }
      },
      error: function (data) {
        console.log(data);
        alert("Erreur ! Veuillez réessayer plus tard");
      },
    });
  }
};

for (let index = 0; index < communicateurs.length; index++) {
  const element = communicateurs[index];
  element.children[0].addEventListener("click", function (e) {
    window.location.hash = "#communicateurs"
    show_communicateur_detail(element.children[0].children[0].textContent);
  });

  element.children[1].addEventListener("click", function (e) {
    $("#confBox").fadeIn();
    $("#confBox").css({
      display: "flex",
    });
    $("#confBox .ok").on("click", function (e) {
      delete_user(element, element.children[0].children[0].textContent);
      $("#confBox").fadeOut();
    });
  });
}

$("#search-button").on("click", function (e) {
  $.ajax({
    url: "/apis/session/setCurrentPage/" + window.location.hash.substr(1),
    type: "GET",
    success: function (data) {
      window.location.reload();
    },
    error: function (data) {
      alert("Error Session");
      console.log(data);
    },
  });
});
