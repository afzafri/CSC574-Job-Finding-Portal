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

<?php include './template/footer.php'; ?>
