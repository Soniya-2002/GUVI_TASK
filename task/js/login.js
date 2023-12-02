
function loginUser() {
    // Use jQuery AJAX to send login data to the server
    var formData = {
        'email': $('#email').val(),
        'password': $('#password').val()
    };
    $.ajax({
      type: "POST",
      url: "php/login.php",
      data: $("#loginForm").serialize(),
      dataType: "json",
      success: function(response) {
        if (response.success) {
          // Store user information in local storage
          localStorage.setItem('email', response.userId);
          // Redirect to profile page or perform other actions
          window.location.href = 'profile.php';
        } else {
          // Handle login failure (e.g., show an error message)
          console.error(response.message);
        }
      },
      error: function(error) {
        console.error(error);
        // Handle the error (e.g., show an error message)
      }
    });
  }
  

   
var app = new Vue({
    el: '#form1',
    data: function () {
      return {
      email : "",
      emailBlured : false,
      valid : false,
      submitted : false,
      password:"",
      passwordBlured:false
      }
    },
  
    methods:{
  
      validate : function(){
  this.emailBlured = true;
  this.passwordBlured = true;
  if( this.validEmail(this.email) && this.validPassword(this.password)){
  this.valid = true;
  }
  },
  
  validEmail : function(email) {
     
  var re = /(.+)@(.+){2,}\.(.+){2,}/;
  if(re.test(email.toLowerCase())){
    return true;
  }
  
  },
  
  validPassword : function(password) {
     if (password.length > 7) {
      return true;
     }
  },
  
  submit : function(){
  this.validate();
  if(this.valid){
  this.submitted = true;
  }
  }
    }
  });