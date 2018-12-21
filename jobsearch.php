<?php
  $pageTitle = "Job Search";
  include './template/header.php';
?>

<?php
if(isset($_POST['applyjob'])) {

  $jid = $_POST["jobid"];
  $jsid = $user_ids;

  try
  {
    $stmt = $conn->prepare("INSERT INTO
                            JOB_APPLICATION (J_ID, JS_ID, APPLY_DATE, STATUS)
                            VALUES (?, ?, NOW(), ?) ");

    $stmt->execute(array($jid, $jsid, 2));

    echo "
    <script>
    alert('Job applied! Check the application status in your dashboard.');
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
?>

<!-- Start post Area -->
<section class="post-area section-gap">
  <div class="container">

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

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $states = (isset($_GET['states'])) ? $_GET['states'] : "";
    $tags = (isset($_GET['tags'])) ? $_GET['tags'] : "";
    $totalRows = 0;
    try
    {
      // ----- SQL QUERIES -----
      // --- SEARCH TITLE ---
        // --- SEARCH
        if($search != "" && $states == "" && $tags == "") {
            $stmt = $conn->prepare("
              SELECT *
              FROM JOB J, JOB_PROVIDER P
              WHERE J.JP_ID = P.JP_ID
              AND J.J_STATUS = 1
              AND J.J_TITLE LIKE ?
              ORDER BY J_START DESC
              LIMIT $maxLimit
            ");
              $stmt->execute(array("%$search%"));

              // get total row count
              $stmtCount = $conn->prepare("
                SELECT *
                FROM JOB J, JOB_PROVIDER P
                WHERE J.JP_ID = P.JP_ID
                AND J.J_STATUS = 1
                AND J.J_TITLE LIKE ?
                ORDER BY J_START DESC
              ");
              $stmtCount->execute(array("%$search%"));
              $totalRows = $stmtCount->rowCount();
          }
          // --- SEARCH, STATES
          if($search != "" && $states != "" && $tags == "") {
              $stmt = $conn->prepare("
                SELECT *
                FROM JOB J, JOB_PROVIDER P
                WHERE J.JP_ID = P.JP_ID
                AND J.J_STATUS = 1
                AND J.J_TITLE LIKE ?
                AND J.J_ADDRESS LIKE ?
                ORDER BY J_START DESC
                LIMIT $maxLimit
              ");
                $stmt->execute(array("%$search%","%$states%"));

                // get total row count
                $stmtCount = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_TITLE LIKE ?
                  AND J.J_ADDRESS LIKE ?
                  ORDER BY J_START DESC
                ");
                $stmtCount->execute(array("%$search%","%$states%"));
                $totalRows = $stmtCount->rowCount();
            }
          // --- SEARCH, STATES, TAGS
          if($search != "" && $states != "" && $tags != "") {
              $stmt = $conn->prepare("
                SELECT *
                FROM JOB J, JOB_PROVIDER P
                WHERE J.JP_ID = P.JP_ID
                AND J.J_STATUS = 1
                AND J.J_TITLE LIKE ?
                AND J.J_ADDRESS LIKE ?
                AND J.J_AREA LIKE ?
                ORDER BY J_START DESC
                LIMIT $maxLimit
              ");
                $stmt->execute(array("%$search%","%$states%","%$tags%"));

                // get total row count
                $stmtCount = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_TITLE LIKE ?
                  AND J.J_ADDRESS LIKE ?
                  AND J.J_AREA LIKE ?
                  ORDER BY J_START DESC
                ");
                $stmtCount->execute(array("%$search%","%$states%","%$tags%"));
                $totalRows = $stmtCount->rowCount();
          }

        // --- STATES ---
          // --- STATES
          if($search == "" && $states != "" && $tags == "") {
              $stmt = $conn->prepare("
                SELECT *
                FROM JOB J, JOB_PROVIDER P
                WHERE J.JP_ID = P.JP_ID
                AND J.J_STATUS = 1
                AND J.J_ADDRESS LIKE ?
                ORDER BY J_START DESC
                LIMIT $maxLimit
              ");
                $stmt->execute(array("%$states%"));

                // get total row count
                $stmtCount = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_ADDRESS LIKE ?
                  ORDER BY J_START DESC
                ");
                $stmtCount->execute(array("%$states%"));
                $totalRows = $stmtCount->rowCount();
            }
            // --- STATES, TAGS
            if($search == "" && $states != "" && $tags != "") {
                $stmt = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_ADDRESS LIKE ?
                  AND J.J_AREA LIKE ?
                  ORDER BY J_START DESC
                  LIMIT $maxLimit
                ");
                  $stmt->execute(array("%$states%","%$tags%"));

                  // get total row count
                  $stmtCount = $conn->prepare("
                    SELECT *
                    FROM JOB J, JOB_PROVIDER P
                    WHERE J.JP_ID = P.JP_ID
                    AND J.J_STATUS = 1
                    AND J.J_ADDRESS LIKE ?
                    AND J.J_AREA LIKE ?
                    ORDER BY J_START DESC
                  ");
                  $stmtCount->execute(array("%$states%","%$tags%"));
                  $totalRows = $stmtCount->rowCount();
              }

        // --- TAGS ---
          // --- TAGS
          if($search == "" && $states == "" && $tags != "") {
              $stmt = $conn->prepare("
                SELECT *
                FROM JOB J, JOB_PROVIDER P
                WHERE J.JP_ID = P.JP_ID
                AND J.J_STATUS = 1
                AND J.J_AREA LIKE ?
                ORDER BY J_START DESC
                LIMIT $maxLimit
              ");
                $stmt->execute(array("%$tags%"));

                // get total row count
                $stmtCount = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_AREA LIKE ?
                  ORDER BY J_START DESC
                ");
                $stmtCount->execute(array("%$tags%"));
                $totalRows = $stmtCount->rowCount();
            }
            // --- TAGS, SEARCH
            if($search != "" && $states == "" && $tags != "") {
                $stmt = $conn->prepare("
                  SELECT *
                  FROM JOB J, JOB_PROVIDER P
                  WHERE J.JP_ID = P.JP_ID
                  AND J.J_STATUS = 1
                  AND J.J_TITLE LIKE ?
                  AND J.J_AREA LIKE ?
                  ORDER BY J_START DESC
                  LIMIT $maxLimit
                ");
                  $stmt->execute(array("%$search%", "%$tags%"));

                  // get total row count
                  $stmtCount = $conn->prepare("
                    SELECT *
                    FROM JOB J, JOB_PROVIDER P
                    WHERE J.JP_ID = P.JP_ID
                    AND J.J_STATUS = 1
                    AND J.J_TITLE LIKE ?
                    AND J.J_AREA LIKE ?
                    ORDER BY J_START DESC
                  ");
                  $stmtCount>execute(array("%$search%", "%$tags%"));
                  $totalRows = $stmtCount->rowCount();
              }

        // --- NO SEARCH ---
        if($search == "" && $states == "" && $tags == "") {
          $stmt = $conn->prepare("
            SELECT *
            FROM JOB J, JOB_PROVIDER P
            WHERE J.JP_ID = P.JP_ID
            AND J.J_STATUS = 1
            ORDER BY J_START DESC
            LIMIT $maxLimit
          ");
          $stmt->execute();

          // get total row count
          $stmtCount = $conn->prepare("
            SELECT *
            FROM JOB J, JOB_PROVIDER P
            WHERE J.JP_ID = P.JP_ID
            AND J.J_STATUS = 1
            ORDER BY J_START DESC
          ");
          $stmtCount->execute();
          $totalRows = $stmtCount->rowCount();
        }
      }
      catch(PDOException $e)
      {
        echo "Connection failed : " . $e->getMessage();
      }

      // pass the total number of records to the pagination class
      $pagination->records($totalRows);
      // records per page
      $pagination->records_per_page($records_per_page);
      // custom previous next icon
      $pagination->labels('<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>');

    ?>

    <div class="banner-content col-lg-12">
      <form class="serach-form-area" action="./jobsearch.php" method="get">
        <div class="row justify-content-center form-wrap">
          <div class="col-lg-4 form-cols">
            <input type="text" class="form-control" name="search" placeholder="What job are you looking for?" value="<?php echo $search; ?>">
          </div>
          <div class="col-lg-3 form-cols">
            <select name="states" class="default-select select2" style="width: 100%">
              <option value="">Select state</option>

              <?php
                $listnegeri = ["JOHOR","KEDAH","KELANTAN","MELAKA","NEGERI SEMBILAN","PAHANG","PERLIS","PULAU PINANG","PERAK","SABAH","SELANGOR","KUALA LUMPUR","PUTRAJAYA","SARAWAK","TERENGGANU","LABUAN"];

                foreach ($listnegeri as $negeri)
                {
                  if($states == $negeri) {
                    echo "<option value='$negeri' selected>$negeri</option>";
                  } else {
                    echo "<option value='$negeri'>$negeri</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="col-lg-3 form-cols">
            <select name="tags" class="select2" style="width: 100%">
              <option value="">All area tags</option>

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

                foreach ($listAreaTags as $areaTags)
                {
                  if($tags == $areaTags) {
                    echo "<option value='$areaTags' selected>$areaTags</option>";
                  } else {
                    echo "<option value='$areaTags'>$areaTags</option>";
                  }
                }

              ?>
            </select>
          </div>
          <div class="col-lg-2 form-cols">
              <button type="submit" class="btn btn-info">
                <span class="lnr lnr-magnifier"></span> Search
              </button>
          </div>
        </div>
      </form>
    </div>

    <br>

    <div class="row justify-content-center d-flex">

      <!--Job offers -->
      <div class="col-lg-8 post-list">

        <?php

        try
        {

          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jid = $result['J_ID'];
            $jtitle = $result['J_TITLE'];
            $jdesc = $result['J_DESC'];
            $areaTags = explode(",", $result['J_AREA']);
            $jsalary = $result['J_SALARY'];
            $jaddress = $result['J_ADDRESS'];
            $jstart = date('d/m/Y h:i A', strtotime($result['J_START']));
            $jend = date('d/m/Y h:i A', strtotime($result['J_END']));
            $jstatus = $result['J_STATUS'];
            $jpname = $result['JP_NAME'];

            // check if user have applied the job
            $stmtCheck = $conn->prepare("SELECT * FROM JOB_APPLICATION WHERE J_ID = ? AND JS_ID = ?");
            $stmtCheck->execute(array($jid, $user_ids));
            $btnstatus = "";
            $btntitle = "Click to apply now";
            if($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
              $btnstatus = "disabled";
              $btntitle = "You have already applied for this job.";
            }

          ?>

          <div class="single-post">
            <div class="row">
              <div class="col-sm-10">
                <a href="./viewjob.php?jobid=<?php echo $jid; ?>"><h4><?php echo $jtitle; ?></h4></a>
                <h6>by <a href="./viewprovider.php?id=<?php echo $jpid; ?>"><?php echo $jpname; ?></a></h6>
              </div>
              <div class="col-sm-2">
                <?php
                  if($user_id != "" && $level == 3){
                    ?>
                    <form action="./jobsearch.php" method='post' onsubmit='return confirm("Do you want to apply this job?")'>
                      <input type='hidden' name='jobid' value='<?php echo $jid;?>'/>
                      <button type='submit' name="applyjob" class="btn btn-default <?php echo $btnstatus; ?>" title="<?php echo $btntitle; ?>" <?php echo $btnstatus; ?>>Apply</button>
                    </form>
                <?php }?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <hr>
                <p><?php echo $jdesc; ?></p>
                <hr>
                <p class="address"><span class="lnr lnr-map"></span> <?php echo $jaddress ?></p>
                <p class="address"><span class="fa fa-hourglass-start"></span> <?php echo "Start Date: ".$jstart; ?></p>
                <p class="address"><span class="fa fa-hourglass-end"></span> <?php echo "End Date: ".$jend; ?></p>
                <p class="address"><span class="lnr lnr-database"></span> <?php echo "RM ".$jsalary; ?></p>

                <div class="thumb">
                  <ul class="tags">
                    <?php
                      foreach ($areaTags as $areaTags) {
                        ?>
                          <li>
                            <a href="./jobsearch.php?search=&states=&tags=<?php echo $areaTags; ?>"><?php echo $areaTags; ?></a>
                          </li>
                        <?php
                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>

            <br>
            <a class="ticker-btn pull-right" href="./viewjob.php?jobid=<?php echo $jid; ?>">View Job Details</a> <br>
          </div>

            <?php

          }

        }
        catch(PDOException $e)
        {
          echo "Connection failed : " . $e->getMessage();
        }

        // render the pagination links
        $pagination->render();

        ?>

      </div> <!-- end job offer -->

      <div class="col-lg-4 sidebar">

        <div class="single-slidebar">
          <h4>Jobs by Location</h4>
          <ul class="cat-list">

            <?php
              $jobLocArr = array();
              // loop states, to find total of jobs
              foreach ($listnegeri as $negeri)
              {
                $stmtJobLoc = $conn->prepare("SELECT COUNT(*) TOTAL FROM JOB WHERE J_ADDRESS LIKE ?");
                $stmtJobLoc->execute(array("%$negeri%"));
                $resJobLoc = $stmtJobLoc->fetch(PDO::FETCH_ASSOC);
                $totalJobLoc = $resJobLoc['TOTAL'];

                $jobLocArr[] = array('state' => $negeri, 'total' => $totalJobLoc);
              }
              // sort the array by descending order by total jobs
              array_multisort(array_column($jobLocArr, "total"), SORT_DESC, $jobLocArr);

              foreach ($jobLocArr as $loc) {
                ?>
                  <li>
                    <a class="justify-content-between d-flex" href="./jobsearch.php?search=&states=<?php echo $loc['state']; ?>&tags=">
                      <p><?php echo $loc['state']; ?></p>
                      <span><?php echo $loc['total']; ?></span>
                    </a>
                  </li>
                <?php
              }
            ?>

          </ul>
        </div>

        <div class="single-slidebar tags-widget">
          <h4 class="title">Jobs by Area Tags</h4>
           <ul class="cat-list">
             <?php
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
                      <a class="justify-content-between d-flex" href="./jobsearch.php?search=&states=&tags=<?php echo $newtag['tag']; ?>">
                        <?php echo $newtag['tag']; ?> (<?php echo $newtag['total']; ?>)
                      </a>
                    </li>
                 <?php
               }
             ?>
           </ul>
        </div>

        <div class="single-slidebar">
          <h4>Top rated job posts</h4>
          <div class="active-relatedjob-carusel">
            <?php
            $stmtTop = $conn->prepare("
                                        SELECT *, COUNT(*) AS TOTAL
                                        FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P
                                        WHERE A.STATUS = 1
                                        AND J.J_ID = A.J_ID
                                        AND J.JP_ID = P.JP_ID
                                        GROUP BY A.J_ID
                                        ORDER BY TOTAL DESC
                                        LIMIT 3
                                    ");
              $stmtTop->execute();
              while($result = $stmtTop->fetch(PDO::FETCH_ASSOC)) {
                  $jid = $result['J_ID'];
                  $jtitle = $result['J_TITLE'];
                  $jdesc = $result['J_DESC'];
                  $jsalary = $result['J_SALARY'];
                  $jaddress = $result['J_ADDRESS'];
                  $jpname = $result['JP_NAME'];
                  $total = $result['TOTAL'];
                ?>
                <div class="single-rated">
                  <a href="./viewjob.php?jobid=<?php echo $jid; ?>" title="View Job Details">
                  <h4><?php echo $jtitle; ?></h4>
                  <h6><?php echo $jpname; ?></h6>
                  <p>
                    <?php echo $jdesc; ?>
                  </p>
                  <h5>Total Applications: <?php echo $total; ?></h5>
                  <p class="address"><span class="lnr lnr-map"></span> <?php echo $jaddress; ?></p>
                  <p class="address"><span class="lnr lnr-database"></span> RM <?php echo $jsalary; ?></p>
                  </a>
                </div>
                <?php
              }
              ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- End post Area -->

<?php include './template/footer.php'; ?>
