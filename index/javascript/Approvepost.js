document.querySelectorAll('.status-dropdown').forEach(item => {
    item.addEventListener('change', event => {
        var locationId = item.getAttribute('data-post-id'); // Assuming 'data-post-id' attribute is used
        var value = item.value;

        var xhr = new XMLHttpRequest();
        var url = 'managepost.php';
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(`Status update successful1:`, xhr.responseText);
            } else {
                console.error(`Status update failed. Returned status of ` + xhr.status);
            }
        };
        var params = `status=${encodeURIComponent(value)}&locationId=${locationId}`;
        xhr.send(params);
    });
});



// JavaScript function to display a zoomed image
function zoomImage(imageSrc) {
    // Create a modal or overlay element
    var modal = document.createElement('div');
    modal.classList.add('modal');
    
    // Create an image element for the zoomed image
    var zoomedImg = document.createElement('img');
    zoomedImg.src = imageSrc;
    zoomedImg.classList.add('zoomed-image');
    
    // Append the zoomed image to the modal
    modal.appendChild(zoomedImg);
    
    // Append the modal to the body
    document.body.appendChild(modal);
    
    // Close the modal when clicked outside the image
    modal.addEventListener('click', function() {
        modal.remove();
    });
}

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
