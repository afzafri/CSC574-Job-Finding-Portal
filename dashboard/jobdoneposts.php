<?php
  $pageTitle = "Manage Job Done Posts";
  include './template/header.php';

  if(isset($_POST['deletePost'])) {

    $postid = $_POST['postid'];
    try
    {
      $stmt = $conn->prepare("DELETE FROM JOB_DONE WHERE JD_ID = ?");

      $stmt->execute(array($postid));

      echo "
      <script>
      alert('Post deleted.');
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
    <h3 class="box-title">Posts List</h3>
    <a href="../index.php" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus"></i> Create new post</a>
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
                <td>";
                ?>
                <a href="./editpost.php?id=<?php echo $jdid; ?>" class="btn btn-warning" title='Edit post'><i class="fa fa-fw fa-edit"></i></a>
                <form action='./jobdoneposts.php' method='post' onsubmit='return confirm("Delete this post?");'>
                  <input type='hidden' name='postid' value='<?php echo $jdid; ?>'>
                  <button type='submit' name='deletePost' class='btn btn-danger' title='Delete post'><i class="fa fa-fw fa-trash"></i></button>
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
