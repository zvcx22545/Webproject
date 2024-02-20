var myBtn = document.getElementById("myBtn");

// เลือก modal โดยใช้ id
var modal = document.getElementById("myModal");

// เลือกปุ่มปิด modal โดยใช้ class "close"
var closeBtn = document.getElementsByClassName("close")[0];

// เมื่อคลิกที่ปุ่ม "ดูรายละเอียด" เปิด modal
myBtn.addEventListener("click", function() {
    modal.style.display = "block";
});

// เมื่อคลิกที่ปุ่มปิด modal ปิด modal
closeBtn.addEventListener("click", function() {
    modal.style.display = "none";
});

// เมื่อคลิกที่พื้นหลังที่อยู่นอก modal ปิด modal
window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});
function openModal(teamId) {
  // หา DOM element ของ Modal โดยใช้ teamId
  var modal = document.getElementById("myModal-" + teamId);

  // เปิด Modal
  modal.style.display = "block";
  var closeBtn = document.getElementsByClassName("close")[0];
  closeBtn.addEventListener("click", function() {
    modal.style.display = "none";
});
// เมื่อคลิกที่พื้นหลังที่อยู่นอก modal ปิด modal
window.addEventListener("click", function(event) {
  if (event.target === modal) {
      modal.style.display = "none";
  }
});
}