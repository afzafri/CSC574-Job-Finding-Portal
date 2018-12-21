<?php
  $pageTitle = "Manage Job Seeker Accounts";
  include './template/header.php';

  if(isset($_POST['deleteSeeker'])) {

    $loginid = $_POST['loginid'];
    $seekerid = $_POST['seekerid'];
    try
    {
      $stmtL = $conn->prepare("DELETE FROM LOGIN WHERE L_ID = ?");
      $stmtL->execute(array($loginid));

      $stmt = $conn->prepare("DELETE FROM JOB_SEEKER WHERE JS_ID = ?");
      $stmt->execute(array($seekerid));

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
    <h3 class="box-title">Job Seekers List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="seekersTable" class="table table-bordered table-striped">
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
        <th>About</th>
        <th>Skills</th>
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
          FROM JOB_SEEKER JS, LOGIN L
          WHERE L.L_ID = JS.L_ID
          ORDER BY JS.JS_ID DESC

          ");
          $stmt->execute(array($user_ids));

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jsid = $result['JS_ID'];
            $jsname = $result['JS_NAME'];
            $jsusername = $result['L_USERNAME'];
            $jsic = $result['JS_IC'];
            $jsemail = $result['L_EMAIL'];
            $jsphone = $result['JS_PHONE'];
            $jsaddress = $result['JS_ADDRESS'];
            $jsabout = $result['JS_ABOUT'];
            $jsskill = $result['JS_SKILL'];
            $jsprofilepic = ($result['JS_PROFILEPIC'] != "") ? "../images/profilepics/".$result['JS_PROFILEPIC'] : "./template/dist/img/avatar.png";
            $lid = $result['L_ID'];


            echo "
              <tr>
                <td>".$count."</td>
                <td><img src='$jsprofilepic'  height='100px'/></td>
                <td>".$jsname."</td>
                <td>".$jsusername."</td>
                <td>".$jsic."</td>
                <td>".$jsemail."</td>
                <td>".$jsphone."</td>
                <td>".$jsaddress."</td>
                <td>".$jsabout."</td>
                <td>".$jsskill."</td>
                <td>";
                ?>
                <a href="../viewseeker.php?id=<?php echo $jsid; ?>" class="btn btn-success" title='View account'><i class="fa fa-fw fa-eye"></i></a>
                <form action='./manageseeker.php' method='post' onsubmit='return confirm("Delete this job seeker?");'>
                  <input type='hidden' name='loginid' value='<?php echo $lid; ?>'>
                  <input type='hidden' name='seekerid' value='<?php echo $jsid; ?>'>
                  <button type='submit' name='deleteSeeker' class='btn btn-danger' title='Delete account'><i class="fa fa-fw fa-trash"></i></button>
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
