/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

var total = 0;

//test
// Lấy thẻ button và đếm số lượt bình chọn
var voteButton = document.getElementById("voteButton");
var voteCount = 0;

// Thêm sự kiện click vào button
voteButton.addEventListener("click", function () {
  // Tăng số lượt bình chọn
  voteCount++;

  // Hiển thị số lượt bình chọn mới
  var voteResult = document.getElementById("voteResult");
  voteResult.textContent = "Total Votes: " + voteCount;

  // Gửi dữ liệu bình chọn lên server
  sendDataToServer(voteCount);
});

// Hàm gửi dữ liệu bình chọn lên server
function sendDataToServer(voteCount) {
  // Tạo XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Định nghĩa phương thức POST và URL của server
  xhr.open("POST", "save-vote.php", true);

  // Thiết lập header cho request
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Xử lý sự kiện khi request hoàn thành
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log("Vote data sent successfully!");
    } else {
      console.log("Error sending vote data!");
    }
  };

  // Gửi dữ liệu bình chọn dưới dạng query string
  var data = "voteCount=" + encodeURIComponent(voteCount);
  xhr.send(data);
}

function nv_check_accept_number(form, num, errmsg) {
  opts = form["option[]"];
  for (var e = (total = 0); e < opts.length; e++)
    if ((opts[e].checked && (total += 1), total > num))
      return alert(errmsg), !1;
}

function nv_sendvoting(form, id, num, checkss, errmsg, captcha) {
  var vals = "0";
  num = parseInt(num);
  captcha = parseInt(captcha);
  if (1 == num) {
    opts = form.option;
    for (var b = 0; b < opts.length; b++)
      opts[b].checked && (vals = opts[b].value);
  } else if (1 < num)
    for (opts = form["option[]"], b = 0; b < opts.length; b++)
      opts[b].checked && (vals = vals + "," + opts[b].value);

  if ("0" == vals && 0 < num) {
    alert(errmsg);
  } else if (captcha == 0 || "0" == vals) {
    nv_sendvoting_submit(id, checkss, vals);
  } else if (captcha == 3) {
    var capt = $('[name="g-recaptcha-response"]', form).val();
    nv_sendvoting_submit(id, checkss, vals, capt);
  } else {
    $("#voting-modal-" + id)
      .data("id", id)
      .data("checkss", checkss)
      .data("vals", vals);
    modalShowByObj("#voting-modal-" + id, "recaptchareset");
  }
  return !1;
}

function nv_sendvoting_submit(id, checkss, vals, capt) {
  $.ajax({
    type: "POST",
    cache: !1,
    url:
      nv_base_siteurl +
      "index.php?" +
      nv_lang_variable +
      "=" +
      nv_lang_data +
      "&" +
      nv_name_variable +
      "=voting&" +
      nv_fc_variable +
      "=main&vid=" +
      id +
      "&checkss=" +
      checkss +
      "&lid=" +
      vals +
      (typeof capt != "undefined" ? "&captcha=" + capt : ""),
    data: "nv_ajax_voting=1",
    dataType: "html",
    success: function (res) {
      var b = $("[onclick*='change_captcha']");
      if (b.length) {
        b.click();
      } else if (
        $("[data-toggle=recaptcha]").length ||
        $("[data-recaptcha3]").length
      ) {
        change_captcha();
      }
      if (res.match(/^ERROR\|/g)) {
        alert(res.substring(6));
      } else {
        modalShow("", res);
      }
    },
  });
}

function nv_sendvoting_captcha(btn, id, msg) {
  var ctn = $("#voting-modal-" + id);
  var capt = "";
  if ($('[name="g-recaptcha-response"]', $(btn).parent()).length) {
    capt = $('[name="g-recaptcha-response"]', $(btn).parent()).val();
  } else {
    capt = $('[name="captcha"]', $(btn).parent()).val();
  }
  if (capt == "") {
    alert(msg);
  } else {
    nv_sendvoting_submit(
      ctn.data("id"),
      ctn.data("checkss"),
      ctn.data("vals"),
      capt
    );
  }
}
