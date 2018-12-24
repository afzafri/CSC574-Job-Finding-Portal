<?php
  include '../auth.php';
  include '../config.php';
  include './statistics.php';
  date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Generate and Print Report</title>
    <style>
    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    page[size="A4"] {
      width: 21cm;
      height: 29.7cm;
    }
    page[size="A4"][layout="portrait"] {
      width: 29.7cm;
      height: 21cm;
    }
    table {
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
      padding: 5px;
    }

    b {
      font-size: 14px;
    }

    body {
      font-size: 12px;
      font-family: "Times New Roman", Times, serif;
    }

    .generateon {
      text-align: right;
      color: grey;
      font-style: italic;
    }
    </style>
  </head>
  <body onload="window.print(); window.close();">

    <center>
      <h1>Portal Statistics Report</h1>
    </center>

    <p class="generateon">Report generated on <?php echo date("M d Y, h:i:sa"); ?></p>
    <br>

    <b>1.0 DATA COUNTS</b><br><br>
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Daily</th>
          <th>Monthly</th>
          <th>Yearly</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th align="left">Total New Jobs Offers</th>
          <td><?php echo $offersDaily;?></td>
          <td><?php echo $offersMonthly;?></td>
          <td><?php echo $offersYearly;?></td>
        </tr>
        <tr>
          <th align="left">Total New Jobs Applications</th>
          <td><?php echo $applyDaily;?></td>
          <td><?php echo $applyMonthly;?></td>
          <td><?php echo $applyYearly;?></td>
        </tr>
        <tr>
          <th align="left">Total New Posts</th>
          <td><?php echo $postsDaily;?></td>
          <td><?php echo $postsMonthly;?></td>
          <td><?php echo $postsYearly;?></td>
        </tr>
      </tbody>
    </table>
    <br><br>

    <b>2.0 TOP 10 JOB PROVIDERS WITH MOST JOBS</b><br><br>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Job Provider</th>
          <th>Total Jobs</th>
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
                <td><?php echo $jpname; ?></td>
                <td><?php echo $totaljobs; ?></td>
              </tr>
            <?php
            $count++;
          }
        ?>
      </tbody>
    </table>
    <br><br>

    <b>3.0 TOP 10 JOB SEEKERS WITH MOST JOBS ACCEPTED</b><br><br>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Job Seeker</th>
          <th>Total Jobs</th>
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
                <td><?php echo $jsname; ?></td>
                <td><?php echo $totaljobs; ?></td>
              </tr>
            <?php
            $count++;
          }
        ?>
      </tbody>
    </table>
    <br><br>

    <b>4.0 TOP 10 JOBS WITH MOST APPLICATIONS</b><br><br>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Job Title</th>
          <th>Job Description</th>
          <th>Total Applications</th>
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
                <td><?php echo $jtitle.' by '.$jpname; ?></td>
                <td><?php echo $jdesc; ?></td>
                <td><?php echo $totalapps; ?></td>
              </tr>
            <?php
            $count++;
          }
        ?>
      </tbody>
    </table><br><br>

    <b>5.0 TOTAL JOBS BY STATES</b><br><br>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>States</th>
          <th>Total Jobs</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $count = 1;
          foreach ($jobLocArr as $loc) {
            ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $loc['state']; ?></td>
                <td><?php echo $loc['total']; ?></td>
              </tr>
            <?php
            $count++;
          }
        ?>
      </tbody>
    </table><br><br>

    <b>6.0 TOTAL JOBS BY CATEGORIES TAGS</b><br><br>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Categories Tags</th>
          <th>Total Jobs</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $count = 1;
          foreach ($tagsArr as $tags) {
            ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $tags['tag']; ?></td>
                <td><?php echo $tags['total']; ?></td>
              </tr>
            <?php
            $count++;
          }
        ?>
      </tbody>
    </table><br><br>

  </body>
</html>
