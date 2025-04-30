<?php
  session_start();

  if(!(isset($_SESSION['email'])))
  {
      header("location:login.php");
  }
  else
  {
      $name = $_SESSION['name'];
      $email = $_SESSION['email'];
  }
?>


<?php 
  function section(){ 
    include 'components/blog_index.php';
  } 
  include('layout.php');

  function extra_js() {
  ?>

    <script type="text/javascript">
      $('#output').hide();

      var loadFile = function(event) {
        $('#output').show();
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
      };

      $(function () {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
        
        // Summernote
        $('#summernote').summernote()
      
      });
    </script>
  <?php
}
?>
    
