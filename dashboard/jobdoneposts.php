<?php
  $pageTitle = "Manage Job Done Posts";
  include './template/header.php';
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Posts List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="postsTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Job</th>
        <th>Experience</th>
        <th>Job Photo</th>
        <th>Date &amp; Time</th>
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
            FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
            WHERE D.JS_ID = S.JS_ID
            AND D.J_ID = J.J_ID
            AND J.JP_ID = P.JP_ID
            AND D.JS_ID = ?

          ");
          $stmt->execute(array($user_ids));

          //fetch
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jdid = $result['JD_ID'];
            $jddesc = $result['JD_DESC'];
            $jdpicture = $result['JD_PICTURE'];
            $posttime = date('d/m/Y h:i A', strtotime($result['POST_TIME']));
            $jtitle = $result['J_TITLE'];
            $jpname = $result['JP_NAME'];

            echo "
              <tr>
                <td>".$count."</td>
                <td>".$jtitle." (".$jpname.")</td>
                <td>".$jddesc."</td>
                <td>";
                  if($jdpicture != "") {
                    echo "<img src='../images/postspics/".$jdpicture."'  height='200px'/>";
                  } 
                echo "
                </td>
                <td>".$posttime."</td>
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

<script>
  $(function () {
    $('#postsTable').DataTable({
      "order": [[ 0, "desc" ]]
    });
  })
</script>
