<?php
  $pageTitle = "Providers List";
  include './template/header.php';
?>

<!-- Start post Area -->
<section class="post-area section-gap">
  <div class="container">

<table id="companies_table" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Provider Name</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Description</th>
            <th>Area Scope</th>
            <th>Total Jobs</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        try
        {
          // list all job providers
          $stmt = $conn->prepare("
            SELECT *
            FROM JOB_PROVIDER P, LOGIN L
            WHERE P.L_ID = L.L_ID
          ");
            $stmt->execute();

            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

              $jpid = $result['JP_ID'];
              $jpname = $result['JP_NAME'];
              $jpaddress = $result['JP_ADDRESS'];
              $jpphone = $result['JP_PHONE'];
              $jpemail = $result['L_EMAIL'];
              $jpwebsite = $result['JP_WEBSITE'];
              $jparea = $result['JP_AREA'];
              $jpdesc = $result['JP_DESCRIPTION'];

              $stmtCount = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM JOB WHERE JP_ID = ?");
              $stmtCount->execute(array($jpid));
              $countRes = $stmtCount->fetch(PDO::FETCH_ASSOC);
              $totalJob = $countRes['TOTAL'];

              echo "
                <tr>
                  <td>$count</td>
                  <td>$jpname</td>
                  <td>$jpaddress</td>
                  <td>
                    Phone: $jpphone <br>
                    Email: <a href='mailto:$jpemail' target='_blank'>$jpemail</a> <br>
                    Website: <a href='$jpwebsite' target='_blank'>$jpwebsite</a> <br>
                  </td>
                  <td>$jparea</td>
                  <td>$jpdesc</td>
                  <td>$totalJob</td>
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
</section>

<?php include './template/footer.php'; ?>

<script type="text/javascript">
$(document).ready( function () {
  $('#companies_table').DataTable();
} );
</script>
