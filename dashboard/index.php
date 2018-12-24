 <?php
  $pageTitle = "Home";
  include './template/header.php';

  // Statistics Page
  include './statistics.php';

  if(isset($_POST['insertJob'])) {

    $jtitle = $_POST['jtitle'];
    $jdesc = $_POST['jdesc'];
    $jarea = $_POST['jarea'];
    $jaddress = $_POST['jaddress'];
    $jsalary = $_POST['jsalary'];
    $jstart = $_POST['jstart'];
    $jend = $_POST['jend'];

    $dateStart = date("Y-m-d H:i:s",strtotime($jstart));
    $dateEnd = date("Y-m-d H:i:s",strtotime($jend));

    try
    {
      $stmt = $conn->prepare("INSERT INTO
                              JOB (J_TITLE, J_DESC, J_AREA, J_ADDRESS, J_SALARY, J_START, J_END, JP_ID, J_STATUS)
                              VALUES (?, ?, REPLACE(?,' ',''), ?, ?, ?, ?, ?, ?) ");

      $stmt->execute(array($jtitle, $jdesc, $jarea, $jaddress, $jsalary, $dateStart, $dateEnd, $user_ids, 1)); // 0 job close, 1 job open

      echo "
      <script>
      alert('New job posted.');
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

  if(isset($_POST['closeJob'])) {

    $jid = $_POST['jobid'];
    $jstatus = ($_POST['jobstatus'] == 1) ? 0 : 1;
    try
    {
      $stmt = $conn->prepare("UPDATE JOB SET J_STATUS = ? WHERE J_ID = ?");

      $stmt->execute(array($jstatus,$jid));

      if($jstatus == 1) {
        echo "
        <script>
        alert('Job offer opened.');
        </script>";
      } else {
        echo "
        <script>
        alert('Job offer closed.');
        </script>";
      }


    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

  if(isset($_POST['deleteJob'])) {

    $jid = $_POST['jobid'];
    try
    {
      $stmt = $conn->prepare("DELETE FROM JOB WHERE J_ID = ?");

      $stmt->execute(array($jid));

      echo "
      <script>
      alert('Job deleted.');
      </script>";

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

  if(isset($_POST['cancelApp'])) {

    $jid = $_POST['jobid'];
    $jsid = $_POST['seekerid'];
    try
    {
      $stmt = $conn->prepare("DELETE FROM JOB_APPLICATION WHERE J_ID = ? AND JS_ID = ?");

      $stmt->execute(array($jid, $jsid));

      echo "
      <script>
      alert('Application has been canceled.');
      </script>";

    }
    catch(PDOException $e)
    {
      echo "Connection failed : " . $e->getMessage();
    }

  }

?>

<!-- modal alert if no profile data -->
<div class="modal fade" id="modal-updateprofile" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Hi, Welcome to JFP!</h4>
      </div>
      <div class="modal-body">
        <p>Hi! Welcome to JFP! You profile data still incomplete.</p>
        <p>Please update your profile information by heading to your profile page setting.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <a href="./profile.php" type="button" class="btn btn-primary">Go to Profile Page</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
  if($level == 1) {
    ?>

    <a href="./report.php" target="_blank" class="btn btn-success btn-lg pull-right"><i class="fa fa-fw fa-print"></i> Generate &amp; Print Report</a>
    <br>

    <h4>Portal Statistics</h4>
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs ">
        <li class="active"><a href="#tab_1" data-toggle="tab">Daily</a></li>
        <li><a href="#tab_2" data-toggle="tab">Monthly</a></li>
        <li><a href="#tab_3" data-toggle="tab">Yearly</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <h4><b class="label bg-red"><?php echo $offersDaily;?></b> total new jobs offers</h4>
          <h4><b class="label bg-blue"><?php echo $applyDaily;?></b> total new jobs applications</h4>
          <h4><b class="label bg-yellow"><?php echo $postsDaily;?></b> total new posts</h4>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <h4><b class="label bg-red"><?php echo $offersMonthly;?></b> total new jobs offers</h4>
          <h4><b class="label bg-blue"><?php echo $applyMonthly;?></b> total new jobs applications</h4>
          <h4><b class="label bg-yellow"><?php echo $postsMonthly;?></b> total new posts</h4>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
          <h4><b class="label bg-red"><?php echo $offersYearly;?></b> total new jobs offers</h4>
          <h4><b class="label bg-blue"><?php echo $applyYearly;?></b> total new jobs applications</h4>
          <h4><b class="label bg-yellow"><?php echo $postsYearly;?></b> total new posts</h4>
        </div><!-- /.tab-pane -->
      </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->

    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Top 10 Job Providers with Most Jobs</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="40">#</th>
                  <th>Job Provider</th>
                  <th width="150">Total Jobs</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $count = 1;
                  while($result = $topjp->fetch(PDO::FETCH_ASSOC)) {
                    $jpid = $result['JP_ID'];
                    $jpname = $result['JP_NAME'];
                    $totaljobs = $result['TOTAL'];

                    ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><a href="../viewprovider.php?id=<?php echo $jpid; ?>"><?php echo $jpname; ?></a></td>
                        <td><?php echo $totaljobs; ?></td>
                      </tr>
                    <?php
                    $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Top 10 Job Seekers with Most Jobs Accepted</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="40">#</th>
                  <th>Job Seeker</th>
                  <th width="100">Total Jobs</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $count = 1;
                  while($result = $topjs->fetch(PDO::FETCH_ASSOC)) {
                    $jsid = $result['JS_ID'];
                    $jsname = $result['JS_NAME'];
                    $totaljobs = $result['TOTAL'];

                    ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><a href="../viewseeker.php?id=<?php echo $jsid; ?>"><?php echo $jsname; ?></a></td>
                        <td><?php echo $totaljobs; ?></td>
                      </tr>
                    <?php
                    $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Top 10 Jobs With Most Applications</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="40">#</th>
              <th>Job Title</th>
              <th>Job Description</th>
              <th width="100">Total Applications</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $count = 1;
              while($result = $topjob->fetch(PDO::FETCH_ASSOC)) {
                $jid = $result['J_ID'];
                $jtitle = $result['J_TITLE'];
                $jdesc = $result['J_DESC'];
                $jpname = $result['JP_NAME'];
                $totalapps = $result['TOTAL'];

                ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><a href="../viewjob.php?jobid=<?php echo $jid; ?>"><?php echo $jtitle.' by '.$jpname; ?></a></td>
                    <td><?php echo $jdesc; ?></td>
                    <td><?php echo $totalapps; ?></td>
                  </tr>
                <?php
                $count++;
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Total Jobs by States</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <canvas id="jobsCountriesChart" width="400" height="150"></canvas>
      </div>
    </div>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Total Jobs by Categories Tags</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div id="wordTags"></div>
      </div>
    </div>


    <?php
  } else if($level == 2) {
    ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Jobs List</h3>
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-add-job"><i class="fa fa-fw fa-plus"></i> Add Job</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="jobTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Area</th>
            <th>Salary</th>
            <th>Job Location</th>
            <th>Job Duration</th>
            <th>No. Applications</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            try
            {
              // list all job for current logged in job provider
              $stmt = $conn->prepare("SELECT * FROM JOB WHERE JP_ID = ?");
              $stmt->execute(array($user_ids));

              //fetch
              while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $jid = $result['J_ID'];
                $jtitle = $result['J_TITLE'];
                $jdesc = $result['J_DESC'];
                $jarea = $result['J_AREA'];
                $jsalary = $result['J_SALARY'];
                $jaddress = $result['J_ADDRESS'];
                $jstart = date('d/m/Y h:i A', strtotime($result['J_START']));
                $jend = date('d/m/Y h:i A', strtotime($result['J_END']));
                $jstatus = $result['J_STATUS'];

                // count and get number of applications for each job
                $stmtApp = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM JOB_APPLICATION WHERE J_ID = ?");
                $stmtApp->execute(array($jid));
                $resApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
                $totalApp = $resApp['TOTAL'];

                echo "
                  <tr>
                    <td>".$count."</td>
                    <td><a href='../viewjob.php?jobid=$jid'>$jtitle</a></td>
                    <td>".$jdesc."</td>
                    <td>".$jarea."</td>
                    <td>".$jsalary."</td>
                    <td>".$jaddress."</td>
                    <td>".$jstart." to ".$jend."</td>
                    <td>".$totalApp."</td>
                    <td>";
                      echo ($jstatus == 0) ? "<h4><span class='label label-danger'>Closed</span></h4>" : "<h4><span class='label label-success'>Open</span></h4>";
                    echo "</td>
                    <td>
                      ";
                      ?>
                      <a href="./editjob.php?id=<?php echo $jid; ?>" class="btn btn-warning" title='Edit job'><i class="fa fa-fw fa-edit"></i></a>
                      <?php
                        $statusmsg = "Open";
                        $btncolor = 'btn btn-success';
                        $btnicon = 'fa-lock';
                        if($jstatus == 1) {
                          $statusmsg = "Close";
                          $btncolor = 'btn btn-primary';
                          $btnicon = 'fa-unlock';
                        }
                      ?>
                      <form action='./index.php' method='post' onsubmit='return confirm("<?php echo $statusmsg; ?> this job offer?");'>
                        <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                        <input type='hidden' name='jobstatus' value='<?php echo $jstatus; ?>'>
                        <button type='submit' name='closeJob' class='<?php echo $btncolor; ?>' title='<?php echo $statusmsg." job offer."; ?>'><i class="fa fa-fw <?php echo $btnicon; ?>"></i></button>
                      </form>
                      <form action='./index.php' method='post' onsubmit='return confirm("Delete this job?");'>
                        <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                        <button type='submit' name='deleteJob' class='btn btn-danger' title='Delete job'><i class="fa fa-fw fa-trash"></i></button>
                      </form>
                      <?php
                      echo"
                    </td>
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
    <!--modal dialog -->
    <div class="modal fade" id="modal-add-job" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Job</h4>
                  </div>
                  <form action="./index.php" method="post">
                    <div class="modal-body">
                    <!--modal body-->
                    <div class="box-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Job Title</label>
                        <input type="text" class="form-control" placeholder="Enter Job Title" name="jtitle" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Description</label>
                        <input type="text" class="form-control" placeholder="Enter Job Description" name="jdesc" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Area Tag (no space)</label>
                        <input type="text" class="form-control" placeholder="Enter Job Area. Separated by coma for multiple areas. Ex: 'programming,kitchen,office'" name="jarea" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Address</label>
                        <textarea class="form-control" placeholder="Enter Address for the job" name="jaddress" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Salary</label>
                        <input type="text" class="form-control" placeholder="Enter Job Salary" name="jsalary" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job Start</label>
                        <input type="text" id="startDateTime" class="form-control" placeholder="Enter Job Start Date and Time" name="jstart" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Job End</label>
                        <input type="text" id="endDateTime" class="form-control" placeholder="Enter Job End Date and Time" name="jend" required>
                      </div>


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="insertJob">Save changes</button>
                    </div>
                  </div>
                  </form>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
    <?php
  } else if($level == 3) {
    ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Applications List</h3>
        <a href="../jobsearch.php" class="btn btn-success pull-right"><i class="fa fa-fw fa-search"></i> Find Job Offers</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="applicationsTable" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Job Provider</th>
            <th>Job Title</th>
            <th>Job Salary</th>
            <th>Job Location</th>
            <th>Job Duration</th>
            <th>Apply Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            try
            {
              // list all job application for current logged in job seeker
              $stmt = $conn->prepare("

                SELECT *
                FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P, JOB_SEEKER S
                WHERE A.J_ID = J.J_ID
                AND A.JS_ID = S.JS_ID
                AND J.JP_ID = P.JP_ID
                AND S.JS_ID = ?

              ");
              $stmt->execute(array($user_ids));

              //fetch
              while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $jid = $result['J_ID'];
                $jpid = $result['JP_ID'];
                $jsid = $result['JS_ID'];
                $applydate = date('d/m/Y h:i A', strtotime($result['APPLY_DATE']));
                $astatus = $result['STATUS'];
                $jobtitle = $result['J_TITLE'];
                $jobsalary = $result['J_SALARY'];
                $jobaddress = $result['J_ADDRESS'];
                $startdate = date('d/m/Y', strtotime($result['J_START']));
                $enddate = date('d/m/Y', strtotime($result['J_END']));
                $jobprovider = $result['JP_NAME'];

                echo "
                  <tr>
                    <td>".$count."</td>
                    <td><a href='../viewprovider.php?id=$jpid'>".$jobprovider."</a></td>
                    <td><a href='../viewjob.php?jobid=$jid'>".$jobtitle."</a></td>
                    <td>".$jobsalary."</td>
                    <td>".$jobaddress."</td>
                    <td>".$startdate." - ".$enddate."</td>
                    <td>".$applydate."</td>
                    <td>";
                      if($astatus == 2) {
                        echo "<h4><span class='label label-warning'>Pending</span></h4>";
                      } else if($astatus == 1) {
                        echo "<h4><span class='label label-success'>Approved</span></h4>";
                      } else {
                        echo "<h4><span class='label label-danger'>Declined</span></h4>";
                      }
                    echo "</td>
                    <td>
                      ";
                      if($astatus == 2) {
                        ?>
                        <form action='./index.php' method='post' onsubmit='return confirm("Cancel Application?");'>
                          <input type='hidden' name='jobid' value='<?php echo $jid; ?>'>
                          <input type='hidden' name='seekerid' value='<?php echo $jsid; ?>'>
                          <button type='submit' name='cancelApp' class='btn btn-danger' title='Cancel Application'><i class="fa fa-fw fa-ban"></i></button>
                        </form>
                        <?php
                      } else {
                        echo "<i>No actions</i>";
                      }
                      echo "
                    </td>
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
    <?php
  }
?>

<?php include './template/footer.php'; ?>

<script>
  $(function () {

    $('#startDateTime, #endDateTime').datetimepicker();

  })
</script>

<?php
if($user_name == "") {
  ?>
  <script>
    $(function() {
      $('#modal-updateprofile').modal('toggle');
    })
  </script>
  <?php
}
?>

<script>
  function random_rgba() {
      var o = Math.round, r = Math.random, s = 255;
      return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 1 + ')';
  }

  var bgcolors = Array();
  var nocountries = <?php echo sizeof($listnegeri); ?>;
  for(var i=0;i<nocountries;i++) {
    bgcolors.push(random_rgba());
  }

  var ctx = document.getElementById("jobsCountriesChart");
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: <?php echo json_encode($listnegeri); ?>,
          datasets: [{
              label: '# jobs',
              data: <?php echo json_encode($totalEachCountry); ?>,
              backgroundColor: bgcolors,
          }]
      },
      options: {
          legend: {
             display: false,
         },
          scaleShowValues: true,
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }],
              xAxes: [{
                  ticks: {
                      autoSkip: false
                  }
              }]
          }
      }
  });
</script>

<!-- Generate Word Tags Clouds
     Codes from: http://labs.polsys.net/tools/tagcloud/
   -->
<style media="screen">
 #wordTags {
  margin:10px;
  text-align:center;
  line-height: 30px;
}
</style>
<script type="text/javascript" language="javascript">

	var _styles = ["font-size:16px;color:#777777;",
			       "font-size:18px;color:#777777;",
				   "font-size:20px;color:#666666;",
				   "font-size:22px;color:#666666;",
				   "font-size:24px;color:#555555;",
				   "font-size:26px;color:#555555;",
				   "font-size:28px;color:#444444;",
				   "font-size:30px;color:#444444;",
				   "font-size:32px;color:#333333;",
				   "font-size:34px;color:#333333;",
				   "font-size:36px;color:#222222;",
				   "font-size:38px;color:#222222;",
				   "font-size:40px;color:#000000;",
				   "font-size:42px;color:#000000;"]

	var _biggest = 0;
	var _smallest = 100000000000000;

  createCloud("alpha","inline","950","asis");

	function createCloud(_order,_layout,_width,_case) {

		//var _textinput = $("#textinput").val();

		var _taglist = {};
		var _textlines = <?php echo json_encode($listTagsnCount); ?>;


		if(_textlines[0].match(/:\d/)) {
			for(var i = 0; i < _textlines.length; i++) {
				_textlines[i] = $.trim(_textlines[i]);
				var _tmp = _textlines[i].split(/[,\t:]/);
				_taglist[_tmp[0]] = parseInt(_tmp[1]);
			}
		} else if(_textlines[0].match(/\t\d/)) {
			for(var i = 0; i < _textlines.length; i++) {
				_textlines[i] = $.trim(_textlines[i]);
				var _tmp = _textlines[i].split(/[,\t:]/);
				_taglist[_tmp[0]] = parseInt(_tmp[1]);
			}
		} else {
			for(var i = 0; i < _textlines.length; i++) {
				_textlines[i] = $.trim(_textlines[i]);
				if(typeof(_taglist[_textlines[i]]) == "undefined") {
					_taglist[_textlines[i]] = 1;
				} else {
					_taglist[_textlines[i]]++;
				}
			}
		}

		for(var _key in _taglist) {

			if(_taglist[_key] < _smallest) {
				_smallest = _taglist[_key];
			}

			if(_taglist[_key] > _biggest) {
				_biggest = _taglist[_key];
			}
		}


		var _sorted = [];
		for(var _key in _taglist) {
			var _tag = _key;
			if(_case == "upper") { var _tag = _key.toUpperCase(); }
			if(_case == "lower") { var _tag = _key.toLowerCase(); }
			_sorted.push([_tag, _taglist[_key]])
		}

		if(_order == 'alpha') {
			_sorted.sort(function(a, b) {
				if(a[0][0] < b[0][0]) return -1;
				if(a[0][0] > b[0][0]) return 1;
				return 0;
			});
		}

		if(_order == 'rank') {
			_sorted.sort(function(a, b) {return parseInt(a[1]) - parseInt(b[1])})
			_sorted.reverse();
		}

		var _html = "";

		for(var i = 0; i < _sorted.length; i++) {

			if (_sorted[i][1] >= _smallest) {

				var _tmpsize = _sorted[i][1] - _smallest;

				if(_tmpsize != 0) {
					_tmpsize = Math.round(_tmpsize / (_biggest - _smallest) * (_styles.length - 1));
				}

				//console.log(_tmpsize);

				_sorted[i][0] = _sorted[i][0].replace(/\s/,"&nbsp;");

				_html += '<span class="tag" style="'+ _styles[_tmpsize] +'color:'+random_rgba()+';">' + _sorted[i][0] + '&nbsp;(' + _sorted[i][1] + ') </span>';
			}
		}


		$("#wordTags").css("width",_width  + "px");
		$("#wordTags").html(_html);


		if(_layout == "inline") {
			$(".tag").css("display",_layout);
			$(".tag").css("line-height","normal");
			if(_order == 'alpha') {
				$(".tag").css("line-height","35px");
			} else {
				$(".tag").css("line-height","150%");
			}

		} else {
			$(".tag").css("display",_layout);
			$(".tag").css("line-height","normal");
			$(".tag").css("line-height","130%");
			$(".tag").css("padding-top","8px");
		}
	}

	</script>
