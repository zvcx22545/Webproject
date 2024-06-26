$(document).ready(function () {
    if (typeof Swal === 'undefined') {
        console.log('SweetAlert2 is not loaded!');
    } else {
        console.log('SweetAlert2 is loaded successfully.');
    }
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
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: result.msg,
                        icon: result.status,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        // Update the redirect URL to remove the '/index/' directory
                        window.location.href = '/Webproject/index/Profilepage.php';
                    });
                } else {
                    console.log("Error", result)
                    Swal.fire("Failed to upload!", result.msg, "error");
                }
            },
            error: function (error) {
                console.error("Error:", error); 
                Swal.fire("An error occurred!", "Please try again later.", "error");
            }
        });
    });
});
