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



  }
  catch(PDOException $e)
  {
    echo "
    <script>
    alert('". $e->getMessage()."');
    </script>";
    echo "Connection failed : " . $e->getMessage();
  }
  echo "
  <script>
  alert('Job applied!');
  </script>";
  /*echo "
  <script>
  alert('Job have been applied!.');
  </script>";*/
}
?>

<!-- Start post Area -->
<section class="post-area section-gap">
  <div class="container">

    <?php
    try
    {
      if(isset($_POST['search'])) {
          $val = $_POST["search"];

          $stmt = $conn->prepare("
            SELECT *
            FROM JOB J, JOB_PROVIDER P
            WHERE J.JP_ID = P.JP_ID
            AND J.J_STATUS = 1
            LIKE '%".$val."%'
          ");

          $stmt->execute();
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

              $jid = $result['J_ID'];
              $jtitle = $result['J_TITLE'];
              $jdesc = $result['J_DESC'];
              $jarea = $result['J_AREA'];
              $jsalary = $result['J_SALARY'];
              $jstart = date('m-d-Y h:i A', strtotime($result['J_START']));
              $jend = date('m-d-Y h:i A', strtotime($result['J_END']));
              $jstatus = $result['J_STATUS'];
              $jpname = $result['JP_NAME'];
          }
        }
      }
      catch(PDOException $e)
      {
        echo "Connection failed : " . $e->getMessage();
      }
    ?>
    <form action="#" class="serach-form-area single-widget" method="post">
      <div class="row justify-content-center form-wrap">
        <div class="col-lg-4 form-cols">
          <input type="text" class="form-control" name="search" placeholder="What job are you looking for?">
        </div>
        <div class="col-lg-3 form-cols">
          <div class="default-select" id="default-selects">
            <select>
              <option value="1">Select area</option>
              <option value="2">Perak</option>
              <option value="3">Kelantan</option>
              <option value="4">Terangganu</option>
              <option value="5">Sarawak</option>
            </select>
          </div>
        </div>
        <div class="col-lg-3 form-cols">
          <div class="default-select" id="default-selects2">
            <select>
              <option value="1">All Category</option>
              <option value="5">Retail</option>
              <option value="2">Medical</option>
              <option value="3">Technology</option>
              <option value="4">Goverment</option>
              <option value="5">Development</option>
            </select>
          </div>
        </div>
        <div class="col-lg-2 form-cols">
            <button class="btn btn-info" id="search">
              <span class="lnr lnr-magnifier"></span> Search
            </button>
        </div>
      </div>
    </form>

    <br>

    <div class="row justify-content-center d-flex">

      <!--Job offers -->
      <div class="col-lg-8 post-list">

        <?php

        try
        {
            $stmt = $conn->prepare("
              SELECT *
              FROM JOB J, JOB_PROVIDER P
              WHERE J.JP_ID = P.JP_ID
              AND J.J_STATUS = 1
            ");
            $stmt->execute();

          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $jid = $result['J_ID'];
            $jtitle = $result['J_TITLE'];
            $jdesc = $result['J_DESC'];
            $jarea = $result['J_AREA'];
            $jsalary = $result['J_SALARY'];
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

          <div class="single-post d-flex flex-row">
            <div class="details">
              <div class="title d-flex flex-row justify-content-between">
                <div class="titles">
                  <a href="single.html"><h4><?php echo $jtitle; ?></h4></a>
                  <h6><?php echo $jpname; ?></h6>
                </div>
                <ul class="btns">
                  <?php
                    if($user_id != ""){
                      ?>
                      <form action="./jobsearch.php" method='post' onsubmit='return confirm("Do you want to apply this job?")'>
                        <input type='hidden' name='jobid' value='<?php echo $jid;?>'/>
                        <button type='submit' name="applyjob" class="btn btn-default <?php echo $btnstatus; ?>" title="<?php echo $btntitle; ?>" <?php echo $btnstatus; ?>>Apply</button>
                      </form>
                  <?php }?>
                </ul>
              </div>
              <p>
                ----------------------------------------------------------------------------------------------
              </p>
              <p><?php echo $jdesc; ?></p>
              <p class="address"><span class="lnr lnr-map"></span> Wallagonia, Tapah Road, Perak</p>
              <p class="address"><span class="fa fa-hourglass-start"></span> <?php echo "Start Date: ".$jstart; ?></p>
              <p class="address"><span class="fa fa-hourglass-end"></span> <?php echo "End Date: ".$jend; ?></p>
              <p class="address"><span class="lnr lnr-database"></span> <?php echo "RM ".$jsalary; ?></p>

              <div class="thumb">
                <ul class="tags">
                  <li>
                    <a href="#"><?php echo $jarea; ?></a>
                  </li>
                </ul>
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
            <li><a class="justify-content-between d-flex" href="#"><p>Perak</p><span>37</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Kelantan</p><span>57</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Negeri Sembilan</p><span>33</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Sarawak</p><span>36</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Sabah</p><span>27</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Terengganu</p><span>17</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Perlis</p><span>2</span></a></li>
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

        <div class="single-slidebar">
          <h4>Jobs by Category</h4>
          <ul class="cat-list">
            <li><a class="justify-content-between d-flex" href="#"><p>Technology</p><span>37</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Media & News</p><span>57</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Goverment</p><span>33</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Medical</p><span>36</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Restaurants</p><span>47</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Developer</p><span>27</span></a></li>
            <li><a class="justify-content-between d-flex" href="#"><p>Accounting</p><span>17</span></a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- End post Area -->

<?php include './template/footer.php'; ?>

<script type="text/javascript">
  /*$(document).on("click", "#search", function() {
    event.preventDefault();
    $("#kerja").fadeIn();
  });
*/
  /*$(document).on("click", "#apply", function() {
    event.preventDefault();
    $(this).html('<i class="fa fa-check-square" aria-hidden="true"></i> Job Applied');
    $(this).css({ color: "blue" });

  });*/


  $(document).on("click", "#like", function() {
    var liked = $(this).attr("val");
    if(liked == "false") {
      $(this).css({ color: "red" });
      $(this).attr("val", "true");
    } else {
      $(this).css({ color: "black" });
      $(this).attr("val", "false");
    }

  })
</script>
