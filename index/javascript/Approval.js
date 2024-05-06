
// เพิ่ม event listener สำหรับ dropdown
document.querySelectorAll('.status-dropdown').forEach(item => {
    item.addEventListener('change', event => {
        // เรียกใช้ฟังก์ชันที่จะส่งค่าไปยัง update_status.php
        updateStatus(item);
    });
});

// ฟังก์ชันสำหรับส่งค่าไปยัง update_status.php
function updateStatus(dropdown) {
    // รับค่า data-location-id จาก dropdown
    var locationId = dropdown.getAttribute('data-location-id');
    // รับค่าของสถานะที่เลือกจาก dropdown
    var status = dropdown.value;

    // สร้าง XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    // กำหนดเส้นทางของ update_status.php
    var url = 'admin.php';
    // กำหนด method เป็น POST
    xhr.open('POST', url, true);
    // กำหนดค่า Content-Type เป็น application/x-www-form-urlencoded
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // เมื่อ request สำเร็จ
    xhr.onload = function () {
        if (xhr.status === 200) {
            // ดำเนินการตามที่คุณต้องการหลังจากการอัปเดตสถานะสำเร็จ
            console.log(xhr.responseText);
            // ตรวจสอบว่าการอัปเดตสถานะสำเร็จหรือไม่
            if (xhr.responseText === 'Status updated successfully.') {
                // ทำอะไรก็ตามที่คุณต้องการ
            } else {
                // ทำอะไรก็ตามที่คุณต้องการในกรณีที่เกิดข้อผิดพลาด
            }
        } else {
            // กรณีเกิดข้อผิดพลาดในการส่ง request
            console.error('Request failed. Returned status of ' + xhr.status);
        }
    };
    // สร้าง parameter ที่จะส่งไปยัง update_status.php
    var params = 'status=' + status + '&locationId=' + locationId;
    // ส่ง request
    xhr.send(params);
}
