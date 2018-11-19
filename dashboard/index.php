<?php
  $pageTitle = "Home";
  include './template/header.php';

  if(isset($_POST['insertJob'])) {

    $jtitle = $_POST['jtitle'];
    $jdesc = $_POST['jdesc'];
    $jarea = $_POST['jarea'];
    $jsalary = $_POST['jsalary'];
    $jstart = $_POST['jstart'];
    $jend = $_POST['jend'];

    $dateStart = date("Y-m-d H:i:s",strtotime($jstart));
    $dateEnd = date("Y-m-d H:i:s",strtotime($jend));

    try
    {
      $stmt = $conn->prepare("INSERT INTO
                              JOB (J_TITLE, J_DESC, J_AREA, J_SALARY, J_START, J_END, JP_ID, J_STATUS)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");

      $stmt->execute(array($jtitle, $jdesc, $jarea, $jsalary, $dateStart, $dateEnd, $user_id, 1)); // 0 job close, 1 job open

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
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Job Applications List</h3>
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
        <th>Start Date &amp; Time</th>
        <th>End Date &amp; Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        try
        {
          $stmt = $conn->prepare("SELECT * FROM JOB WHERE JP_ID = ?");
          $stmt->execute(array($user_id));

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

            echo "
              <tr>
                <td>".$count."</td>
                <td>".$jtitle."</td>
                <td>".$jdesc."</td>
                <td>".$jarea."</td>
                <td>".$jsalary."</td>
                <td>".$jstart."</td>
                <td>".$jend."</td>
                <td>";
                  echo ($jstatus == 0) ? "<h4><span class='label label-danger'>Closed</span></h4>" : "<h4><span class='label label-success'>Open</span></h4>";
                echo "</td>
                <td>
                  ";
                  ?>
                  <form action='./index.php' method='post' onsubmit='return confirm("Delete this job?");'>
                    <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                    <button type='submit' name='deleteJob' class='btn btn-danger'><i class="fa fa-fw fa-trash"></i></button>
                  </form>
                  <a href="./editjob.php?id=<?php echo $jid; ?>" class="btn btn-warning"><i class="fa fa-fw fa-edit"></i></a>
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
                    <label for="exampleInputPassword1">Job Area</label>
                    <input type="text" class="form-control" placeholder="Enter Job Area" name="jarea" required>
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
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        </form>

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    $('#jobTable').DataTable({
      "order": [[ 0, "desc" ]]
    });

    $('#startDateTime, #endDateTime').datetimepicker();

  })
</script>
