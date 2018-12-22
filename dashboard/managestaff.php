<?php
  $pageTitle = "Manage Staff Accounts";
  include './template/header.php';

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
  <div class="box-body">
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
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
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
