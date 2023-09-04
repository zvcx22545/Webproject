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
                    Swal.fire("สำเร็จ!", result.msg, result.status).then(function () {
                        window.location.reload();
                    });
                } else {
                    console.log("Error", result)
                    Swal.fire("ล้มเหลว!", result.msg, result.status);
                }
            }
        })
    })
})