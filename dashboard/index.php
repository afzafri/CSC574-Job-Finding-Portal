<?php
  $pageTitle = "Home";
  include './template/header.php';

  if(isset($_POST['insertJob'])) {
    
  }
?>

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Job Applications List</h3>
    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-add-job"><i class="fa fa-fw fa-plus"></i> Add Job</button>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>Trident</td>
        <td>Internet
          Explorer 4.0
        </td>
        <td>Win 95+</td>
        <td> 4</td>
        <td>X</td>
      </tr>
      </tfoot>
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
                <h4 class="modal-title">Default Modal</h4>
              </div>
              <form action="./index.php" method="post">
                <div class="modal-body">
                <!--modal body-->
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Job Title</label>
                    <input type="text" class="form-control" placeholder="Enter Job Title" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Job Description</label>
                    <input type="text" class="form-control" placeholder="Enter Job Description" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Job Area</label>
                    <input type="text" class="form-control" placeholder="Enter Job Area" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Job Salary</label>
                    <input type="text" class="form-control" placeholder="Enter Job Salary" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Job Start</label>
                    <input type="text" id="startDateTime" class="form-control" placeholder="Enter Job Start Date and Time" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Job End</label>
                    <input type="text" id="endDateTime" class="form-control" placeholder="Enter Job End Date and Time" required>
                  </div>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="insertJob">Save changes</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        </form>

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    $('#example1').DataTable();

    $('#startDateTime, #endDateTime').datetimepicker();

  })
</script>
