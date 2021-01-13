
$("#cgu-accepted").on("change", function (e) {
  if ($("#cgu-accepted").is(":checked")) {
    $("input[value='Inscription']").prop("disabled", false);
  } else {
    $("input[value='Inscription']").prop("disabled", true);
  }
});

for (let index = 0; index < country_list_index.length; index++) {
  let element = country_list_index[index];
  countryFill +=
    '<option value="' +
    pays[element]["name"] +
    '">' +
    pays[element]["name"] +
    "(<span>" +
    pays[element]["phone_code"] +
    "</span>)</option>";
}

$("select#country").html(countryFill);

$("#numero").val("00" + getCodeByCountry(pays, $("select#country").val()));
$("#numero_whatsapp").val(
  "00" + getCodeByCountry(pays, $("select#country").val())
);
$("select#country").change(function (e) {
  $("#numero").val("00" + getCodeByCountry(pays, $(e.target).val()));
  $("#numero_whatsapp").val("00" + getCodeByCountry(pays, $(e.target).val()));
  console.log($(e.target).val());
});
