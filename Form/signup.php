<?php
include("includes/header.php");
include("includes/config.php");
include("includes/functions.php");
$msg="";
$msg2="";
$msg3="";
$msg4="";
$msg5="";
$msg6="";
$msg7="";
$msg8="";
$msg9="";
$firstname="";/*creating a variable so that value remain unchange id one field is missed*/
$lastname="";
$email="";
$date="";
$password="";
$c_password="";
$image="";
if(isset($_POST['submit']))
{
  $firstname=$_POST['fname'];
  $lastname=$_POST['lname'];
  $email=$_POST['mail'];
  $date=$_POST['dob'];
  $password=$_POST['pass'];
  $c_password=$_POST['cpass'];
  $image=$_FILES['image']['name'];
  $tmp_image=$_FILES['image']['tmp_name'];
  $checkbox=isset($_POST['check']);
  /*echo $firstname."</br>".$lastname."</br>".$email."</br>".$date."</br>"
  .$password."</br>".$c_password."</br>".$image."</br>".$checkbox;*/
  if(strlen($firstname)<3)
  {
    $msg="<div class ='error'> First name must conatain atleast 3 characters </div>";
  }

else if(strlen($lastname)<2)
  {
    $msg2 ="<div class ='error'> Last  name must conatain atleast 2 characters </div>";
  }
  else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $msg3="<div class='error'>Enter Valid Email</div>";
  }
  else if(email_exists($email,$con))
  {
  $msg3="<div class ='error'>Email Exists</div>";
  }
  else if(empty($date)){
  $msg4=  "<div class='error'>Please Enter Your Date Of Birth</div>";
  }
  else if (empty($password))
  {
  $msg5="<div class='error'>Please Enter Password!</div>";
  }
  else if(strlen($password)<6){
    $msg5="<div class='error'>Password must contain atleast 6 characters</div>";
  }

  else if($password!==$c_password){
    $msg6="<div class='error'>Incorrect Password!</div>";
  }
  else if($image=="")
  {
    $msg7="<div class='error'>Please Upload Your profile Image</div>";
  }

  else if($checkbox=='')
  {
    $msg8="<div class='error'>Please Agree Our Terms And Condition</div>";
  }
  else
  {

    $password=md5($password);
    $img_ext=explode(".",$image);//explode create a image name in an aaray and seaparate it from .(dot)
    $image_ext= $img_ext['1'];
    $image=rand(1,1000).rand(1,1000).time().".".$image_ext;//upload same img with diff name in dstination folder
    if($image_ext=='jpg'|| $image_ext=='png'|| $image_ext=='JPG'|| $image_ext=='PNG')
    {
      move_uploaded_file($tmp_image,"images/$image");//uploaded img moves to destination folder
  mysqli_query($con,"INSERT INTO users(first_name,last_name,mail,dob,password,img)
  VALUES('$firstname','$lastname','$email','$date','$password','$image')") ;
  $msg9="<div class='success'><center>You Are Successfully Registered!</center> </div>";
  $firstname="";$lastname="";$email="";$date="";$password="";$c_password="";$image="";/* so that values comes to defaut as empty after submission of form succesfully*/
  }
  else {
    $msg7="<div class='error'>Please Upload a Image File</div>";
 }
}}
 ?>
 <title>Sign Up Form</title>
</head>
<style type='text/css'>
.body-bg
{
  background: url("images/pov.jpg");
  background-size: 100% 100%;
}
.error
{
  color:red;
}
.Success
{
color: green;
font-weight: bold;
}
</style>
<body class='body-bg'>
  <div class='container'>
    <div class='login-form col-md-4 offset-md-4'>
      <div class='jumbotron'style="margin-top:20px; padding-top:20px;padding-bottom:20px"><!--jumbotron is bootstrap class-->
  <h3 align='center'>Sign Up Form</h3><br>
  <?php echo $msg9; ?>
  <br>

  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label>First Name :</label>
    <input type="text" name="fname"placeholder=" Your First Name" class="form-control" value="<?php echo $firstname; ?>">
    <?php echo $msg; ?>
    </div>

    <div class="form-group">
    <label>Last Name :</label>
    <input type="text" name="lname"placeholder="Your Last Name" class="form-control" value="<?php echo $lastname; ?>">
    <?php echo $msg2;?>
    </div>

    <div class="form-group">
    <label>Email :</label>
    <input type="email" name="mail"placeholder="Your Email" class="form-control"value="<?php echo $email; ?>">
      <?php echo $msg3; ?>
    </div>

    <div class="form-group">
    <label>Date Of Birth :</label>
    <input type="date" name="dob" class="form-control"value="<?php echo $date; ?>">
    <?php echo $msg4; ?>
    </div>

    <div class="form-group">
    <label>Password :</label>
    <input type="password" name="pass"placeholder="Password" class="form-control"value="<?php echo $password; ?>">
      <?php echo $msg5; ?>
    </div>

    <div class="form-group">
    <label>Re-enter Password :</label>
    <input type="password" name="cpass"placeholder="Re-enter Password" class="form-control"value="<?php echo $c_password; ?>">
      <?php echo $msg6; ?>
    </div>

    <div class="form-group">
    <label>Profile Image :</label>
    <input type="file" name="image" value="<?php echo $image; ?>"/>
      <?php echo $msg7; ?>
  </div><br>

    <div class="form-group">
    <input type="checkbox" name="check">
    I Agree the terms and conditions.
      <?php echo $msg8; ?>
  </div><br>
  <center>  <input type='submit' value="submit" name="submit" class="btn btn-success" /></center>
  <center><a href="login.php">Already Registered?</a></center>

    </form>
    </div>
    </div>
    </div>
    </body>
    </html>
