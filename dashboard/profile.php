<?php
  $pageTitle = "Profile";
  include './template/header.php';

  if(isset($_POST['updateStaff'])) {
    $useridup = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $profilepic = $currpicname;

    // upload pic
    $imgUpmsg = "";
    if(isset($_FILES['profilepic']) && $_FILES['profilepic']['size'] > 0)
    {
      require_once('../uploader.class.php');
      $obj = new Uploader();

      $obj->dir = "../images/profilepics/"; //directory to store the image/file
      $obj->files = $_FILES["profilepic"]; //receive from form
      $obj->filetype = array('png','jpg','jpeg'); //set the allowed image/file extensions
      $obj->size = 5000000; //set file/image size limit. note: 100000 is 100KB
      $obj->upimg = true; //set true if want to upload image.

      //upload
      $stat = json_decode($obj->upload(), true);

      if(array_key_exists('errors', $stat))
      {
        $imgUpmsg = $stat['errors']['status'];
      }
      else
      {
        // delete old profile pic
        if($currpicname != "") {
          unlink('../images/profilepics/'.$currpicname);
        }

        // set new profile pic
        $profilepic = $stat['success']['filename'];
        $imgUpmsg = $stat['success']['status'];
      }
    }

    try
    {
      $stmt = $conn->prepare("UPDATE STAFF SET S_NAME = ?, S_IC = ?, S_ADDRESS = ?, S_DEPARTMENT = ?, S_PHONE = ?, S_PROFILEPIC = ? WHERE S_ID = ?");
      $stmt->execute(array($name, $ic, $address, $department, $phone, $profilepic, $useridup));

      $stmt = $conn->prepare("UPDATE LOGIN SET L_EMAIL = ?, L_USERNAME = ? WHERE L_ID = ?");
      $stmt->execute(array($email, $username, $user_id));

      $_SESSION['USER_EMAIL'] = $email;
      $_SESSION['USER_USERNAME'] = $username;

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully Updated');
      window.location.href='./profile.php';
      </script>");

    }
    catch(PDOException $e)
    {
      echo "
      <script>
      alert('". $e->getMessage()."');
      </script>";
      echo "Connection failed : " . $e->getMessage();
    }
  }

  if(isset($_POST['updateJobProvider'])) {
    $useridup = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $desc = $_POST['desc'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $website = $_POST['website'];
    $profilepic = $currpicname;

    // upload pic
    $imgUpmsg = "";
    if(isset($_FILES['profilepic']) && $_FILES['profilepic']['size'] > 0)
    {
      require_once('../uploader.class.php');
      $obj = new Uploader();

      $obj->dir = "../images/profilepics/"; //directory to store the image/file
      $obj->files = $_FILES["profilepic"]; //receive from form
      $obj->filetype = array('png','jpg','jpeg'); //set the allowed image/file extensions
      $obj->size = 5000000; //set file/image size limit. note: 100000 is 100KB
      $obj->upimg = true; //set true if want to upload image.

      //upload
      $stat = json_decode($obj->upload(), true);

      if(array_key_exists('errors', $stat))
      {
        $imgUpmsg = $stat['errors']['status'];
      }
      else
      {
        // delete old profile pic
        if($currpicname != "") {
          unlink('../images/profilepics/'.$currpicname);
        }

        // set new profile pic
        $profilepic = $stat['success']['filename'];
        $imgUpmsg = $stat['success']['status'];
      }
    }

    try
    {
      $stmt = $conn->prepare("UPDATE JOB_PROVIDER SET JP_NAME = ?, JP_DESCRIPTION = ?, JP_AREA = ?, JP_ADDRESS = ?, JP_PHONE = ?, JP_WEBSITE = ?, JP_PROFILEPIC = ? WHERE JP_ID = ?");
      $stmt->execute(array($name, $desc, $area, $address, $phone, $website, $profilepic, $useridup));

      $stmt = $conn->prepare("UPDATE LOGIN SET L_EMAIL = ?, L_USERNAME = ? WHERE L_ID = ?");
      $stmt->execute(array($email, $username, $user_id));

      $_SESSION['USER_EMAIL'] = $email;
      $_SESSION['USER_USERNAME'] = $username;

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully Updated');
      window.location.href='./profile.php';
      </script>");

    }
    catch(PDOException $e)
    {
      echo "
      <script>
      alert('". $e->getMessage()."');
      </script>";
      echo "Connection failed : " . $e->getMessage();
    }
  }

  if(isset($_POST['updateJobSeeker'])) {
    $useridup = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $about = $_POST['about'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $skill = $_POST['skill'];
    $phone = $_POST['phone'];
    $profilepic = $currpicname;

    // upload pic
    $imgUpmsg = "";
    if(isset($_FILES['profilepic']) && $_FILES['profilepic']['size'] > 0)
    {
      require_once('../uploader.class.php');
      $obj = new Uploader();

      $obj->dir = "../images/profilepics/"; //directory to store the image/file
      $obj->files = $_FILES["profilepic"]; //receive from form
      $obj->filetype = array('png','jpg','jpeg'); //set the allowed image/file extensions
      $obj->size = 5000000; //set file/image size limit. note: 100000 is 100KB
      $obj->upimg = true; //set true if want to upload image.

      //upload
      $stat = json_decode($obj->upload(), true);

      if(array_key_exists('errors', $stat))
      {
        $imgUpmsg = $stat['errors']['status'];
      }
      else
      {
        // delete old profile pic
        if($currpicname != "") {
          unlink('../images/profilepics/'.$currpicname);
        }

        // set new profile pic
        $profilepic = $stat['success']['filename'];
        $imgUpmsg = $stat['success']['status'];
      }
    }

    try
    {
      $stmt = $conn->prepare("UPDATE JOB_SEEKER SET JS_NAME = ?, JS_ABOUT = ?, JS_IC = ?, JS_ADDRESS = ?, JS_SKILL = ?, JS_PHONE = ?, JS_PROFILEPIC = ? WHERE JS_ID = ?");
      $stmt->execute(array($name, $about, $ic, $address, $skill, $phone, $profilepic, $useridup));

      $stmt = $conn->prepare("UPDATE LOGIN SET L_EMAIL = ?, L_USERNAME = ? WHERE L_ID = ?");
      $stmt->execute(array($email, $username, $user_id));

      $_SESSION['USER_EMAIL'] = $email;
      $_SESSION['USER_USERNAME'] = $username;

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully Updated');
      window.location.href='./profile.php';
      </script>");

    }
    catch(PDOException $e)
    {
      echo "
      <script>
      alert('". $e->getMessage()."');
      </script>";
      echo "Connection failed : " . $e->getMessage();
    }
  }

  $cpErr = "";
  if(isset($_POST['changePassword'])) {
    $curPass = $_POST['curPass'];
    $newPass = $_POST['newPass'];
    $confirmNewPass = $_POST['confirmNewPass'];
    $loginID = $_POST['loginid'];

    try
    {
      // check if email already registered
      $stmt = $conn->prepare("SELECT * FROM LOGIN WHERE L_ID = ?");
      $stmt->execute(array($loginID));
      $resL = $stmt->fetch(PDO::FETCH_ASSOC);

      // if current pass entered match in db, allow change pass
      if(md5($curPass) == $resL['L_PASSWORD']) {
        // if new pass and confirm new pass match
        if($newPass == $confirmNewPass) {
          $stmtUP = $conn->prepare("UPDATE LOGIN SET L_PASSWORD = ? WHERE L_ID = ?");
          $stmtUP->execute(array(md5($newPass), $loginID));
          echo ("<script LANGUAGE='JavaScript'>
          alert('Password updated.')
          </script>");
        } else {
          $cpErr = "<center><font color='red'><b>New password entered does not match.</b></font></center>";
          echo ("<script LANGUAGE='JavaScript'>
          alert('New password entered does not match.')
          </script>");
        }
      } else {
        $cpErr = "<center><font color='red'><b>Incorrect current password.</b></font></center>";
        echo ("<script LANGUAGE='JavaScript'>
        alert('Incorrect current password.')
        </script>");
      }
    }
    catch(PDOException $e)
    {
      echo "
      <script>
      alert('". $e->getMessage()."');
      </script>";
      echo "Connection failed : " . $e->getMessage();
    }
  }
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Edit Profile</h3>
  </div>

  <?php
    if($level == 1) {
      ?>

      <form action="./profile.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Update profile?');">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" value="<?php echo $user_name; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $user_email; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $user_username; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">IC</label>
            <input type="text" class="form-control" placeholder="Enter IC" name="ic" value="<?php echo $user_ic; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Address</label>
            <textarea class="form-control" placeholder="Enter Address" name="address" required><?php echo $user_address; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Department</label>
            <input type="text" class="form-control" placeholder="Enter Department" name="department" value="<?php echo $user_department; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Phone</label>
            <input type="text" class="form-control" placeholder="Enter Phone" name="phone" value="<?php echo $user_phone; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Upload profile picture</label>
            <input type="file" class="form-control-file" name="profilepic" id="profilepic">
          </div>
        </div>
        <div class="box-footer">
          <input type="hidden" name="userid" value="<?php echo $user_ids; ?>">
          <button type="submit" class="btn btn-success pull-right" name="updateStaff">Save changes</button>
        </div>
      </form>

      <?php
    } else if($level == 2) {
      ?>

      <form action="./profile.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Update profile?');">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" value="<?php echo $user_name; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $user_email; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $user_username; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <textarea class="form-control" placeholder="Enter Description" name="desc" required><?php echo $user_desc; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Area</label>
            <input type="text" class="form-control" placeholder="Enter Area" name="area" value="<?php echo $user_area; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Address</label>
            <textarea class="form-control" placeholder="Enter Address" name="address" required><?php echo $user_address; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Phone</label>
            <input type="text" id="startDateTime" class="form-control" placeholder="Enter Phone" name="phone" value="<?php echo $user_phone; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Website</label>
            <input type="text" class="form-control" placeholder="Enter Website" name="website" value="<?php echo $user_website; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Upload profile picture</label>
            <input type="file" class="form-control-file" name="profilepic" id="profilepic">
          </div>
        </div>
        <div class="box-footer">
          <input type="hidden" name="userid" value="<?php echo $user_ids; ?>">
          <button type="submit" class="btn btn-success pull-right" name="updateJobProvider">Save changes</button>
        </div>
      </form>

      <?php
    } else if($level == 3) {
      ?>

      <form action="./profile.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Update profile?');">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" value="<?php echo $user_name; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $user_email; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" placeholder="Enter Username" name="username" value="<?php echo $user_username; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">About</label>
            <textarea class="form-control" placeholder="Enter About" name="about" required><?php echo $user_about; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">IC</label>
            <input type="text" class="form-control" placeholder="Enter IC" name="ic" value="<?php echo $user_ic; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Address</label>
            <textarea class="form-control" placeholder="Enter Address" name="address" required><?php echo $user_address; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Skill</label>
            <textarea class="form-control" placeholder="Enter Skill" name="skill" required><?php echo $user_skill; ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Phone</label>
            <input type="text" id="startDateTime" class="form-control" placeholder="Enter Phone" name="phone" value="<?php echo $user_phone; ?>" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Upload profile picture</label>
            <input type="file" class="form-control-file" name="profilepic" id="profilepic">
          </div>
        </div>
        <div class="box-footer">
          <input type="hidden" name="userid" value="<?php echo $user_ids; ?>">
          <button type="submit" class="btn btn-success pull-right" name="updateJobSeeker">Save changes</button>
        </div>
      </form>

      <?php
    }
  ?>
</div>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Change Password</h3>
  </div>
  <form action="./profile.php" method="post" onsubmit="return confirm('Update password?');">
    <div class="box-body">
      <div class="form-group">
        <label>Current password</label>
        <input type="password" class="form-control" placeholder="Enter current password" name="curPass" required>
      </div>
      <div class="form-group">
        <label>New password</label>
        <input type="password" class="form-control" placeholder="Enter new password" name="newPass" required>
      </div>
      <div class="form-group">
        <label>Confirm New password</label>
        <input type="password" class="form-control" placeholder="Confrm new password" name="confirmNewPass" required>
      </div>
      <?php echo $cpErr; ?>
    </div>
    <div class="box-footer">
      <input type="hidden" name="loginid" value="<?php echo $user_id; ?>">
      <button type="submit" class="btn btn-success pull-right" name="changePassword">Save changes</button>
    </div>
  </form>
</div>

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    $("#profilepic").fileinput({
      theme: 'fa',
      dropZoneEnabled: false,
      showUpload: false,
      allowedFileExtensions: ['png','jpg','jpeg'],
      maxFileSize: 5000,
      msgPlaceholder: 'Choose new profile picture...',
      // for image files
      initialPreview: [
          "<img src='<?php echo $user_profilepic; ?>' width='150px' class='file-preview-image'>",
      ],
    });
  });
  </script>
