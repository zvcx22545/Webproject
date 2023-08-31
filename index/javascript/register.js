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
            success: function(data) { 
                try {
                    let result = JSON.parse(data); // แปลงเป็น JSON ก่อนใช้
                    if (result.status == "success") {
                        console.log("Success", result)
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: result.msg,
                            icon: result.status,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        console.log("Error", result)
                        Swal.fire({
                            title: 'ล้มเหลว!',
                            text: result.msg,
                            icon: result.status,
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            }
        });
    });
});
