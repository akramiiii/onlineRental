"use strict";

// const { validate } = require("numeral");
var site_url = 'http://127.0.0.1:8000/';
var times = null;
var t = 180;
$(document).ready(function () {
  $(".cat_item").mouseover(function () {
    var li_width = $(this).css('width');
    var ul_width = $(".index-cat-list ul").width();
    var a = li_width.replace("px", "");
    var right = ul_width - $(this).offset().left - a + 15; // alert($(window).width());

    $(".cat_hover").css('width', li_width);
    $(".cat_hover").css('right', right);
    $(".cat_hover").css('transform', 'scaleX(1)');
    $(".li_div").hide();
    $(".li_div", this).show();
  });
  $(".index-cat-list").mouseleave(function () {
    $(".cat_hover").css("transform", "scaleX(0)");
    $(".li_div").hide();
  });
  $(".discount_left_item div").click(function () {
    $(".discount_left_item div").removeClass('active');
    var id = $(this).attr('data-id');
    $(".discount_box_content .item").hide();
    $('#discount_box_link_' + id).show();
    $(this).addClass('active');
  });
  $(".discount_box_footer .slide-amazing").click(function () {
    var id = $(this).attr("data-id");
    $(".discount_box_content .item").hide();
    $("#discount_box_link_" + id).show();
    $(".discount_box_footer .slide-amazing").removeClass("active");
    $(this).addClass("active");
  });
  var discount_slider_count = 0;
  var discount_slider_number = 0;
  var discount_box_footer = $('.discount_box_footer').css('display');

  if (discount_box_footer == 'none') {
    discount_slider_count = $('.discount_left_item div').length;
    var discount_slider = setInterval(function () {
      var discount_box_footer = $(".discount_box_footer").css("display");

      if (discount_box_footer == 'none') {
        $(this).addClass('active');
        discount_slider_number++;
        $(".discount_left_item div").removeClass("active");
        $(".discount_box_content .item").hide();

        if (discount_slider_number >= discount_slider_count) {
          discount_slider_number = 0;
        }

        $("#item_number_" + discount_slider_number).addClass("active");
        var id = $("#item_number_" + discount_slider_number).attr("data-id");
        $("#discount_box_link_" + id).show();
      } else {
        clearInterval(discount_slider);
      }
    }, 5000);
  }

  $('.send_btn').hover(function () {
    $('.send_btn .line').addClass('line2');
  }, function () {
    $(".send_btn .line").removeClass("line2");
  });
  $(".show_more_important_item").click(function () {
    var more_important_item = $('.more_important_item').css('display');

    if (more_important_item == 'none') {
      $(".more_important_item").slideDown();
      $(".show_more_important_item").text('موارد کمتر');
      $(".show_more_important_item").addClass('minus_important_item');
    } else {
      $(".more_important_item").slideUp();
      $(".show_more_important_item").text("موارد بیشتر");
      $(".show_more_important_item").removeClass("minus_important_item");
    }
  });
  $('#register_btn').click(function () {
    var mobile = $('#register_mobile').val();
    var password = $("#register_password").val();
    var result1 = validate_register_mobile(mobile);
    var result2 = validate_register_password(password);

    if (result1 && result2) {
      $("#register_form").submit();
    }
  });
  $(".continue_order_registration").click(function () {
    var date = $('#input1').val();
    var pledge = $('#pledge_id').val();
    var delivery = $("#delivery_id").val();
    var res1 = validate_input1(date);
    var res2 = validate_pledge(pledge);
    var res3 = validate_delivery(delivery);

    if (res1 && res2 && res3) {
      $("#add_order").submit();
    }
  });
  $('#resend_active_code').click(function () {
    if (t == 0) {
      var mobile = $('#user_mobile').val();
      $.ajaxSetup({
        'headers': {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var url = site_url + 'ajax/resend';
      $.ajax({
        url: url,
        type: "POST",
        data: "mobile=" + mobile,
        success: function success(response) {
          t = 180;
          startTimer();
        },
        error: function error(jqXhr, textStatus, _error) {
          t = 180;
          startTimer();
        }
      });
    }
  });
  $("#forget_password_code").click(function () {
    if (t == 0) {
      var mobile = $("#mobile").val();
      $.ajaxSetup({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
      });
      var url = site_url + "ajax/resend";
      $.ajax({
        url: url,
        type: "POST",
        data: "mobile=" + mobile + "&forget_password=ok",
        success: function success(response) {
          t = 180;
          startTimer();
        },
        error: function error(jqXhr, textStatus, _error2) {
          t = 180;
          startTimer();
        }
      });
    }
  });
  $("#active_account_btn").click(function () {
    $('#active_account_form').submit();
  });
  $('#login_btn').click(function () {
    var mobile = $("#login_mobile").val();
    var password = $("#login_password").val();
    var result1 = validate_login_mobile(mobile);
    var result2 = validate_login_password(password);

    if (result1 && result2) {
      $("#login_form").submit();
    }
  });
  $("#admin_login_btn").click(function () {
    var username = $("#username").val();
    var password = $("#password").val();
    var result1 = validate_login_username(username);
    var result2 = validate_login_password(password);

    if (result1 && result2) {
      $("#admin_login_form").submit();
    }
  });
  $('#login_remember').click(function () {
    if ($(this).hasClass('active')) {
      $(this).removeClass("active");
      $('#remember').removeAttr('checked');
    } else {
      $(this).addClass("active");
      $("#remember").attr("checked", true);
    }
  });
  $('#cart_btn').click(function () {
    $('#add_cart_form').submit(); // $("#roz_send").submit();
  });
  $(".renting_data_box .header_box").click(function () {
    var el = $(this).parent().find('.ordering_product_list');
    var display = el.css('display');

    if (display == 'block') {
      el.slideUp();
    } else {
      el.slideDown();
    }
  }); // $(".cart_header_box .dropdown_menu").on({
  //     'click' : function(e){
  //         e.stopPropagation;
  //     }
  // });

  $(".logout").click(function () {
    $("#logout_form").submit();
  });
  $("#forget_password").click(function () {
    var mobile = $("#login_mobile").val();
    var result = validate_login_mobile(mobile);

    if (result) {
      $("#forget_password_form").submit();
    }
  });
  $("#update_password_btn").click(function () {
    var mobile = $("#login_mobile").val();
    var password = $("#login_password").val();
    var password_confirmation = $("#password_confirmation").val();
    var result1 = validate_login_mobile(mobile);
    var result2 = validate_password_reset(password);
    var result3 = validate_password_confirmation(password, password_confirmation);

    if (result1 && result2 && result3) {
      $("#updatePasswordForm").submit();
    }
  });
});
var img_count = 0;
var img = 0;

function load_slider(count) {
  img_count = count;
  setInterval(next, 5000);
}

function next() {
  $('.slider_bullet_div span').removeClass('active');

  if (img == img_count - 1) {
    img = -1;
  }

  img = img + 1;
  $('.slide_div').hide();
  document.getElementById('slider_img_' + img).style.display = 'block';
  $("#slider_bullet_" + img).addClass('active');
}

function previous() {
  $(".slider_bullet_div span").removeClass("active");
  img = img - 1;

  if (img == -1) {
    img = img_count - 1;
  }

  $(".slide_div").hide();
  document.getElementById("slider_img_" + img).style.display = "block";
  $("#slider_bullet_" + img).addClass("active");
}

function validate_register_mobile(mobile_number) {
  if (mobile_number.toString().trim() == "") {
    $('#register_mobile').addClass('validate_error_border');
    $('#mobile_error_message').show().text('لطفا شماره موبایل خود را وارد نمایید');
    return false;
  } else if (check_mobile_number(mobile_number)) {
    $('#register_mobile').addClass('validate_error_border');
    $('#mobile_error_message').show().text('شماره موبایل وارد شده معتبر نمی باشد');
    return false;
  } else {
    $("#mobile_error_message").hide();
    $("#register_mobile").removeClass("validate_error_border");
    return true;
  }
}

function validate_password_reset(password) {
  if (password.toString().trim().length < 6) {
    $("#login_password").addClass("validate_error_border");
    $("#password_error_message").show().text("کلمه عبور باید حداقل شامل 6 کاراکتر باشد");
    return false;
  } else {
    $("#password_error_message").hide();
    $("#login_password").removeClass("validate_error_border");
    return true;
  }
}

function validate_register_password(password) {
  if (password.toString().trim().length < 6) {
    $('#register_password').addClass('validate_error_border');
    $('#password_error_message').show().text('کلمه عبور باید حداقل شامل 6 کاراکتر باشد');
    return false;
  } else {
    $("#password_error_message").hide();
    $("#register_password").removeClass("validate_error_border");
    return true;
  }
}

function check_mobile_number(mobile_number) {
  if (isNaN(mobile_number)) {
    return true;
  } else {
    if (mobile_number.toString().trim().length == 11) {
      if (mobile_number.toString().charAt(0) == '0' && mobile_number.toString().charAt(1) == '9') {
        return false;
      } else {
        return true;
      }
    } else if (mobile_number.toString().trim().length == 10) {
      if (mobile_number.toString().charAt(0) == '9') {
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
  }
}

function startTimer() {
  times = setInterval(function () {
    t = t - 1;
    var m = Math.floor(t / 60);
    var s = t - m * 60;

    if (s.toString().length == 1) {
      s = "0" + s;
    }

    var text = "0" + m.toString() + ":" + s.toString();

    if (t == 0) {
      clearInterval(times);
      times = null;
      $('#timer').text("");
    } else {
      $("#timer").text(text);
    }
  }, 1000);
}

function validate_login_mobile(mobile_number) {
  if (mobile_number.toString().trim() == "") {
    $("#login_mobile").addClass("validate_error_border");
    $("#mobile_error_message").show().text("لطفا شماره موبایل خود را وارد نمایید");
    return false;
  } else if (check_mobile_number(mobile_number)) {
    $("#login_mobile").addClass("validate_error_border");
    $("#mobile_error_message").show().text("شماره موبایل وارد شده معتبر نمی باشد");
    return false;
  } else {
    $("#mobile_error_message").hide();
    $("#login_mobile").removeClass("validate_error_border");
    return true;
  }
}

function validate_login_password(password) {
  if (password.toString().trim() == "") {
    $("#login_password").addClass("validate_error_border");
    $("#password_error_message").show().text("لطفا کلمه عبور خود را وارد نمایید");
    return false;
  } else {
    $("#password_error_message").hide();
    $("#password_error_message").removeClass("validate_error_border");
    return true;
  }
}

validate_login_username = function validate_login_username(username) {
  if (username.toString().trim() == "") {
    $("#username").addClass("validate_error_border");
    $("#username_error_message").show().text("لطفا نام کاربری خود را وارد نمایید");
    return false;
  } else {
    $("#username").removeClass("validate_error_border");
    $("#username_error_message").hide();
    return true;
  }
};

function validate_input1(date) {
  if (date.toString().trim() == "") {
    $("#input1").addClass("validate_error_border");
    $("#date_error_message").show().text("لطفا تاریخ دریافت کالای مورد نظرتان را وارد نمایید");
    return false;
  } else {
    $("#date_error_message").hide();
    $("#input1").removeClass("validate_error_border");
    return true;
  }
}

function validate_pledge(pledge) {
  if (pledge.toString().trim() == "") {
    $("#pledge .bootstrap-select .btn").addClass("validate_error_border");
    $("#pledges_error_message").show().text("لطفا یک مورد را انتخاب نمایید");
    return false;
  } else {
    $("#pledges_error_message").hide();
    $("#pledge .bootstrap-select .btn").removeClass("validate_error_border");
    return true;
  }
}

function validate_delivery(delivery) {
  if (delivery.toString().trim() == "") {
    $("#delivery .bootstrap-select .btn").addClass("validate_error_border");
    $("#delivery_error_message").show().text("لطفا یک مورد را انتخاب نمایید");
    return false;
  } else {
    $("#delivery_error_message").hide();
    $("#delivery .bootstrap-select .btn").removeClass("validate_error_border");
    return true;
  }
}

function validate_password_confirmation(password, password_confirmation) {
  if (password.toString().trim().length >= 6) {
    if (password_confirmation != password) {
      $("#password_confirmation").addClass("validate_error_border");
      $("#password_confirmation_error_message").show().text("تکرار کلمه عبور مطابقت ندارد");
      return false;
    } else {
      $("#password_confirmation").removeClass("validate_error_border");
      $("#password_confirmation_error_message").hide();
      return true;
    }
  } else {
    return false;
  }
}