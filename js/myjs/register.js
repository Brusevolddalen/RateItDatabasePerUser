$(document).ready(function() {

  $('select').material_select();

  $("#registerForm").submit(function(e) {
    console.log(e);
    e.preventDefault();
  });

});
