$(document).ready(function () {
    $("#registerForm").submit(function (e) {
        e.preventDefault();

        let formUrl = $(this).attr("action");
        let reqMethod = $(this).attr("method");
        let formData = $(this).serialize();

        $.ajax({
            url: formUrl,
            type: reqMethod,
            data: formData,
            success: function (data) {
                let result = JSON.parse(data);
                if (result.status == "success") {
                    console.log("Success", result)
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: result.msg,
                        icon: result.status,
                        confirmButtonText: "ตกลง"
                    }).then(function () {
                        window.location.href = "login.php";
                    });
                } else {
                    console.log("Error", result)
                    Swal.fire("ล้มเหลว!", result.msg, result.status);
                }
            }
        })
    });

    // Toggle password visibility

    $(".password-toggle i").click(function() {
        const input = $(this).prev('input[type="password"]');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
});
