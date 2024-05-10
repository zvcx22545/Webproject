$(document).ready(function () {
    $("#Addlocation").submit(function (e) {
        e.preventDefault();

        let formUrl = $(this).attr("action");
        let reqMethod = $(this).attr("method");
        let formData = new FormData(this); // Updated to handle file uploads

        $.ajax({
            url: formUrl,
            type: reqMethod,
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    title: data.status === "success" ? "สำเร็จ!" : "ล้มเหลว!",
                    text: data.message,
                    icon: data.status === "success" ? "success" : "error",
                    confirmButtonText: "ตกลง"
                });
            },
            error: function(xhr, status, error) {
                console.error("Request failed", status, error);
                let errorText = xhr.responseText ? xhr.responseText : "ไม่สามารถดำเนินการได้ โปรดลองอีกครั้ง";
                Swal.fire({
                    title: "เกิดข้อผิดพลาด!",
                    html: `<p>ไม่สามารถดำเนินการได้ โปรดลองอีกครั้ง</p><p>Status: ${status}</p><p>Error: ${error}</p><p>Response: ${errorText}</p>`,
                    icon: "error"
                });
            }
        });
    });
});
