<?php
  $pageTitle = "Manage User Post";
  include './template/header.php';

  if(isset($_POST['deletePost'])) {

    $postid = $_POST['postid'];
    try
    {
      $stmtJ = $conn->prepare("DELETE FROM JOB_DONE WHERE JD_ID = ?");
      $stmtJ->execute(array($postid));

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
    <h3 class="box-title">Users Job Done Post List</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="postsTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>#</th>
        <th>Job Seeker</th>
        <th>Post</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        try
        {
          $stmtPost = $conn->prepare("
                                    SELECT *
                                    FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                    WHERE D.JS_ID = S.JS_ID
                                    AND D.J_ID = J.J_ID
                                    AND J.JP_ID = P.JP_ID
                                    ORDER BY POST_TIME DESC
                                    ");
          $stmtPost->execute();

          //fetch
          while($post = $stmtPost->fetch(PDO::FETCH_ASSOC)) {

            $jdid = $post['JD_ID'];
            $jddesc = $post['JD_DESC'];
            $jdpic = $post['JD_PICTURE'];
            $jdposttime = date('F d, Y \a\t h:i A', strtotime($post['POST_TIME']));
            $jsid = $post['JS_ID'];
            $jsname = $post['JS_NAME'];
            $jsprofilepic = ($post['JS_PROFILEPIC'] != "") ? "../images/profilepics/".$post['JS_PROFILEPIC'] : "./template/dist/img/avatar.png";

            echo "
              <tr>
                <td>$count</td>
                <td>
                  <img src='$jsprofilepic' width='50px'> <br>
                  <a href='./viewseeker.php?id=$jsid'>$jsname</a>
                </td>
                <td>
                $jddesc <br>
                ";
                if($jdpic !== "") {
                  echo "<img src='../images/postspics/$jdpic' height='400px'> <br><br>";
                }
                echo"
                </td>
                <td>$jdposttime</td>
                <td>";
                ?>
                <form action='./managepost.php' method='post' onsubmit='return confirm("Delete this user post?");'>
                  <input type='hidden' name='postid' value='<?php echo $jdid; ?>'>
                  <button type='submit' name='deletePost' class='btn btn-danger' title='Delete user post'><i class="fa fa-fw fa-trash"></i></button>
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
