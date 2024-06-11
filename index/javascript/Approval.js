$(document).ready(function() {
    $('.status-dropdown, .category-dropdown').on('change', function() {
        var locationId = $(this).data('location-id');
        var value = $(this).val();
        var field = $(this).hasClass('category-dropdown') ? 'category' : 'status';

        $.ajax({
            url: 'admin.php',
            type: 'POST',
            data: {
                locationId: locationId,
                [field]: value
            },
            success: function(response) {
                console.log(`${field} update successful:`, response);
            },
            error: function(xhr, status, error) {
                console.error(`${field} update failed:`, xhr.responseText);
            }
        });
    });
});



// JavaScript function to display a zoomed image
// function zoomImage(imageSrc) {
//     // Create a modal or overlay element
//     var modal = document.createElement('div');
//     modal.classList.add('modal');
    
//     // Create an image element for the zoomed image
//     var zoomedImg = document.createElement('img');
//     zoomedImg.src = imageSrc;
//     zoomedImg.classList.add('zoomed-image');
    
//     // Append the zoomed image to the modal
//     modal.appendChild(zoomedImg);
    
//     // Append the modal to the body
//     document.body.appendChild(modal);
    
//     // Close the modal when clicked outside the image
//     modal.addEventListener('click', function() {
//         modal.remove();
//     });
// }

document.addEventListener('DOMContentLoaded', function () {
    // ค้นหารูปภาพที่มีคลาส "clickable-image"
    var clickableImages = document.querySelectorAll(".clickable-image");

    // เพิ่มการจัดการคลิกสำหรับทุกรูปภาพที่มีคลาส "clickable-image"
    clickableImages.forEach(function (image) {
        image.addEventListener("click", function () {
            // เมื่อรูปถูกคลิก แสดงรูปใหญ่ขึ้น
            showLargeImage(this.src);
        });
    });


// ฟังก์ชันสำหรับแสดงรูปใหญ่ขึ้น
function showLargeImage(imageSrc) {
    // สร้างตัวแสดงรูปใหญ่ขึ้น
    var largeImageContainer = document.createElement("div");
    largeImageContainer.classList.add("large-image-container");

    // สร้างภาพใหญ่
    var largeImage = document.createElement("img");
    largeImage.src = imageSrc;
    largeImage.classList.add("large-image");

    // เพิ่มภาพใหญ่ลงในตัวแสดงรูปใหญ่ขึ้น
    largeImageContainer.appendChild(largeImage);

    // เพิ่มตัวแสดงรูปใหญ่ขึ้นในหน้า
    document.body.appendChild(largeImageContainer);

    // เพิ่มการจัดการคลิกเพื่อปิดรูปใหญ่
    largeImageContainer.addEventListener("click", function () {
        // เมื่อคลิกที่รูปใหญ่ ให้ปิดรูปใหญ่ลง
        document.body.removeChild(largeImageContainer);
    });
}
})// Event listener for dropdowns
document.querySelectorAll('.status-dropdown, .category-dropdown').forEach(item => {
    item.addEventListener('change', event => {
        updateStatus(item);  // Use the same function for status and category updates
    });
});

// Function to send data to the server