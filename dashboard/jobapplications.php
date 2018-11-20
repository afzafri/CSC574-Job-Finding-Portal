<?php
  $pageTitle = "Job Applications";
  include './template/header.php';
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Applications List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="jobTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Applicant</th>
        <th>Job Title</th>
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
          $stmt->execute(array($user_id));

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jid = $result['J_ID'];
            $jsid = $result['JS_ID'];
            $applydate = date('m-d-Y h:i A', strtotime($result['APPLY_DATE']));
            $astatus = $result['STATUS'];
            $jobtitle = $result['J_TITLE'];
            $applicant = $result['JS_NAME'];

            echo "
              <tr>
                <td>".$count."</td>
                <td>".$applicant."</td>
                <td>".$jobtitle."</td>
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
                <td></td>
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
