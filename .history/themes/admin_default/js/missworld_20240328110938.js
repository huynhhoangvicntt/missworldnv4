// JS chức năng danh mục đa cấp
function get_cat_alias(id, checksess) {
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
        "=cats&nocache=" +
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

function nv_change_cat_weight(id, checksess) {
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
      "=cats&nocache=" +
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

function nv_change_cat_status(id, checksess) {
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
      "=cats&nocache=" +
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

function nv_delele_cat(id, checksess) {
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
        "=cats&nocache=" +
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

// JS chức năng danh mục 1 cấp dạng 1
function nv_change_onecat1_weight(id, checksess) {
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
      "=onecat1s&nocache=" +
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

function nv_change_onecat1_status(id, checksess) {
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
      "=onecat1s&nocache=" +
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

function nv_delele_onecat1(id, checksess) {
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
        "=onecat1s&nocache=" +
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

// JS dùng định dạng tiền VND
function FormatNumber(str) {
  var strTemp = GetNumber(str);
  if (strTemp.length <= 3) {
    return strTemp;
  }
  strResult = "";
  for (var i = 0; i < strTemp.length; i++) {
    strTemp = strTemp.replace(".", "");
  }
  var m = strTemp.lastIndexOf(",");
  if (m == -1) {
    for (var i = strTemp.length; i >= 0; i--) {
      if (strResult.length > 0 && (strTemp.length - i - 1) % 3 == 0) {
        strResult = "." + strResult;
      }
      strResult = strTemp.substring(i, i + 1) + strResult;
    }
  } else {
    var strphannguyen = strTemp.substring(0, strTemp.lastIndexOf(","));
    var strphanthapphan = strTemp.substring(
      strTemp.lastIndexOf(","),
      strTemp.length
    );
    var tam = 0;
    for (var i = strphannguyen.length; i >= 0; i--) {
      if (strResult.length > 0 && tam == 4) {
        strResult = "." + strResult;
        tam = 1;
      }
      strResult = strphannguyen.substring(i, i + 1) + strResult;
      tam = tam + 1;
    }
    strResult = strResult + strphanthapphan;
  }
  return strResult;
}

function GetNumber(str) {
  //var count = 0;
  for (var i = 0; i < str.length; i++) {
    var temp = str.substring(i, i + 1);
    if (!(temp == "," || temp == "." || (temp >= 0 && temp <= 9))) {
      alert("Mời nhập vào số");
      return str.substring(0, i);
    }
    if (temp == " ") {
      return str.substring(0, i);
    }
    if (temp == ",") {
      // Ngược dấu ,
      //if (count > 0) {
      //    return str.substring(0, ipubl_date);
      //}
      //count++;
    }
  }
  return str;
}

// Js phần main conent
function get_content_alias(id, checksess) {
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
        "=main&nocache=" +
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

function nv_change_content_status(id, checksess) {
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
      "=main&nocache=" +
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

function nv_delele_content(id, checksess) {
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
        "=main&nocache=" +
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

function nv_content_action(oForm, checkss, msgnocheck) {
  var fa = oForm["idcheck[]"];
  var listid = "";
  if (fa.length) {
    for (var i = 0; i < fa.length; i++) {
      if (fa[i].checked) {
        listid = listid + fa[i].value + ",";
      }
    }
  } else {
    if (fa.checked) {
      listid = listid + fa.value + ",";
    }
  }

  if (listid != "") {
    var action = document.getElementById("action-of-content").value;
    if (action == "delete") {
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
            "=main&nocache=" +
            new Date().getTime(),
          "delete=" + checkss + "&listid=" + listid,
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
  } else {
    alert(msgnocheck);
  }
}

// Js khi load trang
$(document).ready(function () {
  // Định dạng tiền
  $(".ipt-money-d").on("keyup", function () {
    $(this).val(FormatNumber($(this).val()));
  });
});
