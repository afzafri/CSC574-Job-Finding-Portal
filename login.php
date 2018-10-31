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
    <form class="email-signup" method="post">
      <div class="u-form-group">
        <input type="email" placeholder="Email" name="email"/>
      </div>
      <div class="u-form-group">
        <input type="text" placeholder="Username" name="username"/>
      </div>
      <div class="u-form-group">
        <input type="password" placeholder="Password" name="password"/>
      </div>
      <div class="u-form-group">
        <input type="password" placeholder="Confirm Password" name="password_confirm"/>
      </div>
      <div class="u-form-group">
        <select name="level" require>
          <option value="2">Job Provider</option>
          <option value="3">Job Seeker</option>
        </select>
      </div>
      <div class="u-form-group">
        <button>Sign Up</button>
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
