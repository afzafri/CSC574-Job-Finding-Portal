<?php
  $jobid = isset($_GET['jobid']) ? $_GET['jobid'] : 0;

  try
  {
    include './config.php';
    $stmtJob = $conn->prepare("
                            SELECT *
                            FROM JOB J, JOB_PROVIDER P
                            WHERE J.JP_ID = P.JP_ID
                            AND J.J_ID = ?
                              ");
    $stmtJob->execute(array($jobid));
    $job = $stmtJob->fetch(PDO::FETCH_ASSOC);

    $jid = $job['J_ID'];
    $jtitle = $job['J_TITLE'];
    $jdesc = $job['J_DESC'];
    $areaTags = explode(",", $job['J_AREA']);
    $jsalary = $job['J_SALARY'];
    $jaddress = $job['J_ADDRESS'];
    $jstart = date('d/m/Y h:i A', strtotime($job['J_START']));
    $jend = date('d/m/Y h:i A', strtotime($job['J_END']));
    $jstatus = $job['J_STATUS'];
    $jpname = $job['JP_NAME'];
    $jpprofilepic = ($job['JP_PROFILEPIC'] != "") ? "./images/profilepics/".$job['JP_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";


    $stmtTotal = $conn->prepare("
                                SELECT COUNT(*) AS TOTAL
                                FROM JOB_APPLICATION
                                WHERE STATUS = 1
                                AND J_ID = ?
                                ");
    $stmtTotal->execute(array($jobid));
    $resTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $totalApplied = $resTotal['TOTAL'];
  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }

  $pageTitle = "$jtitle";
  include './template/header.php';
?>

<!-- Start service Area -->
<section class="service-area section-gap" id="service">
  <div class="container">
    <div class="row">


      <div class="col-sm-12 purple-box">
          <h4>
            <img src='<?php echo $jpprofilepic; ?>' width="50px"> <br>
            <?php echo $jpname; ?> <br><br>
            Total Job Applications: <?php echo $totalApplied; ?>
          </h4>
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
</section>
<!-- End service Area -->

  </div>
</section>
<!-- End testimonial Area -->

<?php include './template/footer.php'; ?>
