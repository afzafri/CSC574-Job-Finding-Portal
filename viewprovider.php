<?php
  $id = isset($_GET['id']) ? $_GET['id'] : 0;

  try
  {
    include './config.php';
    $stmtPd = $conn->prepare("
                              SELECT *
                              FROM JOB_PROVIDER P, LOGIN L
                              WHERE P.L_ID = L.L_ID
                              AND P.JP_ID = ?
                              ");
    $stmtPd->execute(array($id));
    $provider = $stmtPd->fetch(PDO::FETCH_ASSOC);

    $jpid = $provider['JP_ID'];
    $jpname = $provider['JP_NAME'];
    $jpusername = $provider['L_USERNAME'];
    $jpaddress = $provider['JP_ADDRESS'];
    $jpphone = $provider['JP_PHONE'];
    $jpemail = $provider['L_EMAIL'];
    $jpwebsite = $provider['JP_WEBSITE'];
    $jparea = $provider['JP_AREA'];
    $jpdesc = $provider['JP_DESCRIPTION'];
    $jpprofilepic = ($provider['JP_PROFILEPIC'] != "") ? "./images/profilepics/".$provider['JP_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";

    $stmtTotal = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM JOB WHERE JP_ID = ?");
    $stmtTotal->execute(array($id));
    $restTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $totaljob = $restTotal['TOTAL'];
  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }

  $pageTitle = "$jpname";
  include './template/header.php';
?>

<!-- Start service Area -->
<section class="service-area section-gap" id="service">
  <div class="container">

    <div class="row">

      <h3>Job Provider Details</h3>
      <div class="col-sm-12 purple-box">
        <div id="user-profile-2" class="user-profile">
            <div class="row">
              <div class="col-xs-12 col-sm-3 center">
                <span class="profile-picture">
                  <img class="editable img-responsive" src="<?php echo $jpprofilepic; ?>">
                </span>

                <div class="space space-4"></div>
              </div><!-- /.col -->

              <div class="col-xs-12 col-sm-9">
                <h4 class="blue">
                  <span class="middle"><?php echo $jpname; ?></span>
                </h4> <br>

                <div class="profile-user-info">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Username </div>

                    <div class="profile-info-value">
                      <span><?php echo $jpusername; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Address </div>

                    <div class="profile-info-value">
                      <i class="fa fa-map-marker light-orange bigger-110"></i>
                      <span><?php echo $jpaddress; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Phone </div>

                    <div class="profile-info-value">
                      <span><?php echo $jpphone; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Email </div>

                    <div class="profile-info-value">
                      <a href="mailto:<?php echo $jpemail; ?>"><?php echo $jpemail; ?></a>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Website </div>

                    <div class="profile-info-value">
                      <a href="<?php echo $jpwebsite; ?>" target="_blank"><?php echo $jpwebsite; ?></a>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Job Scope </div>

                    <div class="profile-info-value">
                      <span><?php echo $jparea; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Total Jobs Posted </div>

                    <div class="profile-info-value">
                      <span><?php echo $totaljob; ?></span>
                    </div>
                  </div>
                </div>

              </div><!-- /.col -->
            </div><!-- /.row -->

            <br>

            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="widget-box transparent">
                  <div class="widget-header widget-header-small">
                    <h4 class="widget-title smaller">
                      <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                      About Me
                    </h4>
                  </div>

                  <div class="widget-body">
                    <div class="widget-main">
                      <p>
                        <?php echo $jpdesc; ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>

    </div>

    <br><br>
    <div class="row">

      <h3>Job List</h3>
      <div class="col-sm-12 purple-box">
        <table id="posts_table" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Seeker</th>
                    <th>Post</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                try
                {
                  $stmtJD = $conn->prepare("
                                          SELECT *
                                          FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                          WHERE D.JS_ID = S.JS_ID
                                          AND D.J_ID = J.J_ID
                                          AND J.JP_ID = P.JP_ID
                                          AND D.J_ID = ?
                                          ORDER BY POST_TIME DESC
                                          ");

                  $stmtJD->execute(array($jobid));

                    while($resultJD = $stmtJD->fetch(PDO::FETCH_ASSOC)) {

                      $jddesc = $resultJD['JD_DESC'];
                      $jdpic = $resultJD['JD_PICTURE'];
                      $jdposttime = date('F d, Y \a\t h:i A', strtotime($resultJD['POST_TIME']));
                      $jsid = $resultJD['JS_ID'];
                      $jsname = $resultJD['JS_NAME'];
                      $jsprofilepic = ($resultJD['JS_PROFILEPIC'] != "") ? "./images/profilepics/".$resultJD['JS_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";


                      echo "
                        <tr>
                          <td>$count</td>
                          <td>
                            <img src='$jsprofilepic' width='50px'> &nbsp;
                            $jsname
                          </td>
                          <td>
                          $jddesc <br>
                          ";
                          if($jdpic !== "") {
                            echo "<img src='./images/postspics/$jdpic' height='400px'> <br><br>";
                          }
                          echo"
                          </td>
                          <td>$jdposttime</td>
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
            </tbody>
        </table>

      </div>

    </div>
  </div>
</section>
<!-- End service Area -->

  </div>
</section>
<!-- End testimonial Area -->

<?php include './template/footer.php'; ?>

<script type="text/javascript">
$(document).ready( function () {
  $('#posts_table').DataTable();
} );
</script>

<style media="screen">

.align-center, .center {
  text-align: center!important;
}

.profile-user-info {
  display: table;
  width: 98%;
  width: calc(100% - 24px);
  margin: 0 auto
}

.profile-info-row {
  display: table-row
}

.profile-info-name,
.profile-info-value {
  display: table-cell;
  border-top: 1px dotted #D5E4F1
}

.profile-info-name {
  text-align: right;
  padding: 6px 10px 6px 4px;
  font-weight: 400;
  color: black;
  background-color: transparent;
  width: 110px;
  vertical-align: middle
}

.profile-info-value {
  padding: 6px 4px 6px 6px
}

.profile-info-value>span+span:before {
  display: inline;
  content: ",";
  margin-left: 1px;
  margin-right: 3px;
  color: #666;
  border-bottom: 1px solid #FFF
}

.profile-info-value>span+span.editable-container:before {
  display: none
}

.profile-info-row:first-child .profile-info-name,
.profile-info-row:first-child .profile-info-value {
  border-top: none
}

.profile-picture {
  border: 1px solid #CCC;
  background-color: #FFF;
  padding: 4px;
  display: inline-block;
  max-width: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  box-shadow: 1px 1px 1px rgba(0, 0, 0, .15)
}

</style>
