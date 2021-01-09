$("#cgu button.btn.btn-secondary").on("click", function (e) {
  $("#cgu-box").fadeOut();
});

$("#pdc button.btn.btn-secondary").on("click", function (e) {
  $("#pdc-box").fadeOut();
});

$("#footer>div>div:nth-child(1)").on("click", function (e) {
  $("#cgu-box").fadeIn();
  $("#cgu-box").css({
    display: "flex",
  });
});

$("#footer>div>div:nth-child(2)").on("click", function (e) {
  $("#pdc-box").fadeIn();
  $("#pdc-box").css({
    display: "flex",
  });
});

$(".cgu-show").on("click", function (e) {
  $("#cgu-box h3").html("Conditions générales d'utilisation");
  $("#cgu-content").slideDown();
  $("#cgu-head").slideUp();
});

$(".cgu-box-show").on("click", function (e) {
  $("#footer>div>div:nth-child(1)").trigger("click");
});

$("#pdc-show").on("click", function (e) {
  $("#cgu-box").fadeOut();
  $("#pdc-box").fadeIn();
  $("#pdc-box").css({
    display: "flex",
  });
});
