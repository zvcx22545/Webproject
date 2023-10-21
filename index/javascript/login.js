// $(document).ready(function () {
//     $("#loginForm").submit(function (e) {
//         e.preventDefault();

//         let formUrl = $(this).attr("action");
//         let reqMethod = $(this).attr("method");
//         let formData = $(this).serialize();

//         $.ajax({
//             url: formUrl,
//             type: reqMethod,
//             data: formData,
//             success: function (data) {
//                 let result = JSON.parse(data);
//                 if (result.status == "success") {
//                     console.log("Success", result)
//                     Swal.fire("สำเร็จ!", "เข้าสู่ระบบสำเร็จ", result.status).then(function () {
//                         window.location.href = result.redirect;
//                     });
//                 } else {
//                     console.log("Error", result)
//                     Swal.fire("ล้มเหลว!", result.msg, "error");
//                 }
//             }
//         })
//     })
// })
