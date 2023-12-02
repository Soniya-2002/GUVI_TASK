$(document).ready(function() {
    // Load user profile details on page load
    loadProfileDetails();
  });
  
  function loadProfileDetails() {
    // Retrieve user profile details using user ID from local storage
    const userId = localStorage.getItem('userId');
  
    $.ajax({
      type: "GET",
      url: `get_profile.php?userId=${userId}`,
      dataType: "json",
      success: function(response) {
        // Populate profile details in the HTML
        $("#profileDetails").html(`
          <p><strong>Date of Birth:</strong> ${response.dob}</p>
          <p><strong>Contact:</strong> ${response.contact}</p>
          <p><strong>Age:</strong> ${response.age}</p>
        `);
  
        // Populate editable fields in the form
        $("#dob").val(response.dob);
        $("#contact").val(response.contact);
        $("#age").val(response.age);
      },
      error: function(error) {
        console.error(error);
        // Handle the error (e.g., show an error message)
      }
    });
  }
  
  function updateProfile() {
    // Use jQuery AJAX to send updated profile data to the server
    const userId = localStorage.getItem('userId');
  
    $.ajax({
      type: "POST",
      url: "update_profile.php",
      data: $("#editProfileForm").serialize() + `&userId=${userId}`,
      success: function(response) {
        console.log(response);
        // Handle the response (e.g., show a success message)
        loadProfileDetails(); // Reload profile details after update
      },
      error: function(error) {
        console.error(error);
        // Handle the error (e.g., show an error message)
      }
    });
  }
  