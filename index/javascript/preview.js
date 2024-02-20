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


var table = document.querySelector("table");

// นับแถวในตาราง
var rowCount = table.rows.length;

// คำนวณจำนวนตาราง (ลบ 1 เพื่อไม่นับแถวหัวตาราง)
var numberOfTables = rowCount - 1;

// หาอิลิเมนต์ที่มี id เป็น "no-table" และกำหนดข้อความให้กับอิลิเมนต์นั้น
var noTableElement = document.getElementById("no-table");
noTableElement.textContent = numberOfTables;

// คำนวณยอดรวมตามจำนวนตาราง (800 บาทต่อตาราง)
var totalAmount = 800 * numberOfTables;
var totalFoot = 4 * numberOfTables;

// หาอิลิเมนต์ที่มี id เป็น "total" และแสดงยอดรวม
var totalElement = document.getElementById("total");
totalElement.textContent = totalAmount;
var totalFottball = document.getElementById("football");
totalFottball.textContent = totalFoot;

});