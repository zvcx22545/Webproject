$(document).ready(function () {
    $("#change_profile_form").submit(function (e) {
        e.preventDefault();

        let formUrl = $(this).attr("action");
        let reqMethod = $(this).attr("method");
        let formData = new FormData(this);

        $.ajax({
            url: formUrl,
            type: reqMethod,
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.status == "success") {
                    console.log("Success", result)
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: result.msg,
                        icon: result.status,
                        timer: 3000,  // ตั้งค่าเวลา 3 วินาที
                        showConfirmButton: false  // ไม่แสดงปุ่มยืนยัน
                    }).then(function () {
                        window.location.reload();
                    });
                } else {
                    console.log("Error", result)
                    Swal.fire("Failed to upload!", result.msg, "error");
                }
            }
        })
    })
})
