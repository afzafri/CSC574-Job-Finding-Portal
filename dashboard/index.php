<?php
  $pageTitle = "Home";
  include './template/header.php';

  if(isset($_POST['insertJob'])) {

    $jtitle = $_POST['jtitle'];
    $jdesc = $_POST['jdesc'];
    $jarea = $_POST['jarea'];
    $jaddress = $_POST['jaddress'];
    $jsalary = $_POST['jsalary'];
    $jstart = $_POST['jstart'];
    $jend = $_POST['jend'];

    $dateStart = date("Y-m-d H:i:s",strtotime($jstart));
    $dateEnd = date("Y-m-d H:i:s",strtotime($jend));

    try
    {
      $stmt = $conn->prepare("INSERT INTO
                              JOB (J_TITLE, J_DESC, J_AREA, J_ADDRESS, J_SALARY, J_START, J_END, JP_ID, J_STATUS)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");

      $stmt->execute(array($jtitle, $jdesc, $jarea, $jaddress, $jsalary, $dateStart, $dateEnd, $user_ids, 1)); // 0 job close, 1 job open

      echo "
      <script>
      alert('New job posted.');
      </script>";

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

  if(isset($_POST['closeJob'])) {

    $jid = $_POST['jobid'];
    $jstatus = ($_POST['jobstatus'] == 1) ? 0 : 1;
    try
    {
      $stmt = $conn->prepare("UPDATE JOB SET J_STATUS = ? WHERE J_ID = ?");

      $stmt->execute(array($jstatus,$jid));

      if($jstatus == 1) {
        echo "
        <script>
        alert('Job offer opened.');
        </script>";
      } else {
        echo "
        <script>
        alert('Job offer closed.');
        </script>";
      }


    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

  if(isset($_POST['deleteJob'])) {

    $jid = $_POST['jobid'];
    try
    {
      $stmt = $conn->prepare("DELETE FROM JOB WHERE J_ID = ?");

      $stmt->execute(array($jid));

      echo "
      <script>
      alert('Job deleted.');
      </script>";

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

  if(isset($_POST['cancelApp'])) {

    $jid = $_POST['jobid'];
    $jsid = $_POST['seekerid'];
    try
    {
      $stmt = $conn->prepare("DELETE FROM JOB_APPLICATION WHERE J_ID = ? AND JS_ID = ?");

      $stmt->execute(array($jid, $jsid));

      echo "
      <script>
      alert('Application has been canceled.');
      </script>";

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

?>

<!-- modal alert if no profile data -->
<div class="modal fade" id="modal-updateprofile" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Hi, Welcome to JFP!</h4>
      </div>
      <div class="modal-body">
        <p>Hi! Welcome to JFP! You profile data still incomplete.</p>
        <p>Please update your profile information by heading to your profile page setting.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <a href="./profile.php" type="button" class="btn btn-primary">Go to Profile Page</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
  if($level == 2) {
    ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Jobs List</h3>
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-add-job"><i class="fa fa-fw fa-plus"></i> Add Job</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="jobTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Area</th>
            <th>Salary</th>
            <th>Job Duration</th>
            <th>No. Applications</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            try
            {
              // list all job for current logged in job provider
              $stmt = $conn->prepare("SELECT * FROM JOB WHERE JP_ID = ?");
              $stmt->execute(array($user_ids));

              //fetch
              while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $jid = $result['J_ID'];
                $jtitle = $result['J_TITLE'];
                $jdesc = $result['J_DESC'];
                $jarea = $result['J_AREA'];
                $jsalary = $result['J_SALARY'];
                $jstart = date('m-d-Y h:i A', strtotime($result['J_START']));
                $jend = date('m-d-Y h:i A', strtotime($result['J_END']));
                $jstatus = $result['J_STATUS'];

                // count and get number of applications for each job
                $stmtApp = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM JOB_APPLICATION WHERE J_ID = ?");
                $stmtApp->execute(array($jid));
                $resApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
                $totalApp = $resApp['TOTAL'];

                echo "
                  <tr>
                    <td>".$count."</td>
                    <td>".$jtitle."</td>
                    <td>".$jdesc."</td>
                    <td>".$jarea."</td>
                    <td>".$jsalary."</td>
                    <td>".$jstart." to ".$jend."</td>
                    <td>".$totalApp."</td>
                    <td>";
                      echo ($jstatus == 0) ? "<h4><span class='label label-danger'>Closed</span></h4>" : "<h4><span class='label label-success'>Open</span></h4>";
                    echo "</td>
                    <td>
                      ";
                      ?>
                      <a href="./editjob.php?id=<?php echo $jid; ?>" class="btn btn-warning" title='Edit job'><i class="fa fa-fw fa-edit"></i></a>
                      <?php
                        $statusmsg = "Open";
                        $btncolor = 'btn btn-success';
                        $btnicon = 'fa-lock';
                        if($jstatus == 1) {
                          $statusmsg = "Close";
                          $btncolor = 'btn btn-primary';
                          $btnicon = 'fa-unlock';
                        }
                      ?>
                      <form action='./index.php' method='post' onsubmit='return confirm("<?php echo $statusmsg; ?> this job offer?");'>
                        <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                        <input type='hidden' name='jobstatus' value='<?php echo $jstatus; ?>'>
                        <button type='submit' name='closeJob' class='<?php echo $btncolor; ?>' title='<?php echo $statusmsg." job offer."; ?>'><i class="fa fa-fw <?php echo $btnicon; ?>"></i></button>
                      </form>
                      <form action='./index.php' method='post' onsubmit='return confirm("Delete this job?");'>
                        <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                        <button type='submit' name='deleteJob' class='btn btn-danger' title='Delete job'><i class="fa fa-fw fa-trash"></i></button>
                      </form>
                      <?php
                      echo"
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
    <!--modal dialog -->
    <div class="modal fade" id="modal-add-job" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Job</h4>
                  </div>
                  <form action="./index.php" method="post">
                    <div class="modal-body">
                    <!--modal body-->
                    <div class="box-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Job Title</label>
                        <input type="text" class="form-control" placeholder="Enter Job Title" name="jtitle" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Description</label>
                        <input type="text" class="form-control" placeholder="Enter Job Description" name="jdesc" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Area Tag (no space)</label>
                        <input type="text" class="form-control" placeholder="Enter Job Area. Separated by coma for multiple areas. Ex: 'programming,kitchen,office'" name="jarea" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Address</label>
                        <textarea class="form-control" placeholder="Enter Address for the job" name="jaddress" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Salary</label>
                        <input type="text" class="form-control" placeholder="Enter Job Salary" name="jsalary" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Start</label>
                        <input type="text" id="startDateTime" class="form-control" placeholder="Enter Job Start Date and Time" name="jstart" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job End</label>
                        <input type="text" id="endDateTime" class="form-control" placeholder="Enter Job End Date and Time" name="jend" required>
                      </div>


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="insertJob">Save changes</button>
                    </div>
                  </div>
                  </form>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
    <?php
  } else if($level == 3) {
    ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Applications List</h3>
        <a href="../jobsearch.php" class="btn btn-success pull-right"><i class="fa fa-fw fa-search"></i> Find Job Offers</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="applicationTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Job Provider</th>
            <th>Job Title</th>
            <th>Job Salary</th>
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
              // list all job application for current logged in job seeker
              $stmt = $conn->prepare("

                SELECT *
                FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P, JOB_SEEKER S
                WHERE A.J_ID = J.J_ID
                AND A.JS_ID = S.JS_ID
                AND J.JP_ID = P.JP_ID
                AND S.JS_ID = ?

              ");
              $stmt->execute(array($user_ids));

              //fetch
              while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $jid = $result['J_ID'];
                $jpid = $result['JP_ID'];
                $jsid = $result['JS_ID'];
                $applydate = date('m-d-Y h:i A', strtotime($result['APPLY_DATE']));
                $astatus = $result['STATUS'];
                $jobtitle = $result['J_TITLE'];
                $jobsalary = $result['J_SALARY'];
                $startdate = date('m-d-Y', strtotime($result['J_START']));
                $enddate = date('m-d-Y', strtotime($result['J_END']));
                $jobprovider = $result['JP_NAME'];

                echo "
                  <tr>
                    <td>".$count."</td>
                    <td>".$jobprovider."</td>
                    <td>".$jobtitle."</td>
                    <td>".$jobsalary."</td>
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
                        <form action='./index.php' method='post' onsubmit='return confirm("Cancel Application?");'>
                          <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                          <input type='hidden' name='seekerid' value='<?php echo $jsid; ?>'>
                          <button type='submit' name='cancelApp' class='btn btn-danger' title='Cancel Application'><i class="fa fa-fw fa-ban"></i></button>
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
    <?php
  }
?>

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    $('#jobTable, #applicationTable').DataTable({
      "order": [[ 0, "desc" ]]
    });

    $('#startDateTime, #endDateTime').datetimepicker();

  })
</script>

<?php
if($user_name == "") {
  ?>
  <script>
    $(function() {
      $('#modal-updateprofile').modal('toggle');
    })
  </script>
  <?php
}
?>
