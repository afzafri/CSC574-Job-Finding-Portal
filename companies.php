<?php
  $pageTitle = "Companies List";
  include './template/header.php';
?>

<!-- Start post Area -->
<section class="post-area section-gap">
  <div class="container">

<table id="companies_table" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Company Name</th>
            <th>Address</th>
            <th>Job Scope</th>
            <th>Total Jobs</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Speedmart</td>
            <td>Wallagonia, Tapah Road</td>
            <td>Cashier, Finance</td>
            <td>10</td>
        </tr>
        <tr>
            <td>2</td>
            <td>TF Supermarket</td>
            <td>Pekan Tapah</td>
            <td>Cashier, Finance</td>
            <td>15</td>
        </tr>
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
