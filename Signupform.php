<!DOCTYPE html>
<html>

 <body>
    <?php
    //start session
     session_start();
     //db connection file
     require 'Config.php';
     $name = $email = $password = $age = $Gender= $Image= $error = "";
     $nameError= $emailError= $passwordError= $ageError=$passwordError=$genderError="a";
     //Check request method
     if ($_SERVER["REQUEST_METHOD"] == "POST")
     {
      //Check if action set or not
       if (isset($_POST["submit"])) 
       {
        //Name validation
         if(empty($_POST["Name"]))
         {
          $nameError= "Name is required";
          echo $nameError;
         }
            //$errorName = "";
         elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST["Name"])) 
         {
          echo $nameError = "Only Letters and Space are allowed";
         }
         else
         {
          $name = mysqli_real_escape_string($con, $_POST['Name']);
          $nameError="";
         }
         //Email validations
         if(empty($_POST["Email"]))
         {
          echo $emailError = "Email is required";
         }
         elseif (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) 
         {
          echo $emailError = "Enter correct email";
         }
         else
         {
          $email = mysqli_real_escape_string($con,$_POST['Email']);
          $emailError="";
         } 
         //Password validation and encryption
         if(empty($_POST["Password"]))
         {
           $passwordError = "Enter Password"; 
         }else
         {
           $password = mysqli_real_escape_string($con,$_POST['Password']);
           $hash = password_hash($password,PASSWORD_DEFAULT);
           $passwordError="";
         }
         //Age requirment
         if(empty($_POST["Age"]))
         {
          echo $ageError = "Age is required";
         }
         else
         {
           $age =mysqli_real_escape_string($con,$_POST['Age']);
           $ageError="";
         }
         
         if(empty($_POST["gender"]))
         {
          $genderError = "Gender is required";
           // $gender = $_POST["Gender"];
          }
         else
         {
          $gender = mysqli_real_escape_string($con,$_POST['gender']);
          $genderError="";
             // $errorGender = "Choose One";
          }
         // $image=Uploadimage();
          function uploadimage() : string{
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                // "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
              echo "Sorry, file already exists.";
              $uploadOk = 0;
            }
            
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
            return $target_file;
          }
            $profile_pic=uploadimage();
           if($nameError=="" && $emailError=="" && $passwordError==""  && $ageError=="" && $genderError=="" && $profile_pic!="")
           {
           $mailquery=" SELECT * FROM userdata WHERE Email='$email'" ;
           $query= mysqli_query($con,$mailquery);
          echo $emailcount= mysqli_num_rows($query);
           if($emailcount>0)
            {
              //$row= mysqli_fetch_assoc($query);
             // if($email==isset($row['Email'])){
             echo "Email already exist";//}
            }
           else
           {
             $insertquery=" INSERT INTO  userdata(Name, Email, Password, Age, Gender, Image)
             VALUES('$name',' $email','$hash','$age','$gender','$profile_pic')";
             $insertquery= mysqli_query($con,  $insertquery);
             if($insertquery) 
             {
              echo "Inserted Successfully";
               
              }
             else
              {
               echo "Error while inserting data";                   
              }        
            }
           }else{
            echo $nameError, $emailError, $passwordError, $ageError, $genderError;
            }
        }
      }
    ?>
     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
        <h1>Sign Up</h1>
        <div>
            <label for="username">Name:</label>
            <span class="error">*  </span>
            <input type="text" name="Name" id="username" >
        </div>
        <div>
            <label for="email">Email:</label>
            <span class="error">*  </span>
            <input type="email" name="Email" id="email" >
        </div>
        <div>
            <label for="password">Password:</label>
            <span class="error">*  </span>
            <input type="password" name="Password" id="Pwd">
        </div>
        <div>
            <label for="Confir mpassword">Confirm Password:</label>
            <span class="error">*  </span>
            <input type="password" name="Cpassword" id="Pwd">
        </div>
        <div>
            <label for="Age">Age:</label>
            <span class="error">*  </span>
            <input type="text" name="Age" id="age">
        </div>
        <div>
          <label for="Gender">Gender:</label>
          <input type="radio" name="gender" value="female">Female
          <input type="radio" name="gender" value="male">Male
          <input type="radio" name="gender" value="other">Other
          <span class="error">*  </span>
        </div>
         <div>
            <label for="Picture">Choose Profile:</label>
            <span class="error">*  </span>
            <input type="file" name="fileToUpload" id="Picture">
        </div> 
        <button type="submit" name="submit">Register</button>
        <div>
            Already a member? <a href="loginform.php">Login here</a>
        </div>
    </form>
 </body>
</html>