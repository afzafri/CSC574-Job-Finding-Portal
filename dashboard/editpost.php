<?php
  $pageTitle = "Edit Job Done Post";
  include './template/header.php';

  if(isset($_POST['updatePost'])) {
    $postid = $_POST['postid'];
    $job = $_POST['job'];
    $experience = $_POST['experience'];
    $imagepath = $_POST['currpic'];

    // upload pic
    $imgUpmsg = "";
    if(isset($_FILES['jobphoto']) && $_FILES['jobphoto']['size'] > 0)
    {
      require_once('../uploader.class.php');
      $obj = new Uploader();

      $obj->dir = "../images/postspics/"; //directory to store the image/file
      $obj->files = $_FILES["jobphoto"]; //receive from form
      $obj->filetype = array('png','jpg','jpeg'); //set the allowed image/file extensions
      $obj->size = 5000000; //set file/image size limit. note: 100000 is 100KB
      $obj->upimg = true; //set true if want to upload image.

      //upload
      $stat = json_decode($obj->upload(), true);

      if(array_key_exists('errors', $stat))
      {
        $imgUpmsg = $stat['errors']['status'];
      }
      else
      {
        // delete old profile pic
        if($imagepath != "") {
          unlink('../images/postspics/'.$imagepath);
        }

        // set new profile pic
        $imagepath = $stat['success']['filename'];
        $imgUpmsg = $stat['success']['status'];
      }
    }

    try
    {
      $stmt = $conn->prepare("UPDATE JOB_DONE SET JD_DESC = ?, JD_PICTURE = ?, J_ID = ? WHERE JD_ID = ?");

      $stmt->execute(array($experience, $imagepath, $job, $postid));

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Succesfully Updated');
      window.location.href='./jobdoneposts.php';
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

  $getpostid = isset($_GET['id']) ? $_GET['id'] : 0;

  try
  {
    $stmt = $conn->prepare("SELECT * FROM JOB_DONE WHERE JD_ID = ?");
    $stmt->execute(array($getpostid));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $jdid = $result['JD_ID'];
    $jddesc = $result['JD_DESC'];
    $jdpicture = $result['JD_PICTURE'];
    $jid = $result['J_ID'];
  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Edit Post</h3>
  </div>

<!--modal body-->
  <form action="./editpost.php?id=<?php echo $getpostid; ?>" enctype="multipart/form-data" method="post" onsubmit="return confirm('Update this post?');">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Job</label>
        <select class="form-control select2" name="job" required>
          <option value="">Choose job</option>
          <?php
          try
          {
            $stmtLJ = $conn->prepare("
                                    SELECT *
                                    FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P
                                    WHERE A.J_ID = J.J_ID
                                    AND J.JP_ID = P.JP_ID
                                    AND STATUS = 1
                                    AND A.JS_ID = ?
                                    ORDER BY J.J_START DESC
                                    ");

            $stmtLJ->execute(array($user_ids));

            while($resultLJ = $stmtLJ->fetch(PDO::FETCH_ASSOC)) {

              $listjobid = $resultLJ['J_ID'];
              $jobname = $resultLJ['J_TITLE'];
              $jobstart = date('m/y', strtotime($resultLJ['J_START']));
              $jobend = date('m/y', strtotime($resultLJ['J_END']));
              $jpname = $resultLJ['JP_NAME'];

              if($listjobid == $jid) {
                echo "<option value='$listjobid' selected>$jobname by $jpname ($jobstart - $jobend)</option>";
              } else {
                echo "<option value='$listjobid'>$jobname by $jpname ($jobstart - $jobend)</option>";
              }

            }
          }
          catch(PDOException $e)
          {
            echo "
            <script>
            alert('". $e->getMessage()."');
            </script>";
            echo "Connection failed : " . $e->getMessage();
          }
          ?>

        </select>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Experience</label>
        <textarea class="form-control" placeholder="Share your job experience" name="experience" id="jobDoneExperience" required><?php echo $jddesc; ?></textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Upload new post photo</label>
        <input type="file" class="form-control-file" name="jobphoto" id="jobphoto">
      </div>

    </div>
    <div class="box-footer">
      <a href="./jobdoneposts.php" class="btn btn-default">Cancel</a>
      <input type="hidden" name="postid" value="<?php echo $jdid; ?>">
      <input type="hidden" name="currpic" value="<?php echo $jdpicture; ?>">
      <button type="submit" class="btn btn-success pull-right" name="updatePost">Save changes</button>
    </div>
  </form>

</div>

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('jobDoneExperience');
    $("#jobphoto").fileinput({
      theme: 'fa',
      dropZoneEnabled: false,
      showUpload: false,
      allowedFileExtensions: ['png','jpg','jpeg'],
      maxFileSize: 5000,
      msgPlaceholder: 'Choose new profile picture...',
      // for image files
      <?php
        if($jdpicture != "") {
          ?>
          initialPreview: [
              "<img src='../images/postspics/<?php echo $jdpicture; ?>' height='150px' class='file-preview-image'>",
          ],
          <?php
        }
      ?>
    });
  });
  </script>
