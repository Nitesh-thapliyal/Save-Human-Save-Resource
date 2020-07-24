<?php
include("includes/header.php");
include("includes/config.php");
include("includes/functions.php");
$msg='';
$msg2='';
$email='';
if(isset($_POST['submit']))
{
$email=$_POST['mail'];
$password=$_POST['pass'];
if(empty($email))
{
$msg='<div class="error">Please Enter Your Email</div>';
}

else if(empty($password))
{
$msg2='<div class="error">Please Enter Your Password</div>';
}

else if(email_exists($email,$con))
{
$pass=mysqli_query($con,"SELECT password FROM users WHERE mail='$email'");
$pass_w=mysqli_fetch_array($pass);
$dpass=$pass_w['password'];
$password=md5($password);
if($password!==$pass)
{
$msg2='<div class="error"> Password is wrong</div>';
}
else {
header("location:profile.php");
}
}
else{
  $msg='<div class="error"> Email Does Not Exist</div>';
}
}
 ?>
 <title>Login Form</title>
 <style type="text/css">
 .error
 {
  color:red;
 }
 </style>
</head>
<body>
  <div class='container'>
    <div class='login-form col-md-4 offset-md-4'>
      <div class='jumbotron' style='margin-top:50px;padding-top:50px;padding-bottom:10px;'>
        <h2 align='center'>Login Form</h2>
        <form method ='post'>
          <div class='form-group'>
            <label>Email :</label>
            <input type='email' name="mail" class='form-control' value='<?php echo $email;?>' />
            <?php echo $msg; ?>
              </div>

            <div class='form-group'>
              <label>Password :</label>
              <input type='password' name="pass" class='form-control' />
                <?php echo $msg2; ?>
                </div>


                <div class='form-group'>
               <input type='checkbox' name="check" />
            &nbsp;  <!--gives space-->  Keep me logged in
          </div><br>


      <div class='form-group'>
      <center>  <input type="submit" name='submit' value='Login' class='btn btn-success'/></center>
      </div>


</form>
</div>
</div>
</div>
</body>
</html>
