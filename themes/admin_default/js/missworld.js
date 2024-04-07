// JS chức năng danh mục 1 cấp dạng 2
function get_onecat2_alias(id, checksess) {
  var title = strip_tags(document.getElementById("element_title").value);
  if (title != "") {
    $.post(
      script_name +
        "?" +
        nv_lang_variable +
        "=" +
        nv_lang_data +
        "&" +
        nv_name_variable +
        "=" +
        nv_module_name +
        "&" +
        nv_fc_variable +
        "=onecat2s&nocache=" +
        new Date().getTime(),
      "changealias=" +
        checksess +
        "&title=" +
        encodeURIComponent(title) +
        "&id=" +
        id,
      function (res) {
        if (res != "") {
          document.getElementById("element_alias").value = res;
        } else {
          document.getElementById("element_alias").value = "";
        }
      }
    );
  }
}

function nv_change_onecat2_weight(id, checksess) {
  var new_weight = $("#change_weight_" + id).val();
  $("#change_weight_" + id).prop("disabled", true);
  $.post(
    script_name +
      "?" +
      nv_lang_variable +
      "=" +
      nv_lang_data +
      "&" +
      nv_name_variable +
      "=" +
      nv_module_name +
      "&" +
      nv_fc_variable +
      "=onecat2s&nocache=" +
      new Date().getTime(),
    "changeweight=" + checksess + "&id=" + id + "&new_weight=" + new_weight,
    function (res) {
      $("#change_weight_" + id).prop("disabled", false);
      var r_split = res.split("_");
      if (r_split[0] != "OK") {
        alert(nv_is_change_act_confirm[2]);
      }
      location.reload();
    }
  );
}

function nv_change_onecat2_status(id, checksess) {
  $("#change_status" + id).prop("disabled", true);
  $.post(
    script_name +
      "?" +
      nv_lang_variable +
      "=" +
      nv_lang_data +
      "&" +
      nv_name_variable +
      "=" +
      nv_module_name +
      "&" +
      nv_fc_variable +
      "=onecat2s&nocache=" +
      new Date().getTime(),
    "changestatus=" + checksess + "&id=" + id,
    function (res) {
      $("#change_status" + id).prop("disabled", false);
      if (res != "OK") {
        alert(nv_is_change_act_confirm[2]);
        location.reload();
      }
    }
  );
}

function nv_delele_onecat2(id, checksess) {
  if (confirm(nv_is_del_confirm[0])) {
    $.post(
      script_name +
        "?" +
        nv_lang_variable +
        "=" +
        nv_lang_data +
        "&" +
        nv_name_variable +
        "=" +
        nv_module_name +
        "&" +
        nv_fc_variable +
        "=onecat2s&nocache=" +
        new Date().getTime(),
      "delete=" + checksess + "&id=" + id,
      function (res) {
        var r_split = res.split("_");
        if (r_split[0] == "OK") {
          location.reload();
        } else {
          alert(nv_is_del_confirm[2]);
        }
      }
    );
  }
}
