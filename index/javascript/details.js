document.addEventListener('DOMContentLoaded', function() {
  // สร้างอาร์เรย์ของปุ่มดูรายละเอียด
 var viewDetailsButtons = document.querySelectorAll('.view-details-btn');
 
 // ดึง modal ด้วย id
 var modal = document.getElementById('myModal');
 
 // สร้างตัวแปรสำหรับแสดงรายละเอียดของทีม
 var modalContent = modal.querySelector('.modal-content');
 
 // เพิ่มอีเวนต์คลิกสำหรับทุกปุ่มดูรายละเอียด
 viewDetailsButtons.forEach(function(button) {
   button.addEventListener('click', function() {
     var teamId = this.getAttribute('data-team-id');
     
     // ปรับแสดงข้อมูลของทีมตาม teamId ใน modalContent ตรงนี้
     
     // แสดง modal
     modal.style.display = 'block';
   });
 });
 
 // สร้างอีเวนต์คลิกสำหรับปุ่มปิด modal
 var closeBtn = document.querySelector('.close');
 closeBtn.addEventListener('click', function() {
   modal.style.display = 'none';
 });
 
 });