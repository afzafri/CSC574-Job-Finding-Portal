<?php
  $pageTitle = "Manage Staff Accounts";
  include './template/header.php';

  if(isset($_POST['registerStaff'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];

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

          $stmt->execute(array($email, $username, md5($password), 1));

          // get the login id
          $loginid = $conn->lastInsertId();

          // upload pic
          $imgUpmsg = "";
          $profilepic = "";
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
              // set new profile pic
              $profilepic = $stat['success']['filename'];
              $imgUpmsg = $stat['success']['status'];
            }
          }

          // insert into staff table
          $stmt = $conn->prepare("INSERT INTO
                                  STAFF (S_NAME, S_IC, S_ADDRESS, S_DEPARTMENT, S_PHONE, S_PROFILEPIC, L_ID)
                                  VALUES (?,?,?,?,?,?,?) ");
          $stmt->execute(array($name, $ic, $address, $department, $phone, $profilepic, $loginid));

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
  }

  if(isset($_POST['deleteStaff'])) {

    $loginid = $_POST['loginid'];
    $staffid = $_POST['staffid'];
    try
    {
      $stmtL = $conn->prepare("DELETE FROM LOGIN WHERE L_ID = ?");
      $stmtL->execute(array($loginid));

      $stmt = $conn->prepare("DELETE FROM STAFF WHERE S_ID = ?");
      $stmt->execute(array($staffid));

      echo "
      <script>
      alert('Account deleted.');
      </script>";

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }
  }
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Staffs List</h3>
    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-register-staff"><i class="fa fa-fw fa-user-plus"></i> Register New Staff</button>
  </div>
  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <table id="staffsTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Pic</th>
        <th>Name</th>
        <th>Username</th>
        <th>IC</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Department</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        try
        {
          $stmt = $conn->prepare("

          SELECT *
          FROM STAFF S, LOGIN L
          WHERE L.L_ID = S.L_ID
          ORDER BY S.S_ID DESC

          ");
          $stmt->execute(array($user_ids));

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $sid = $result['S_ID'];
            $sname = $result['S_NAME'];
            $susername = $result['L_USERNAME'];
            $sic = $result['S_IC'];
            $semail = $result['L_EMAIL'];
            $sphone = $result['S_PHONE'];
            $saddress = $result['S_ADDRESS'];
            $sdept = $result['S_DEPARTMENT'];
            $sprofilepic = ($result['S_PROFILEPIC'] != "") ? "../images/profilepics/".$result['S_PROFILEPIC'] : "./template/dist/img/avatar.png";
            $lid = $result['L_ID'];


            echo "
              <tr>
                <td>".$count."</td>
                <td><img src='$sprofilepic'  height='100px'/></td>
                <td>".$sname."</td>
                <td>".$susername."</td>
                <td>".$sic."</td>
                <td>".$semail."</td>
                <td>".$sphone."</td>
                <td>".$saddress."</td>
                <td>".$sdept."</td>
                <td>";
                ?>
                <form action='./managestaff.php' method='post' onsubmit='return confirm("Delete this staff?");'>
                  <input type='hidden' name='loginid' value='<?php echo $lid; ?>'>
                  <input type='hidden' name='staffid' value='<?php echo $sid; ?>'>
                  <button type='submit' name='deleteStaff' class='btn btn-danger' title='Delete account'><i class="fa fa-fw fa-trash"></i></button>
                </form>
                <?php
                echo "</td>
              </tr>
            ";

            $count++;

          }

        }
        catch(PDOException $e)
        {
          echo "Connection failed : " . $e->getMessage();
        }
        ?>
    </table>
  </div>
  <!-- /.box-body -->
</div>

<!--modal dialog -->
<div class="modal fade" id="modal-register-staff" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Register New Staff</h4>
              </div>
              <form action="./managestaff.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Register new Staff account?');">
                <div class="modal-body">
                <!--modal body-->
                <div class="box-body">

                  <h4><i class="fa fa-fw fa-lock"></i> Login Details</h4>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="text" class="form-control" placeholder="Enter Password" name="password" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="text" class="form-control" placeholder="Re-enter Password" name="password_confirm" required>
                  </div>

                  <br>
                  <hr>
                  <h4><i class="fa fa-fw fa-user"></i> Profile Details</h4>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">IC</label>
                    <input type="text" class="form-control" placeholder="Enter IC" name="ic" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <textarea class="form-control" placeholder="Enter Address" name="address" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Department</label>
                    <input type="text" class="form-control" placeholder="Enter Department" name="department" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="text" class="form-control" placeholder="Enter Phone" name="phone" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Upload profile picture</label>
                    <input type="file" class="form-control-file" name="profilepic" id="profilepic">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="registerStaff">Register</button>
                </div>
              </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
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
      msgPlaceholder: 'Choose profile picture...',
    });
  });
  </script>
