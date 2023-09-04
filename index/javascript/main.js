// $(document).ready(function() {
//     // Handle file input change to show video container for YouTube links
//     $('#mediaFile').on('change', function() {
//       const mediaUrl = $(this).val();
//       if (mediaUrl.includes('youtube.com') || mediaUrl.includes('youtu.be')) {
//         $('#videoContainer').html(`<iframe class="embed-responsive-item" src="${mediaUrl}" frameborder="0" allowfullscreen></iframe>`);
//       }
//     });
  
//     // Handle the 'Post' button within the modal
//     $('#postButton').on('click', function() {
//       const selectedOption = $('#categoryDropdown').val();
//       const mediaUrl = $('#mediaFile').val();
//       const text = $('#textInput').val();
  
//       // Send data to the server using AJAX (Example)
//       $.ajax({
//         type: 'POST',
//         url: 'process.php', // Replace with your server-side processing script
//         data: {
//           category: selectedOption,
//           mediaUrl: mediaUrl,
//           text: text
//         },
//         success: function(response) {
//           // Handle the server response (if needed)
//           // Close the modal after processing
//           $('#postModal').modal('hide');
//         }
//       });
//     });
//   });
  // JavaScript to handle modal functionality
// JavaScript to handle modal functionality