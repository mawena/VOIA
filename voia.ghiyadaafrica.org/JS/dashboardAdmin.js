// TODO: Ajouter ce que font les autres hashs
// TODO: euh, rendre possible la recherche à leur niveau
//TODO: Demander a charles de me renvoyer le mot cle et le critere

$("#confBox button.cancel").on("click", function (e) {
  $("#confBox").fadeOut();
});

//-------------------------   LES FONCTIONS DE CHANGEMENT DE PAGE

function show_waiting(params = "on") {
  if (params == "on") {
    $("#waiting").css({
      display: "block",
    });
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
    case "#waiting-sapo":
    case "#waiting-perlage":
    case "#waiting-com-digitale":
      show_communicateurs("off");
      show_waiting();
      show_valides("off");
      show_hs("off");
      $("#page").val("waiting");
      break;

    case "#valides":
    case "#valides-sapo":
    case "#valides-perlage":
    case "#valides-com-digitale":
      show_waiting("off");
      show_communicateurs("off");
      show_hs("off");
      show_valides();
      $("#page").val("valides");
      break;

    case "#communicateurs":
      show_waiting("off");
      show_communicateurs();
      show_hs("off");
      show_valides("off");
      $("#page").val(null);
      break;

    case "#hors-systeme":
    case "#hors-systeme-sapo":
    case "#hors-systeme-perlage":
    case "#hors-systeme-com-digitale":
      show_waiting("off");
      show_communicateurs("off");
      show_valides("off");
      show_hs();
      $("#page").val("hors-systeme");
      break;

    default:
      window.location.hash = "#waiting";
      break;
  }
  window.location.hash = window.location.hash;
};

changePage();
window.addEventListener("hashchange", function (e) {
  changePage();
});

$(" a > li > i").on("click", function (e) {
  e.preventDefault();
  window.location.hash = e.target.parentElement.parentElement.hash;
  $(e.target.parentElement.parentElement.nextElementSibling).slideToggle();
  $(e.target).toggleClass("fa-chevron-circle-left");
  $(e.target).toggleClass("fa-chevron-circle-down");
});

$("#left-side>div>div>div>span").on("click", function (e) {
  $(e.target.parentElement.nextElementSibling).slideToggle();
  // $(e.target.parentElement.nextElementSibling).css({ display: "flex" });
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

// -------------------------------------------------------------------------------------------------------

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

// -----------------------------------------------------------------------------------------

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

let communicateurs = document.querySelectorAll(".communicateurs-list > div");

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
                let fileuls3 = "";
                let fileuls4 = "";
                let fileuls1_length = 0;
                let fileuls2_length = 0;
                let fileuls3_length = 0;
                let fileuls4_length = 0;

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

                if (data["niveau-3"]) {
                  fileuls3_length = data["niveau-3"].length;

                  for (
                    let index = 0;
                    index < data["niveau-3"].length;
                    index++
                  ) {
                    let element = data["niveau-3"][index];
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
                    fileuls3 += fileul;
                  }
                }

                if (data["niveau-4"]) {
                  fileuls4s_length = data["niveau-4"].length;

                  for (
                    let index = 0;
                    index < data["niveau-4"].length;
                    index++
                  ) {
                    let element = data["niveau-4"][index];
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
                    fileuls4 += fileul;
                  }
                }

                // console.log(data)

                let fil = ""

                fil += fileuls1_length != 0 ?'<h5>Package 1 <span class="badge badge-primary">' + fileuls1_length + "</span> </h5><div>" +fileuls1 +'</div><hr/>' : ''
                fil += fileuls2_length != 0 ?'<h5>Package 2 <span class="badge badge-primary">' + fileuls2_length + "</span> </h5><div>" +fileuls2 +'</div><hr/>' : ''
                fil += fileuls3_length != 0 ?'<h5>Package 3 <span class="badge badge-primary">' + fileuls3_length + "</span> </h5><div>" +fileuls3 +'</div><hr/>' : ''
                fil += fileuls4_length != 0 ?'<h5>Package 4 <span class="badge badge-primary">' + fileuls4_length + "</span> </h5><div>" +fileuls4 +'</div><hr/>' : ''

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
    window.location.hash = "#communicateurs";
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
      $("#search_box").submit();
    },
    error: function (data) {
      alert("Error Session");
      console.log(data);
    },
  });
});
