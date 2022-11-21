<html>
<body>

<?php
// DB Connection
require 'Config.php';

//  Getting values through session
session_start();
$name =  $_SESSION['Name'];
$email = $_SESSION['email'];
$age = $_SESSION['Age'];
$pp = $_SESSION['image'];
$gender = $_SESSION['Gender'];
$userName = $userEmail = $userAge = $userGender = $userimage = "";
$verify = False;



//  Logout session
if (isset($_POST['logout'])){
    session_start();
    session_destroy();
    header("location: Loginform .php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Update'])) {

//    Update Name Validation
    if (!empty($_POST["username"])) {
        if ($_POST["username"] != $name) {
            $errorName = $username = "";
            if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["userName"])) {
                $errorName ="Only Letters and Spaces are allowed in name field";
            }
            $username = $_POST["username"];
            mysqli_query($con, "UPDATE userdata SET NAME = '$username' WHERE EMAIL = '$email'");
            $name = $username;
            $_SESSION['Name'] = $name;
            $username = "";
        } else {
            $errorName = $username = "";
        }
    } else {
        $errorName = "Name Cannot Be Empty";
    }

    //  Email Validation
    if (!empty($_POST["useremail"])) {
        if ($_POST["useremail"] != $email) {
            $errorEmail = $useremail = "";
            if (!filter_var($_POST["useremail"], FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Invalid format of email";
            }
            $useremail = $_POST["useremail"];
            $updateEmailQuery = "SELECT * FROM userdata WHERE EMAIL = '$useremail'";
            $res = mysqli_query($con, $updateEmailQuery);
            if (mysqli_num_rows($res) > 0) {
                $errorEmail = "Email Already Registered";
                $userEmail = "";
            } else {
                mysqli_query($con, "UPDATE userdata SET EMAIL = '$useremail' WHERE EMAIL = '$email'");
                $email = $useremail;
                $_SESSION['email'] = $email;
               setcookie('email', $email, time() + 86400, '/');
                $useremail = "";
            }
        } else {
            $errorEmail = $useremail = "";
        }
    } else {
        $errorEmail = "Email Cannot Be Empty";
    }

    // Age Requirments
    if (!empty($_POST["userage"])) {
        if ($_POST["userage"] != $age) {
            $userage = $_POST["userage"];
            mysqli_query($conn, "UPDATE userdata SET AGE = '$userage' WHERE EMAIL = '$email'");
            $age = $userage;
            $_SESSION['Age'] = $age;
            $userage = "";
        } else {
            $userage = "";
        }
    } else {
        $userage = "";
    }

   //   Gender Requirments
    if (!empty($_POST["userender"])) {
        if ($_POST["usergender"] != $gender) {
            $uptGender = $_POST["usergender"];
            mysqli_query($conn, "UPDATE userdata SET GENDER = '$usergender' WHERE EMAIL = '$email'");
            $gender = $usergender;
            $usergender = "";
        } else {
            $usergender = "";
        }
    } else {
        $usergender = "";
    }

   //  Updating Profile Picture
    $imageformat = array("jpg", "jpeg", "gif", "png","jfif");
    $folder = 'uploadss/';
    if ( !!$_FILES['image']['tmp_name'] )
    {
        $info = explode('.', strtolower( $_FILES['image']['name']) );
        if ( in_array( end($info), $imageformat) )
        {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $folder . basename($_FILES['image']['name'] ) ) )
            {
                $userPp = basename($_FILES['image']['name'] );
                mysqli_query($con, "UPDATE userdata SET Image = '$userimage' WHERE EMAIL = '$email'");
                $UI = $userimage;
                $_SESSION['image'] = $UI;
                $userimage = "";
            }
        }
    }

}


?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <div>
         <h1>Welcome to profile</h1>
    </div>
    <div>
         <img src= "uploads./" class="rounded-circle img-fluid" style="width: 100px;">
         <input type="file" name="image" id="image">
    </div>
    <p>User Name</p>      
    <div>
      <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['Name'] ?>">
    </div>
     <br>
    <div>
     <p >Email</p>
    </div>
    <div>
     <input type="text" class="form-control" name="useremail" value="<?php echo $_SESSION['email'] ?>">
    </div>
         <br>                    
    <div>
     <p>Age</p>
    </div>
    <div>
      <input type="number" class="form-control" name="userage" value="<?php echo $_SESSION['Age'] ?>">
    </div>
      <br>                
    <div>
        <p>Gender</p>
    </div>                
    <div>
      <label class="radio-inline me-3"><input type="radio" name="usergender" <?php if (isset($gender) && $gender=="Male");?> value="male"> Male</label>
      <label class="radio-inline me-3"><input type="radio" name="usergender" <?php if (isset($gender) && $gender=="Female");?> value="female"> Female</label>
    </div>    
      <br>
    <div>
     <button type="submit" name="logout">Log Out</button>
    </div>
    <div>
     <button type="submit" name="update">Update Profile</button>
    </div>
            </form>
    </body>
</html>
<?php
//Connection close
mysqli_close($con);
?>