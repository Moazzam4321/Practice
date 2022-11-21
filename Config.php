<?php
$Servername= "Localhost";
$Username  = "root";
$password="";
$dbname="datab";
//$Contactno="031544546200";

//Create Connection
$con=mysqli_connect($Servername, $Username, $password,$dbname);
// Check connection
if ($con->connect_error) {
    ?>
  <script>
    alert("Connection Lost");
  </script>
 <?php
  }else{
  ?>
  <script>
    alert("Connection Successful");
  </script>
  <?php
  }
  ?>