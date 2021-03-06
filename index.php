<?php
  $pageTitle = "Job Done Posts";
  include './template/header.php';

  if(isset($_POST['newPost'])) {
    $job = $_POST['job'];
    $experience = $_POST['experience'];
    $imagepath = "";

    // upload pic
    $imgUpmsg = "";
    if(isset($_FILES['image']) && $_FILES['image']['size'] > 0)
    {
      require_once('./uploader.class.php');
      $obj = new Uploader();

      $obj->dir = "./images/postspics/"; //directory to store the image/file
      $obj->files = $_FILES["image"]; //receive from form
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
        // set image path
        $imagepath = $stat['success']['filename'];
        $imgUpmsg = $stat['success']['status'];
      }
    }

    try
    {
      $stmt = $conn->prepare("
                      INSERT INTO JOB_DONE (JD_DESC, JD_PICTURE, JS_ID, J_ID, POST_TIME)
                      VALUES (?, ?, ?, ?, NOW())
                    ");
      $stmt->execute(array($experience, $imagepath, $user_ids, $job));

      echo ("<script LANGUAGE='JavaScript'>
      window.alert('Create new post success.');
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

  // function to show time ago
  date_default_timezone_set("Asia/Kuala_Lumpur");
  function time_elapsed_string($datetime, $full = false) {
      $now = new DateTime;
      $ago = new DateTime($datetime);
      $diff = $now->diff($ago);

      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $string = array(
          'y' => 'year',
          'm' => 'month',
          'w' => 'week',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second',
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }

      if (!$full) $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

?>


<!-- Start blog-posts Area -->
<section class="blog-posts-area section-gap">
  <div class="container">
    <div class="row">

      <!-- list post -->
      <div class="col-lg-8 post-list">

        <?php
          if($user_id != "" && $level == 3){
            ?>
            <form class="form-area single-widget" action="./index.php" method="post" class="contact-form text-right" enctype="multipart/form-data" onsubmit="return confirm('Post status?');">
              <div class="row">
                <div class="col-lg-12 form-group">

                  <select name="job" class="common-input mb-20 form-control select2" style="width:100%!important;" required>
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

                        $jobid = $resultLJ['J_ID'];
                        $jobname = $resultLJ['J_TITLE'];
                        $jobstart = date('m/y', strtotime($resultLJ['J_START']));
                        $jobend = date('m/y', strtotime($resultLJ['J_END']));
                        $jpname = $resultLJ['JP_NAME'];

                        echo "<option value='$jobid'>$jobname by $jpname ($jobstart - $jobend)</option>";

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
                  <br><br>

                  <textarea class="common-textarea mt-10 form-control" name="experience" placeholder="Share your job experience" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Share your job experience'" id="jobDoneExperience" required=""></textarea>

                  <input name="image" class="common-input mb-20 form-control" type="file" id="jobImage">

                  <button class="primary-btn mt-20 text-white" style="float: right;" type="submit" name="newPost">Post Job Done</button>
                  <div class="mt-20 alert-msg" style="text-align: left;"></div>
                </div>
              </div>
            </form>
            <?php
          } ?>

        <?php

        // PHP pagination library
        // include the pagination class
        require './Zebra_Pagination.php';
        // how many records should be displayed on a page?
        $records_per_page = 5;
        // instantiate the pagination object
        $pagination = new Zebra_Pagination();
        // get mysql query limit
        $maxLimit = (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page;
        $totalRows = 0;

        $search = (isset($_GET['search'])) ? $_GET['search'] : "";
        $tags = (isset($_GET['tags'])) ? $_GET['tags'] : "";
        try
        {
          // no search
          if($tags == "" && $search == "") {
            $stmtJD = $conn->prepare("
                                    SELECT *
                                    FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                    WHERE D.JS_ID = S.JS_ID
                                    AND D.J_ID = J.J_ID
                                    AND J.JP_ID = P.JP_ID
                                    ORDER BY POST_TIME DESC
                                    LIMIT $maxLimit
                                    ");

            $stmtJD->execute();

            // get total row count
            $stmtCount = $conn->prepare("
              SELECT *
              FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
              WHERE D.JS_ID = S.JS_ID
              AND D.J_ID = J.J_ID
              AND J.JP_ID = P.JP_ID
              ORDER BY POST_TIME DESC
            ");
            $stmtCount->execute();
            $totalRows = $stmtCount->rowCount();
          }

          if($search != "" && $tags == "") {
            $stmtJD = $conn->prepare("
                                    SELECT *
                                    FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                    WHERE D.JS_ID = S.JS_ID
                                    AND D.J_ID = J.J_ID
                                    AND J.JP_ID = P.JP_ID
                                    AND J.J_TITLE LIKE ?
                                    ORDER BY POST_TIME DESC
                                    LIMIT $maxLimit
                                    ");

            $stmtJD->execute(array("%$search%"));

            // get total row count
            $stmtCount = $conn->prepare("
              SELECT *
              FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
              WHERE D.JS_ID = S.JS_ID
              AND D.J_ID = J.J_ID
              AND J.JP_ID = P.JP_ID
              AND J.J_TITLE LIKE ?
              ORDER BY POST_TIME DESC
            ");
            $stmtCount->execute(array("%$search%"));
            $totalRows = $stmtCount->rowCount();
          }

          if($search == "" && $tags != "") {
            $stmtJD = $conn->prepare("
                                    SELECT *
                                    FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                    WHERE D.JS_ID = S.JS_ID
                                    AND D.J_ID = J.J_ID
                                    AND J.JP_ID = P.JP_ID
                                    AND J.J_AREA LIKE ?
                                    ORDER BY POST_TIME DESC
                                    LIMIT $maxLimit
                                    ");

            $stmtJD->execute(array("%$tags%"));

            // get total row count
            $stmtCount = $conn->prepare("
              SELECT *
              FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
              WHERE D.JS_ID = S.JS_ID
              AND D.J_ID = J.J_ID
              AND J.JP_ID = P.JP_ID
              AND J.J_AREA LIKE ?
              ORDER BY POST_TIME DESC
            ");
            $stmtCount->execute(array("%$tags%"));
            $totalRows = $stmtCount->rowCount();
          }

          // pass the total number of records to the pagination class
          $pagination->records($totalRows);
          // records per page
          $pagination->records_per_page($records_per_page);
          // custom previous next icon
          $pagination->labels('<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>');

          while($resultJD = $stmtJD->fetch(PDO::FETCH_ASSOC)) {
            $jdid = $resultJD['JD_ID'];
            $jddesc = $resultJD['JD_DESC'];
            $jdpic = $resultJD['JD_PICTURE'];
            $jdposttime = date('F d, Y \a\t h:i A', strtotime($resultJD['POST_TIME']));
            $jid = $resultJD['J_ID'];
            $jtitle = $resultJD['J_TITLE'];
            $areaTags = explode(",", $resultJD['J_AREA']);
            $jsid = $resultJD['JS_ID'];
            $jpid = $resultJD['JP_ID'];
            $jpname = $resultJD['JP_NAME'];
            $jsname = $resultJD['JS_NAME'];
            $jsprofilepic = ($resultJD['JS_PROFILEPIC'] != "") ? "./images/profilepics/".$resultJD['JS_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";
            $jaddress = $resultJD['J_ADDRESS'];

            ?>

              <div class="single-post">

                <a href="./viewjob.php?jobid=<?php echo $jid; ?>" title="View Job Details">
                  <h1>
                    <?php echo $jtitle; ?>
                  </h1>
                </a>

                <table>
                  <tr>
                    <td>
                      <img src='<?php echo $jsprofilepic; ?>' alt='<?php echo $jtitle; ?>' width="50px"> &nbsp;
                    </td>
                    <td>
                      <br>
                      <h5><a href="./viewseeker.php?id=<?php echo $jsid; ?>"><?php echo $jsname; ?></a></h5>

                      <?php
                        if(date('Ymd') == date('Ymd', strtotime($resultJD['POST_TIME']))) {
                          echo time_elapsed_string($resultJD['POST_TIME']);
                        } else {
                          ?>
                          <p class="date"><?php echo $jdposttime; ?> </p>
                          <?php
                        }

                       ?>
                    </td>
                  </tr>
                </table>

                <p class="text-left">
                  <i class="fa fa-building" aria-hidden="true"></i> <a href="./viewprovider.php?id=<?php echo $jpid; ?>"><?php echo $jpname; ?></a> <br>
                  <i class="fa fa-fw fa-map-marker"></i> <?php echo $jaddress; ?>
                </p>
                <p>
                  <?php
                    if($jdpic !== "") {
                      echo "<img src='./images/postspics/$jdpic' alt='$jtitle' height='400px'> <br><br>";
                    }
                  ?>
                  <?php echo $jddesc; ?>
                </p>

                <div class="thumb">
                  <ul class="tags">
                    <?php
                      foreach ($areaTags as $areaTags) {
                        ?>
                          <li>
                            <a href="./index.php?tags=<?php echo $areaTags; ?>"><?php echo $areaTags; ?></a>
                          </li>
                        <?php
                      }
                    ?>
                  </ul>
                </div>

              </div>

            <?php

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

        // render the pagination links
        $pagination->render();

        ?>
      </div>
      <!-- end post -->

      <!-- sidebar -->
      <div class="col-lg-4 sidebar">
        <div class="single-widget search-widget">
          <form class="example" action="./index.php" style="margin:auto;max-width:300px">
            <input type="text" placeholder="Search Posts" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>

        <div class="single-widget recent-posts-widget">
          <h4 class="title">Recent Posts</h4>
          <div class="blog-list ">
            <?php
            $stmtRecent = $conn->prepare("
                                        SELECT *
                                        FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                        WHERE D.JS_ID = S.JS_ID
                                        AND D.J_ID = J.J_ID
                                        AND J.JP_ID = P.JP_ID
                                        AND DATE(POST_TIME) = CURDATE()
                                        ORDER BY POST_TIME DESC
                                        LIMIT 5
                                    ");
              $stmtRecent->execute();
              while($result = $stmtRecent->fetch(PDO::FETCH_ASSOC)) {
                $jdid = $result['JD_ID'];
                $jdpic = $result['JD_PICTURE'];
                $jdposttime = $result['POST_TIME'];
                $jid = $result['J_ID'];
                $jtitle = $result['J_TITLE'];
                $jsid = $result['JS_ID'];
                $jsname = $result['JS_NAME'];
                ?>
                  <div class="single-recent-post d-flex flex-row">
                    <div class="recent-thumb">
                        <?php
                          if($jdpic !== "") {
                            echo "<img class='img-fluid' src='./images/postspics/$jdpic' alt=''>";
                          }
                        ?>
                    </div>
                    <div class="recent-details">
                        <h4>
                          <?php echo $jtitle." by ".$jsname; ?>
                        </h4>
                      <p>
                        <?php echo time_elapsed_string($jdposttime); ?>
                      </p>
                    </div>
                  </div>
                <?php
              }
              ?>
          </div>
        </div>

        <div class="single-widget tags-widget">
          <h4 class="title">Post Categories</h4>
           <ul>
             <?php
               $listAreaTags = array();
               $stmtTags = $conn->prepare("SELECT J_AREA FROM JOB WHERE J_STATUS = 1");
               $stmtTags->execute();
               while($result = $stmtTags->fetch(PDO::FETCH_ASSOC)) {
                 $arrarea = explode(",", $result['J_AREA']);

                 foreach ($arrarea as $arrarea) {
                   if(!in_array($arrarea, $listAreaTags)){
                     $listAreaTags[]=$arrarea;
                   }
                 }
               }

               $tagsArr = array();
               // loop tags, to find total of jobs
               foreach ($listAreaTags as $artag)
               {
                 $stmtArTag = $conn->prepare("SELECT COUNT(*) TOTAL FROM JOB WHERE J_AREA LIKE ?");
                 $stmtArTag->execute(array("%$artag%"));
                 $resArTag = $stmtArTag->fetch(PDO::FETCH_ASSOC);
                 $totalArTag = $resArTag['TOTAL'];

                 $tagsArr[] = array('tag' => $artag, 'total' => $totalArTag);
               }
               // sort the array by descending order by total jobs
               array_multisort(array_column($tagsArr, "total"), SORT_DESC, $tagsArr);

               foreach ($tagsArr as $newtag) {
                 ?>
                    <li>
                      <a class="justify-content-between d-flex" href="./index.php?tags=<?php echo $newtag['tag']; ?>">
                        <?php echo $newtag['tag']; ?> (<?php echo $newtag['total']; ?>)
                      </a>
                    </li>
                 <?php
               }
             ?>
           </ul>
        </div>

        <div class="single-widget category-widget">
          <h4 class="title">Post Archive</h4>
          <ul>
            <?php
            $stmtArchive = $conn->prepare("
                                      SELECT MONTH(POST_TIME) AS MONTH, COUNT(*) AS TOTAL
                                      FROM JOB_DONE
                                      WHERE YEAR(POST_TIME) = YEAR(CURRENT_DATE)
                                      GROUP BY MONTH(POST_TIME)
                                      ORDER BY MONTH(POST_TIME) DESC
                                    ");
              $stmtArchive->execute();
              while($result = $stmtArchive->fetch(PDO::FETCH_ASSOC)) {
                $postmonth = (DateTime::createFromFormat('!m', $result['MONTH']))->format('F');
                $posttotal = $result['TOTAL'];
                ?>
                  <li><a href="#" class="justify-content-between align-items-center d-flex"><h6><?php echo $postmonth; ?></h6> <span><?php echo $posttotal; ?></span></a></li>
                <?php
              }
              ?>
          </ul>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- End blog-posts Area -->

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    <?php
      if($user_id != "" && $level == 3){
        ?>
          CKEDITOR.replace('jobDoneExperience');
        <?php
      }
    ?>

    $("#jobImage").fileinput({
      theme: 'fa',
      dropZoneEnabled: false,
      showUpload: false,
      allowedFileExtensions: ['png','jpg','jpeg'],
      maxFileSize: 5000,
      msgPlaceholder: 'Choose image...',
    });
  });
  </script>
