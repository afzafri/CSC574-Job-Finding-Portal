<?php
  $pageTitle = "Job Search";
  include './template/header.php';
?>

<?php
if(isset($_POST['applyjob'])) {

  $jid = $_POST["jobid"];
  $jsid = $user_ids;
  $applydate = "2018-11-21 13:48:00";

  try
  {
    $stmt = $conn->prepare("INSERT INTO
                            JOB_APPLICATION (J_ID, JS_ID, APPLY_DATE, STATUS)
                            VALUES (?, ?, ?, ?) ");

    $stmt->execute(array($jid, $jsid, $applydate, 2));

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
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $states = (isset($_GET['states'])) ? $_GET['states'] : "";
    $tags = (isset($_GET['tags'])) ? $_GET['tags'] : "";
    try
    {
      // --- SEARCH TITLE ---
        // --- SEARCH
        if($search != "" && $states == "" && $tags == "") {
            $stmt = $conn->prepare("
              SELECT *
              FROM JOB J, JOB_PROVIDER P
              WHERE J.JP_ID = P.JP_ID
              AND J.J_STATUS = 1
              AND J.J_TITLE LIKE ?
            ");
              $stmt->execute(array("%$search%"));
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
              ");
                $stmt->execute(array("%$search%","%$states%"));
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
              ");
                $stmt->execute(array("%$search%","%$states%","%$tags%"));
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
              ");
                $stmt->execute(array("%$states%"));
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
                ");
                  $stmt->execute(array("%$states%","%$tags%"));
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
              ");
                $stmt->execute(array("%$tags%"));
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
                ");
                  $stmt->execute(array("%$search%", "%$tags%"));
              }

        // --- NO SEARCH ---
        if($search == "" && $states == "" && $tags == "") {
          $stmt = $conn->prepare("
            SELECT *
            FROM JOB J, JOB_PROVIDER P
            WHERE J.JP_ID = P.JP_ID
            AND J.J_STATUS = 1
          ");
          $stmt->execute();
        }
      }
      catch(PDOException $e)
      {
        echo "Connection failed : " . $e->getMessage();
      }
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
            $jstart = date('m-d-Y h:i A', strtotime($result['J_START']));
            $jend = date('m-d-Y h:i A', strtotime($result['J_END']));
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
                <a href="single.html"><h4><?php echo $jtitle; ?></h4></a>
                <h6>by <?php echo $jpname; ?></h6>
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
          </div>

            <?php

          }

        }
        catch(PDOException $e)
        {
          echo "Connection failed : " . $e->getMessage();
        }
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
           <ul>
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
                      <a href="./jobsearch.php?search=&states=&tags=<?php echo $newtag['tag']; ?>">
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
            <div class="single-rated">
              <img class="img-fluid" src="./template/img/r1.jpg" alt="">
              <h4>Creative Art Designer</h4>
              <h6>Premium Labels Limited</h6>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
              </p>
              <h5>Job Nature: Full time</h5>
              <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
              <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
              <a href="#" class="btns text-uppercase">Apply job</a>
            </div>
            <div class="single-rated">
              <img class="img-fluid" src="./template/img/r1.jpg" alt="">
              <h4>Creative Art Designer</h4>
              <h6>Premium Labels Limited</h6>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
              </p>
              <h5>Job Nature: Full time</h5>
              <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
              <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
              <a href="#" class="btns text-uppercase">Apply job</a>
            </div>
            <div class="single-rated">
              <img class="img-fluid" src="./template/img/r1.jpg" alt="">
              <h4>Creative Art Designer</h4>
              <h6>Premium Labels Limited</h6>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
              </p>
              <h5>Job Nature: Full time</h5>
              <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
              <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
              <a href="#" class="btns text-uppercase">Apply job</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- End post Area -->

<?php include './template/footer.php'; ?>
