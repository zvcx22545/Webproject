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
// function zoomImage(imageSrc) {
//     // Create a modal or overlay element
//     var modal = document.createElement('div');
//     modal.style.position = 'fixed';
//     modal.style.left = '0';
//     modal.style.top = '0';
//     modal.style.width = '100%';
//     modal.style.height = '100%';
//     modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)'; // Semi-transparent background
//     modal.style.display = 'flex';
//     modal.style.justifyContent = 'center';
//     modal.style.alignItems = 'center';
//     modal.style.zIndex = '10000'; // Ensure it's on top of other elements

//     // Create an image element for the zoomed image
//     var zoomedImg = document.createElement('img');
//     zoomedImg.src = imageSrc;
//     zoomedImg.style.maxWidth = '90%';  // Max width to prevent overflow
//     zoomedImg.style.maxHeight = '90%'; // Max height to maintain aspect ratio
//     zoomedImg.style.margin = 'auto';   // Center the image

//     // Append the zoomed image to the modal
//     modal.appendChild(zoomedImg);

//     // Append the modal to the body
//     document.body.appendChild(modal);

//     // Close the modal when clicked
//     modal.addEventListener('click', function(event) {
//         if (event.target === modal) { // Ensure that clicks on the image do not close the modal
//             document.body.removeChild(modal);
//         }
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
    // Create the modal container
    var largeImageContainer = document.createElement("div");
    largeImageContainer.classList.add("large-image-container");

    // Create the image element
    var largeImage = document.createElement("img");
    largeImage.src = imageSrc;
    largeImage.classList.add("large-image");

    // Append the image to the modal container
    largeImageContainer.appendChild(largeImage);

    // Append the modal container to the body
    document.body.appendChild(largeImageContainer);

    // Add an event listener to close the modal when clicked
    largeImageContainer.addEventListener("click", function () {
        document.body.removeChild(largeImageContainer);
    });
}

})// Event listener for dropdowns
