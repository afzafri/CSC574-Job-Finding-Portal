<?php
  $pageTitle = "Manage Job Provider Accounts";
  include './template/header.php';

  if(isset($_POST['deleteProvider'])) {

    $loginid = $_POST['loginid'];
    $providerid = $_POST['providerid'];
    try
    {
      $stmtL = $conn->prepare("DELETE FROM LOGIN WHERE L_ID = ?");
      $stmtL->execute(array($loginid));

      $stmt = $conn->prepare("DELETE FROM JOB_PROVIDER WHERE JP_ID = ?");
      $stmt->execute(array($providerid));

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
    <h3 class="box-title">Job Providers List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <table id="providersTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Pic</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Website</th>
        <th>Address</th>
        <th>Description</th>
        <th>Area</th>
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
          FROM JOB_PROVIDER JP, LOGIN L
          WHERE L.L_ID = JP.L_ID
          ORDER BY JP.JP_ID DESC

          ");
          $stmt->execute();

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jpid = $result['JP_ID'];
            $jpname = $result['JP_NAME'];
            $jpusername = $result['L_USERNAME'];
            $jpemail = $result['L_EMAIL'];
            $jpphone = $result['JP_PHONE'];
            $jpwebsite = $result['JP_WEBSITE'];
            $jpaddress = $result['JP_ADDRESS'];
            $jpdesc = $result['JP_DESCRIPTION'];
            $jparea = $result['JP_AREA'];
            $jpprofilepic = ($result['JP_PROFILEPIC'] != "") ? "../images/profilepics/".$result['JP_PROFILEPIC'] : "./template/dist/img/avatar.png";
            $lid = $result['L_ID'];


            echo "
              <tr>
                <td>".$count."</td>
                <td><img src='$jpprofilepic'  height='100px'/></td>
                <td>".$jpname."</td>
                <td>".$jpusername."</td>
                <td>".$jpemail."</td>
                <td>".$jpphone."</td>
                <td>".$jpwebsite."</td>
                <td>".$jpaddress."</td>
                <td>".$jpdesc."</td>
                <td>".$jparea."</td>
                <td>";
                ?>
                <a href="../viewprovider.php?id=<?php echo $jpid; ?>" class="btn btn-success" title='View account'><i class="fa fa-fw fa-eye"></i></a>
                <form action='./manageprovider.php' method='post' onsubmit='return confirm("Delete this job provider?");'>
                  <input type='hidden' name='loginid' value='<?php echo $lid; ?>'>
                  <input type='hidden' name='providerid' value='<?php echo $jpid; ?>'>
                  <button type='submit' name='deleteProvider' class='btn btn-danger' title='Delete account'><i class="fa fa-fw fa-trash"></i></button>
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
