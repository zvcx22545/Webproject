function changePage(page) {
    const pageTitle = document.getElementById('pageTitle');
    if (page === 'team') {
        pageTitle.textContent = 'ข้อมูลรายชื่อทีม';
    } else if (page === 'competition') {
        pageTitle.textContent = 'การแข่งขัน';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // ตรวจสอบ URL และตั้งค่าสถานะของปุ่มและตารางเมื่อโหลดหน้าเว็บ
    // ในที่นี้เราไม่ได้ใช้ตรวจสอบ URL จากการความเข้าถึงแต่ละครั้ง
    document.getElementById("tableOfCompetitionButton").style.zIndex = "2";
    document.getElementById("resultOfCompetitionButton").style.zIndex = "1";
    document.getElementById("resultsTable").style.display = "none";
    document.getElementById("createresults").style.display = "none";
    document.getElementById("form-result").style.display = "none";
    document.getElementById('showScheduleButton').classList.add('active');
    document.getElementById('showScheduleButton').style.color = "white";
    
    // ฟังก์ชันเมื่อคลิกปุ่ม "ตารางการแข่งขัน"
    document.getElementById("showScheduleButton").addEventListener("click", function () {
        // ซ่อนตารางผลการแข่งขัน
        document.getElementById("resultsTable").style.display = "none";
        document.getElementById("createresults").style.display = "none";
        document.getElementById("download-result").style.display = "none";
        document.getElementById("form-result").style.display = "none";
        
        // แสดงตาราง tableCom
        document.getElementById("tableCom").style.display = "table";
        document.getElementById("createCom").style.display = "block";
        document.getElementById("download-stadium").style.display = "block";
        document.getElementById("form-stadium").style.display = "block";

        // กำหนด z-index สำหรับตาราง tableCom ให้สูงกว่า
        document.getElementById("tableOfCompetitionButton").style.zIndex = "2";
        document.getElementById("resultOfCompetitionButton").style.zIndex = "1";

        // เปลี่ยนสถานะของปุ่ม "ตารางการแข่งขัน"
        document.getElementById('showScheduleButton').classList.add('active');
        document.getElementById('showScheduleButton').style.color = "white";

        // ถ้าปุ่ม "ผลการแข่งขัน" มีสถานะ active ให้ลบสถานะ
        if (document.getElementById('showResultsButton').classList.contains('active')) {
            document.getElementById('showResultsButton').classList.remove('active');
            document.getElementById('showResultsButton').style.color = ""; // เรียกคืนสีเดิม (ถ้ามี)
        }
    });

    // ฟังก์ชันเมื่อคลิกปุ่ม "ผลการแข่งขัน"
    document.getElementById("showResultsButton").addEventListener("click", function () {
        // ซ่อนตาราง tableCom
        document.getElementById("tableCom").style.display = "none";
        document.getElementById("createCom").style.display = "none";
        document.getElementById("download-stadium").style.display = "none";
        document.getElementById("form-stadium").style.display = "none";        
        // แสดงตารางผลการแข่งขัน
        document.getElementById("resultsTable").style.display = "table";
        document.getElementById("createresults").style.display = "block";
        document.getElementById("download-result").style.display = "block";
        document.getElementById("form-result").style.display = "block";

        // กำหนด z-index สำหรับตาราง resultsTable ให้สูงกว่า
        document.getElementById("resultOfCompetitionButton").style.zIndex = "2";
        document.getElementById("tableOfCompetitionButton").style.zIndex = "1";

        // เปลี่ยนสถานะของปุ่ม "ผลการแข่งขัน"
        document.getElementById('showResultsButton').classList.add('active');
        document.getElementById('showResultsButton').style.color = "white";

        // ถ้าปุ่ม "ตารางการแข่งขัน" มีสถานะ active ให้ลบสถานะ
        if (document.getElementById('showScheduleButton').classList.contains('active')) {
            document.getElementById('showScheduleButton').classList.remove('active');
            document.getElementById('showScheduleButton').style.color = ""; // เรียกคืนสีเดิม (ถ้ามี)
        }
    });
    
    // เรียกฟังก์ชัน changePage เมื่อหน้าเว็บโหลด
    changePage('competition');  // หรือ 'result' ตามหน้าที่คุณต้องการแสดงเป็นหน้าแรก



var modal = document.getElementById("myModal");
var btn = document.getElementById("createCom");

var span = document.getElementsByClassName("close")[0];

// เมื่อผู้ใช้คลิกที่ปุ่ม, เปิด modal
btn.onclick = function () {
    modal.style.display = "block";
}

// เมื่อผู้ใช้คลิกที่ <span> (x), ปิด modal
span.onclick = function () {
    modal.style.display = "none";
}

// เมื่อผู้ใช้คลิกที่ใดก็ตามนอกเหนือจาก modal, ปิด modal นั้น
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var form = document.getElementById('tableDataForm');
var table = document.getElementById('tableCom');
var modal = document.getElementById('myModal'); // ตรวจสอบให้แน่ใจว่าได้รับองค์ประกอบ modal อย่างถูกต้อง

form.onsubmit = function(event) {
    event.preventDefault();

    var columnNameInput = document.getElementById("columnName");
    var columnStadiumInput = document.getElementById("columnStadium");
    var arenaImageInput = document.getElementById("arenaImage");

    if (!columnNameInput || !columnStadiumInput || !arenaImageInput) {
        console.error("One or more input elements not found.");
        return;
    }

    var competName = columnNameInput.value;
    var arenaName = columnStadiumInput.value;
    var arenaImage = arenaImageInput.files[0];

    if (!arenaImage) {
        console.error("No file selected.");
        return;
    }

    // Create a FormData object to handle text and file data
    var formData = new FormData();
    formData.append('competName', competName);
    formData.append('arenaName', arenaName);
    formData.append('image', arenaImage);

    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/addcompetition", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Data sent successfully');
            // Additional code to handle successful submission...
            location.reload(); //รีเฟรชหน้าเว็บ
        } else {
            console.error('Error sending data: ' + xhr.status);
        }
        modal.style.display = "none"; //ปิด modal
    };

    xhr.onerror = function () {
        console.error('Error sending data');
    };

    xhr.send(formData);
};

