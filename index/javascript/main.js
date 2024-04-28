const icon_change_theme = document.getElementById("theme");
icon_change_theme.onclick = function() {
  let currentTheme = 'light';
  if (icon_change_theme.classList.contains("fa-sun")) {
      document.body.classList.remove("light-theme");
      document.body.classList.add("dark-theme");
      icon_change_theme.className = "fa-solid fa-moon";
      currentTheme = 'dark';
  } else {
      document.body.classList.remove("dark-theme");
      document.body.classList.add("light-theme");
      icon_change_theme.className = "fa-solid fa-sun";
  }
  localStorage.setItem('theme', currentTheme); // Save the current theme to LocalStorage
};
document.addEventListener('DOMContentLoaded', function() {
  const savedTheme = localStorage.getItem('theme') || 'light';
  if (savedTheme === 'dark') {
      document.body.classList.remove("light-theme");
      document.body.classList.add("dark-theme");
      if(icon_change_theme) {
          icon_change_theme.className = "fa-solid fa-moon";
      }
  } else {
      document.body.classList.remove("dark-theme");
      document.body.classList.add("light-theme");
      if(icon_change_theme) {
          icon_change_theme.className = "fa-solid fa-sun";
      }
  }
});



// icon_change_theme.onclick = function() {
//     if (icon_change_theme.classList.contains("fa-sun")) {
//         document.body.classList.remove("light-theme");
//         document.body.classList.add("dark-theme");
//         icon_change_theme.className = "fa-solid fa-moon";
//     } else {
//         document.body.classList.remove("dark-theme");
//         document.body.classList.add("light-theme");
//         icon_change_theme.className = "fa-solid fa-sun";
//     }
// };
$(document).ready(function() {
  $('.navbars li a').on('click', function(event) {
      event.preventDefault();
      const targetUrl = $(this).attr('href');
      if (targetUrl && targetUrl !== '#') {
          window.location.href = targetUrl;
      }
      $('.navbars li a').removeClass('active');
      $(this).addClass('active');
  });
});

$(document).ready(function() {
    $("#search").keyup(function() {
        let searchText = $(this).val();
        if (searchText != "") {
            $.ajax({
                url: "action.php",
                method: "post",
                data: {
                    query: searchText
                },
                success: function(response) {
                    $("#show-list").html(response);
                }
            })
        } else {
            $("#show-list").html("");
        }
    })

    $(document).on('click', 'a', function() {
        $("#search").val($(this).text())
        $("#show-list").html("");
    })
})
