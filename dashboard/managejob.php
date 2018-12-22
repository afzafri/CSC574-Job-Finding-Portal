<?php
  $pageTitle = "Manage Job Offers";
  include './template/header.php';

  if(isset($_POST['deleteOffer'])) {

    $offerid = $_POST['offerid'];
    try
    {
      $stmtJ = $conn->prepare("DELETE FROM JOB WHERE J_ID = ?");
      $stmtJ->execute(array($offerid));

      echo "
      <script>
      alert('Job offer deleted.');
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
    <h3 class="box-title">Job Offers List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="offersTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Area</th>
        <th>Salary</th>
        <th>Job Location</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Job Provider</th>
        <th>Total Applications</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        try
        {
          $stmtJob = $conn->prepare("
                                  SELECT *
                                  FROM JOB J, JOB_PROVIDER P
                                  WHERE J.JP_ID = P.JP_ID
                                    ");
          $stmtJob->execute();

          //fetch
          while($job = $stmtJob->fetch(PDO::FETCH_ASSOC)) {

            $jid = $job['J_ID'];
            $jtitle = $job['J_TITLE'];
            $jdesc = $job['J_DESC'];
            $jarea = $job['J_AREA'];
            $jsalary = $job['J_SALARY'];
            $jaddress = $job['J_ADDRESS'];
            $jstart = date('d/m/Y h:i A', strtotime($job['J_START']));
            $jend = date('d/m/Y h:i A', strtotime($job['J_END']));
            $jstatus = $job['J_STATUS'];
            $jpid = $job['JP_ID'];
            $jpname = $job['JP_NAME'];
            $jpprofilepic = ($job['JP_PROFILEPIC'] != "") ? "./images/profilepics/".$job['JP_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";

            $stmtTotal = $conn->prepare("
                                        SELECT COUNT(*) AS TOTAL
                                        FROM JOB_APPLICATION
                                        WHERE STATUS = 1
                                        AND J_ID = ?
                                        ");
            $stmtTotal->execute(array($jid));
            $resTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
            $totalApplied = $resTotal['TOTAL'];

            echo "
              <tr>
                <td>".$count."</td>
                <td>".$jtitle."</td>
                <td>".$jdesc."</td>
                <td>".$jarea."</td>
                <td>".$jsalary."</td>
                <td>".$jaddress."</td>
                <td>".$jstart." - ".$jend."</td>
                <td>";
                  echo ($jstatus == 0) ? "<h4><span class='label label-danger'>Closed</span></h4>" : "<h4><span class='label label-success'>Open</span></h4>";
                echo "</td>
                <td><a href='../viewprovider.php?id=".$jpid."'>".$jpname."</a></td>
                <td>".$totalApplied."</td>
                <td>";
                ?>
                <a href="../viewjob.php?jobid=<?php echo $jid; ?>" class="btn btn-success" title='View job details'><i class="fa fa-fw fa-eye"></i></a>
                <form action='./managejob.php' method='post' onsubmit='return confirm("Delete this job offer?");'>
                  <input type='hidden' name='offerid' value='<?php echo $jid; ?>'>
                  <button type='submit' name='deleteOffer' class='btn btn-danger' title='Delete job offer'><i class="fa fa-fw fa-trash"></i></button>
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
