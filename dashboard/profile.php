<?php
  $pageTitle = "Profile";
  include './template/header.php';

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
    $profilepic = "";

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
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Edit Profile</h3>
  </div>

<!--modal body-->
  <?php
    if($level == 2) {
      ?>

      <form action="./profile.php" method="post" onsubmit="return confirm('Update profile?');">
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
            <input type="text" class="form-control" placeholder="Enter Description" name="desc" value="<?php echo $user_desc; ?>" required>
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
            <input type="file" class="form-control" name="profilepic">
          </div>
        </div>
        <div class="box-footer">
          <input type="hidden" name="userid" value="<?php echo $user_ids; ?>">
          <button type="submit" class="btn btn-success pull-right" name="updateJobProvider">Save changes</button>
        </div>
      </form>

      <?php
    } else if($level == 3) {

    }
  ?>

</div>

<?php include './template/footer.php'; ?>