// การจัดการ modal สำหรับ 'เพิ่มตารางผล'
// การจัดการ modal สำหรับเพิ่มข้อมูลในตารางผลการแข่งขัน

var modal2 = document.getElementById("myModal2");
var btnResults = document.getElementById("createresults");
var span2 = modal2.getElementsByClassName("close")[0]; // อาจจำเป็นต้องปรับแต่งตามโครงสร้าง HTML ของคุณ

btnResults.onclick = function () {
    modal2.style.display = "block";
}

span2.onclick = function () {
    modal2.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

// การจัดการการส่งข้อมูลจากฟอร์มใน modal สำหรับเพิ่มข้อมูลในตารางผลการแข่งขัน
var form2 = document.getElementById('tableDataForm2');
var resultsTable = document.getElementById('resultsTable');

form2.onsubmit = function (event) {
    event.preventDefault();

    var columnNameInput = document.getElementById("columnName2");
    var resultImageInput = document.getElementById("columnImage2");
    let competitionInput = document.getElementById("competition-round");

    if (!columnNameInput || !resultImageInput || !competitionInput) {
        console.error("One or more input elements not found.");
        return;
    }

    var idarena = columnNameInput.value;
    var resultImage = resultImageInput.files[0];
    let competitionround = competitionInput.value;

    if (!resultImage) {
        console.error("No file selected.");
        return;
    }


    // Create a FormData object to handle text and file data
    var formData = new FormData();
    formData.append('idarena', idarena);
    formData.append('image', resultImage);
    formData.append('Competition_round', competitionround);



    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/addresult", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Data sent successfully');
            // Additional code to handle successful submission...
            location.reload(); //รีเฟรชหน้าเว็บ
        } else {
            console.error('Error sending data: ' + xhr.status);
        }
        modal2.style.display = "none"; //ปิด modal
    };

    xhr.onerror = function () {
        console.error('Error sending data');
    };

    xhr.send(formData);
}
});