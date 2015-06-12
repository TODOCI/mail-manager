<?php
session_start();
$SECURE = true;

require 'libs/globals.php';
require 'libs/database.php';
require "libs/session.php";
require "libs/user.php";

//check for the cookie
if(isset($_COOKIE['remember']))
{
  //database verification if cookie is saved for a particular user
  $success=user::validCookie();
  //if yes set session and then redirect to mainpage
  if($success!=null)
  {
    session::Set($success);
        if(isset($_SESSION['user_id']))
        redirect_to("dashboard/");
  }
  else
  {
    //destroy the cookie
    setcookie('remember',null,time()-100);
  }
}

if(isset($_POST['commit']))
{
    $email = $_POST['login'];
    $password = $_POST['password'];
    //$password=hash('sha512', $_POST['password']);
    //if the remember me checkbox is ticked then the user is to be remembered
    if(isset($_POST['remember_me']))
      $remember = true;
    else
      $remember=false;
    //check the info again
    $newuser=new user();
    $newuser->set_initial($email,$password);
    $correct = $newuser->verifyEmail();
    if($correct)
    {
        $success=$newuser->checkFromDB();
        if($success != null) {
            //that is user is found
            //set the cookie in the database
            if($remember)
            {
              //generate a hash
              $token = md5(uniqid(mt_rand(), true));
              // save the hash in the database
              //save other things like time and all if needed
              $newuser->setHash($token);
              //save the cookie for 1 month
              setcookie('remember',$token,time()+30*24*60*60);
            }

          //set the session
            session::Set($success);
            if(isset($_SESSION['user_id']))
                redirect_to("dashboard/");
        } else {
            // #todo - perform the invalid username/password thingy
                $err="Incorrect Email or Password";
            //no such  user found
            //give the error
        }
    }
    else
    {
      $err="Incorrect Email";
    }
}

?>



<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to Web App</h1>
      <form method="post" action="index.php">
        <p><input type="text" name="login" value="" placeholder="Username or Email"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <p style="color:red">
              <?php
              if(isset($err))
              echo $err; 
              ?>
            </p>
          </label>
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="index.php">Click here to reset it</a>.</p>
    </div>
  </section>

  
</body>
</html>
