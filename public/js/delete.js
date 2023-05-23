// Include jQuery library
document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>');

// Wait for jQuery to be loaded
document.addEventListener("DOMContentLoaded", function() {

  // Include Bootstrap JavaScript library
  var bootstrapScript = document.createElement('script');
  bootstrapScript.src = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js";
  document.head.appendChild(bootstrapScript);

  // Add your custom JavaScript code here
  $(document).ready(function() {
    // Delete member functionality
    $('.delete-member').click(function(e) {
      e.preventDefault();
      var targetModal = $(this).data('target');
      $(targetModal).modal('show');
    });
  });
});
