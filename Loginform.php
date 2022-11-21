<?php 
  session_start();
require 'Config.php';
 $errormessege="";
if (isset($_POST['email']) && isset($_POST['password']) && $_POST['email'] != '' && $_POST['password'] != '') //when form submitted
{
  $email=$_POST['email'];
  $password=$_POST['password'];
  $sel = mysqli_query($con, "SELECT * FROM userdata WHERE Email='".$email."' && password = '".$password."'");
  $row = mysqli_fetch_assoc($sel);
  if (mysqli_num_rows($sel) > 0) 
  {
    if ($email === $row['Email'] && password_verify($password ,$row['Password']))
    {
      $_SESSION['email'] = $email; //write login to server storage
      $_SESSION['$password']=$password; 
      setcookie ("email",$email,time()+ 3600);
      setcookie ("password",$password,time()+ 3600);
      header('Location: Homepage.php'); //redirect to main
    }
  }
  else
  {
    echo $errormessege="<script>alert('Wrong login or password');</script>";
  }
}
else
{
  echo $errormessege="<script>alert('UserName and password field required');</script>";
} 
if (empty($errormessege)) 
{
  $email= $_SESSION['email'];
  $sql = "SELECT * FROM userdata WHERE EMAIL = '$email'";
  $res = mysqli_query($con,$sql);
  if (mysqli_num_rows($res) > 0) {
      $row = mysqli_fetch_assoc($res);
      if ($row['EMAIL'] == $email) {
          if (password_verify($password, $row['PASSWORD'])) {
              $name = $row['NAME'];
              $email = $row['EMAIL'];
              $age = $row['AGE'];
              $gender = $row['GENDER'];
              $image = $row['Image'];             
              $_SESSION['Name'] = $name;
              $_SESSION['Age'] = $age;
              $_SESSION['Gender'] = $gender;
              $_SESSION['image'] = $image;}
          }
        }
 }
?>

<html>
  <body>
<div class="container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        Email:<br><input type="text" class="form-control" name="email"><br>
        Password:<br><input type="password" class="form-control" name="password"><br>
        <input type="submit"  name="submit" class="btn btn-success">
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
  </body>
</html>