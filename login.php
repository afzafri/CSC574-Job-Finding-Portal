<?php

ob_start();
//Start session
session_start();
include './config.php';

$errormsg = "";

if(isset($_POST['signup'])) {

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password_confirm = $_POST['password_confirm'];
  $level = $_POST['level'];

  if($email != "" && $username != "" && $password != "" && $password_confirm != "") {

    try
    {
      // check if email already registered
      $stmt = $conn->prepare("SELECT * FROM LOGIN WHERE L_EMAIL = ?");
      $stmt->execute(array($email));

      if(!$stmt->fetch(PDO::FETCH_ASSOC)) {
        // email not registered, register new

        // check if password matched
        if($password != $password_confirm)
        {
          echo "<script>alert('Password not match. Please check')</script>";
          $errormsg = "<center><h4><font color='red'>Password not match. Please check</font></h4></center>";
        } else {
          // insert into login table
          $stmt = $conn->prepare("INSERT INTO
                                  LOGIN (L_EMAIL, L_USERNAME, L_PASSWORD, L_LEVEL)
                                  VALUES (?, ?, ?, ?) ");

          $stmt->execute(array($email, $username, md5($password), $level));

          // get the login id
          $loginid = $conn->lastInsertId();

          // insert into youngster or job provider table
          if($level == 2) {
            $stmt = $conn->prepare("INSERT INTO
                                    JOB_PROVIDER (L_ID)
                                    VALUES (?) ");

            $stmt->execute(array($loginid));
          } else if($level == 3) {
            $stmt = $conn->prepare("INSERT INTO
                                    JOB_SEEKER (L_ID)
                                    VALUES (?) ");

            $stmt->execute(array($loginid));
          }

            echo "
            <script>
            alert('New account successfully registered.');
            </script>";
        }

      } else {
        // email already registered
        echo "<script>alert('Email address already in used.')</script>";
        $errormsg = "<center><h4><font color='red'>Email address already in used.</font></h4></center>";
      }

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  } else {
    $errormsg = "<center><h4><font color='red'>Please fill in all the information.</font></h4></center>";
  }
}
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Job Finding Portal</title>

    <link rel="stylesheet" href="./template/css/normalize.min.css">

  <link rel='stylesheet' href='./template/css/font-awesome.min.css'>

      <link rel="stylesheet" href="./template/css/loginregister.css">

</head>

<body>

  <br><br><br>
  <div class="login-box">
    <div class="lb-header">
      <a href="#" class="active" id="login-box-link">Login</a>
      <a href="#" id="signup-box-link">Sign Up</a>
    </div>
    <form class="email-login" action="home.php" method="post">
      <div class="u-form-group">
        <input type="email" placeholder="Email" name="email"/>
      </div>
      <div class="u-form-group">
        <input type="password" placeholder="Password" name="password"/>
      </div>
      <div class="u-form-group">
        <button>Log in</button>
      </div>
      <div class="u-form-group">
        <a href="#" class="forgot-password">Forgot password?</a>
      </div>
    </form>
    <form class="email-signup" method="post" action="./login.php">
      <div class="u-form-group">
        <input type="email" placeholder="Email" name="email" required/>
      </div>
      <div class="u-form-group">
        <input type="text" placeholder="Username" name="username" required/>
      </div>
      <div class="u-form-group">
        <input type="password" placeholder="Password" name="password" required/>
      </div>
      <div class="u-form-group">
        <input type="password" placeholder="Confirm Password" name="password_confirm" required/>
      </div>
      <div class="u-form-group">
        <select name="level" required>
          <option value="2">Job Provider</option>
          <option value="3">Job Seeker</option>
        </select>
      </div>
      <div class="u-form-group">
        <button type="submit" name="signup">Sign Up</button>
        <?php echo $errormsg; ?>
      </div>
    </form>
  </div>
  <script src='./template/js/vendor/jquery-2.2.4.min.js'></script>



    <script type="text/javascript">
    $(".email-signup").hide();
    $("#signup-box-link").click(function(){
      $(".email-login").fadeOut(100);
      $(".email-signup").delay(100).fadeIn(100);
      $("#login-box-link").removeClass("active");
      $("#signup-box-link").addClass("active");
      $(".login-box").css({ height: "440px" });
    });
    $("#login-box-link").click(function(){
      $(".email-login").delay(100).fadeIn(100);;
      $(".email-signup").fadeOut(100);
      $("#login-box-link").addClass("active");
      $("#signup-box-link").removeClass("active");
      $(".login-box").css({ height: "300px" });
    });
    </script>
</body>

</html>
