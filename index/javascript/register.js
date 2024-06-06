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
});

document.querySelectorAll('.toggle-icon').forEach(function(icon) {
    icon.addEventListener('click', function() {
        var targetId = this.getAttribute('data-target');
        var targetInput = document.getElementById(targetId);
        if (targetInput.type === 'password') {
            targetInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            targetInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});