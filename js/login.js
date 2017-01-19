/**
 *登录的客户端输入合法性监测
 **/
function login_check() {
    if ($("#username").val().length != 11 || isNaN($("#username").val())) {
        alert("手机号码格式错误");
        return false;
    }
    if ($("#password").val().length < 6) {
        alert("密码错误");
        return false;
    }
    return true;
}

/**
 *关闭弹出登录框
 **/
function close_login_panel() {
    $(".cover").fadeOut(200);
}

/**
 *打开弹出登录框
 **/
function open_login_panel() {
    $(".cover").fadeIn(200);
}

/**
 *忘记密码的表单验证
 **/
function check_forget() {
    if ($("#f_username").val().length != 11 || isNaN($("#f_username").val())) {
        alert("手机号码格式错误");
        return false;
    }
    if ($("#f_verify_code").val().length < 4 || isNaN($("#f_verify_code").val())) {
        alert("验证码错误");
        return false;
    }
    if ($("#f_new_password").val().length < 6) {
        alert("密码设置不能少于6位");
        return false;
    }
    if ($("#f_new_password_repeat").val() != $("#f_new_password").val()) {
        alert("两次密码不一致");
        return false;
    }
    return true;
}

/**
 *搜索关键字不能为空验证
 **/
function check_search() {
    if ($("#search_keywords").val().length < 1) {
        alert("搜索关键字不能为空");
        return false;
    }
    return true;
}

/**
 *发送验证码
 **/
function get_verify_code() {
    var phone = $("#f_username").val();
    if ($("#f_username").val().length != 11 || isNaN($("#f_username").val())) {
        alert("手机号码格式错误");
        return false;
    }
    $.ajax({
        url: 'sms/sendSMS.php',
        type: 'POST',
        data: {
            phone: phone
        },
        dataType: "json",
        success: function(data) {
            //console.log(data);
            if (data.status == 'true') {
                sms = true;
                code = data.code;
                $("#get_verify_code").html("验证码已发送");
            } else {
                alert("短信发送失败");
            }
        }
    });
}

/**
 *注册的表单验证
 **/
function check_register() {
    // if($("#get_verify_code").html() != "验证码已发送")
    // {
    //   alert("还未发送验证码");
    //   return false;
    // }
    if ($("#f_username").val().length != 11 || isNaN($("#f_username").val())) {
        alert("手机号码格式错误");
        return false;
    }
    if ($("#f_verify_code").val().length < 4 || isNaN($("#f_verify_code").val())) {
        alert("验证码错误");
        return false;
    }
    if ($("#f_new_password").val().length < 6) {
        alert("密码设置不能少于6位");
        return false;
    }
    if ($("#f_new_password_repeat").val() != $("#f_new_password").val()) {
        alert("两次密码不一致");
        return false;
    }
    return true;
}
