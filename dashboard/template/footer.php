<!--- Start dari sini ke bawah: footer.php -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
<!-- To the right -->
<div class="pull-right hidden-xs">
  Anything you want
</div>
<!-- Default to the left -->
<strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
</footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="./template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="./template/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="./template/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DateTimePicker -->
<script src="./template/bower_components/moment/min/moment.min.js"></script>
<script src="./template/bower_components/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- Bootstrap FileInput -->
<script src="./template/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="./template/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- CK Editor -->
<script src="./template/bower_components/ckeditor/ckeditor.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
 Both of these plugins are recommended to enhance the
 user experience. -->
 <script>
   // add active class to navbar
   var url = window.location.pathname;
   var filename = url.substring(url.lastIndexOf('/')+1);
   $('a[href="./' + filename + '"]').parent().addClass('active');

   if(filename == "") {
     $('a[href="./index.php"]').parent().addClass('active');
   }

   $('.select2').select2();
 </script>
</body>
</html>
