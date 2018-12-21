<?php
  $id = isset($_GET['id']) ? $_GET['id'] : 0;

  try
  {
    include './config.php';
    $stmtJs = $conn->prepare("
                              SELECT *
                              FROM JOB_SEEKER S, LOGIN L
                              WHERE S.L_ID = L.L_ID
                              AND S.JS_ID = ?
                              ");
    $stmtJs->execute(array($id));
    $seeker = $stmtJs->fetch(PDO::FETCH_ASSOC);

    $jsid = $seeker['JS_ID'];
    $jsname = $seeker['JS_NAME'];
    $jsusername = $seeker['L_USERNAME'];
    $jsaddress = $seeker['JS_ADDRESS'];
    $jsphone = $seeker['JS_PHONE'];
    $jsemail = $seeker['L_EMAIL'];
    $jsskill = $seeker['JS_SKILL'];
    $jsabout = $seeker['JS_ABOUT'];
    $jsprofilepic = ($seeker['JS_PROFILEPIC'] != "") ? "./images/profilepics/".$seeker['JS_PROFILEPIC'] : "./dashboard/template/dist/img/avatar.png";

    $stmtTotal = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM JOB_DONE WHERE JS_ID = ?");
    $stmtTotal->execute(array($id));
    $restTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $totaljob = $restTotal['TOTAL'];
  }
  catch(PDOException $e)
  {
    echo "Connection failed : " . $e->getMessage();
  }

  $pageTitle = $jsname;
  include './template/header.php';
?>

<!-- Start service Area -->
<section class="service-area section-gap" id="service">
  <div class="container">

    <div class="row">

      <h3>Job Seeker Details</h3>
      <div class="col-sm-12 purple-box">
        <div id="user-profile-2" class="user-profile">
            <div class="row">
              <div class="col-xs-12 col-sm-3 center">
                <span class="profile-picture">
                  <img class="editable img-responsive" src="<?php echo $jsprofilepic; ?>" width="200px">
                </span>

                <div class="space space-4"></div>
              </div><!-- /.col -->

              <div class="col-xs-12 col-sm-9">
                <h4 class="blue">
                  <span class="middle"><?php echo $jsname; ?></span>
                </h4> <br>

                <div class="profile-user-info">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Username </div>

                    <div class="profile-info-value">
                      <span><?php echo $jsusername; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Address </div>

                    <div class="profile-info-value">
                      <i class="fa fa-map-marker light-orange bigger-110"></i>
                      <span><?php echo $jsaddress; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Phone </div>

                    <div class="profile-info-value">
                      <span><?php echo $jsphone; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Email </div>

                    <div class="profile-info-value">
                      <a href="mailto:<?php echo $jsemail; ?>"><?php echo $jsemail; ?></a>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Skills </div>

                    <div class="profile-info-value">
                      <span><?php echo $jsskill; ?></span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Total Jobs Done </div>

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
                        <?php echo $jsabout; ?>
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
        <table id="jobs_table" class="table table-bordered">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Job</th>
                  <th>Post</th>
                  <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                try
                {
                  $stmtJ = $conn->prepare("
                                            SELECT *
                                            FROM JOB_DONE D, JOB J, JOB_SEEKER S, JOB_PROVIDER P
                                            WHERE D.JS_ID = S.JS_ID
                                            AND D.J_ID = J.J_ID
                                            AND J.JP_ID = P.JP_ID
                                            AND D.JS_ID = ?
                                            ORDER BY POST_TIME DESC
                                          ");

                  $stmtJ->execute(array($id));

                    while($result = $stmtJ->fetch(PDO::FETCH_ASSOC)) {

                      $jddesc = $result['JD_DESC'];
                      $jdpic = $result['JD_PICTURE'];
                      $jdposttime = date('F d, Y \a\t h:i A', strtotime($result['POST_TIME']));
                      $jpid = $result['JS_ID'];
                      $jpname = $result['JS_NAME'];
                      $jid = $result['J_ID'];
                      $jtitle = $result['J_TITLE'];

                      echo "
                        <tr>
                          <td>".$count."</td>
                          <td><a href='viewjob.php?jobid=".$jid."'>".$jtitle."</a></td>
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
  $('#jobs_table').DataTable();
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
