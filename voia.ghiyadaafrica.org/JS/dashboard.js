function show_parainages(params = "on") {
  if (params == "on") {
    $("#parainages").css({
      display: "flex",
    });
  } else if (params == "off") {
    $("#parainages").css({
      display: "none",
    });
  }
}

$("#left-side li:nth(1)").on("click", function (e) {
  show_parainages("off");
});

$("#left-side li:nth(0)").on("click", function (e) {
  show_parainages();
});

$(".parain-tree-header i").on("click", function () {
  $(".parain-tree-header i").toggleClass("fa fa-plus");
  $(".parain-tree-header i").toggleClass("fa fa-minus");
  $("#parain-tree-list").slideToggle(1000);
  $("#parain-tree-list").css({
    display: "flex",
  });
});

$(".product-header i").on("click", function () {
  $(".product-header i").toggleClass("fa fa-plus");
  $(".product-header i").toggleClass("fa fa-minus");
  $("#product-content").slideToggle(1000);
  $("#product-content").css({
    display: "flex",
  });
});
