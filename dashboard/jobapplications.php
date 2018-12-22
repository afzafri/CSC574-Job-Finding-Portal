<?php
  $pageTitle = "Job Applications";
  include './template/header.php';

  if(isset($_POST['approveJob'])) {

    $jid = $_POST['jobid'];
    $jsid = $_POST['seekerid'];
    try
    {
      $stmt = $conn->prepare("UPDATE JOB_APPLICATION SET STATUS = ? WHERE J_ID = ? AND JS_ID = ?");

      $stmt->execute(array(1,$jid, $jsid));

      echo "
      <script>
      alert('Job application approved.');
      </script>";
    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

  if(isset($_POST['declineJob'])) {

    $jid = $_POST['jobid'];
    $jsid = $_POST['seekerid'];
    try
    {
      $stmt = $conn->prepare("UPDATE JOB_APPLICATION SET STATUS = ? WHERE J_ID = ? AND JS_ID = ?");

      $stmt->execute(array(0,$jid, $jsid));

      echo "
      <script>
      alert('Job application declined.');
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
    <h3 class="box-title">Applications List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="applicationsTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Applicant</th>
        <th>Job Title</th>
        <th>Job Salary</th>
        <th>Job Location</th>
        <th>Job Duration</th>
        <th>Apply Date</th>
        <th>Status</th>
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
            FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P, JOB_SEEKER S
            WHERE A.J_ID = J.J_ID
            AND A.JS_ID = S.JS_ID
            AND J.JP_ID = P.JP_ID
            AND J.JP_ID = ?

          ");
          $stmt->execute(array($user_ids));

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jid = $result['J_ID'];
            $jsid = $result['JS_ID'];
            $applydate = date('d/m/Y h:i A', strtotime($result['APPLY_DATE']));
            $astatus = $result['STATUS'];
            $jobtitle = $result['J_TITLE'];
            $jobaddress = $result['J_ADDRESS'];
            $jobsalary = $result['J_SALARY'];
            $startdate = date('d/m/Y', strtotime($result['J_START']));
            $enddate = date('d/m/Y', strtotime($result['J_END']));
            $applicant = $result['JS_NAME'];

            echo "
              <tr>
                <td>".$count."</td>
                <td><a href='../viewseeker.php?id=$jsid'>$applicant</a></td>
                <td><a href='../viewjob.php?jobid=$jid'>$jobtitle</a></td>
                <td>".$jobsalary."</td>
                <td>".$jobaddress."</td>
                <td>".$startdate." - ".$enddate."</td>
                <td>".$applydate."</td>
                <td>";
                  if($astatus == 2) {
                    echo "<h4><span class='label label-warning'>Pending</span></h4>";
                  } else if($astatus == 1) {
                    echo "<h4><span class='label label-success'>Approved</span></h4>";
                  } else {
                    echo "<h4><span class='label label-danger'>Declined</span></h4>";
                  }
                echo "</td>
                <td>
                  ";
                  if($astatus == 2) {
                    ?>
                    <form action='./jobapplications.php' method='post' onsubmit='return confirm("Approve this job application?");'>
                      <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                      <input type='hidden' name='seekerid' value='<?php echo $jsid; ?>'>
                      <button type='submit' name='approveJob' class='btn btn-success' title='Approve application'><i class="fa fa-fw fa-check"></i></button>
                    </form>
                    <form action='./jobapplications.php' method='post' onsubmit='return confirm("Decline this job application?");'>
                      <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                      <input type='hidden' name='seekerid' value='<?php echo $jsid; ?>'>
                      <button type='submit' name='declineJob' class='btn btn-danger' title='Decline application'><i class="fa fa-fw fa-close"></i></button>
                    </form>
                    <?php
                  } else {
                    echo "<i>No actions</i>";
                  }
                  echo "
                </td>
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
