<?php
  $pageTitle = "Edit Job";
  include './template/header.php';

  if(isset($_POST['updateJob'])) {
    $jid = $_POST['jobid'];
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
      $stmt = $conn->prepare("UPDATE JOB SET J_TITLE = ?, J_DESC = ?, J_AREA = ?, J_ADDRESS = ?, J_SALARY = ?, J_START = ?, J_END = ? WHERE J_ID = ?");

      $stmt->execute(array($jtitle, $jdesc, $jarea, $jaddress, $jsalary, $dateStart, $dateEnd, $jid));

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully Updated');
      window.location.href='./index.php';
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

  $jobid = isset($_GET['id']) ? $_GET['id'] : 0;

  try
  {
    $stmt = $conn->prepare("SELECT * FROM JOB WHERE J_ID = ?");
    $stmt->execute(array($jobid));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $jid = $result['J_ID'];
    $jtitle = $result['J_TITLE'];
    $jdesc = $result['J_DESC'];
    $jarea = $result['J_AREA'];
    $jaddress = $result['J_ADDRESS'];
    $jsalary = $result['J_SALARY'];
    $jstart = date('m-d-Y h:i A', strtotime($result['J_START']));
    $jend = date('m-d-Y h:i A', strtotime($result['J_END']));
  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Edit Job</h3>
  </div>

<!--modal body-->
  <form action="./editjob.php?id=<?php echo $jobid; ?>" method="post" onsubmit="return confirm('Update this job?');">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Job Title</label>
        <input type="text" class="form-control" placeholder="Enter Job Title" name="jtitle" value="<?php echo $jtitle; ?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job Description</label>
        <input type="text" class="form-control" placeholder="Enter Job Description" name="jdesc" value="<?php echo $jdesc; ?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job Area Tag (no space)</label>
        <input type="text" class="form-control" placeholder="Separated by coma for multiple areas. Ex: 'programming,kitchen,office'" name="jarea" value="<?php echo $jarea; ?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job Address</label>
        <textarea class="form-control" placeholder="Enter Address for the job" name="jaddress" required><?php echo $jaddress; ?></textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job Salary</label>
        <input type="text" class="form-control" placeholder="Enter Job Salary" name="jsalary" value="<?php echo $jsalary; ?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job Start</label>
        <input type="text" id="startDateTime" class="form-control" placeholder="Enter Job Start Date and Time" name="jstart" value="<?php echo $jstart; ?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Job End</label>
        <input type="text" id="endDateTime" class="form-control" placeholder="Enter Job End Date and Time" name="jend" value="<?php echo $jend; ?>" required>
      </div>
    </div>
    <div class="box-footer">
      <a href="./index.php" class="btn btn-default">Cancel</a>
      <input type="hidden" name="jobid" value="<?php echo $jid; ?>">
      <button type="submit" class="btn btn-success pull-right" name="updateJob">Save changes</button>
    </div>
  </form>

</div>

<?php include './template/footer.php'; ?>

<script>
  $(function () {

    $('#startDateTime, #endDateTime').datetimepicker();

  })
</script>
