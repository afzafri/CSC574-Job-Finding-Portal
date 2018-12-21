<!--- Start dari sini ke bawah: footer.php -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
<!-- To the right -->
<div class="pull-right hidden-xs">
  Afif, Akmal, Hassan, Hussin
</div>
<!-- Default to the left -->
<strong>Copyright &copy; 2018 <a href="#">Job Finding Portal</a>.</strong> All rights reserved.

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
<script src="./template/bower_components/DataTables/datatables.js"></script>
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

   // DataTables
   var boxTitle = $('.box-title').text();
   var table = $('#jobTable, #applicationsTable, #postsTable, #seekersTable, #providersTable').DataTable( {
       dom: 'Bfrtilp',
       buttons: [
             'copy',
             {
                  extend: 'excel',
                  text: '<i class="fa fa-fw fa-file-excel-o"></i> Excel',
                  titleAttr: 'Export all data into Excel file',
                  title: boxTitle,
                  exportOptions: {
                      columns: 'th:not(:last-child)'
                  }
              },
              {
                   extend: 'csv',
                   text: '<i class="fa fa-fw fa-file-excel-o"></i> CSV',
                   titleAttr: 'Export all data into CSV file',
                   title: boxTitle,
                   exportOptions: {
                       columns: 'th:not(:last-child)'
                   }
               },
            {
                 extend: 'pdf',
                 text: '<i class="fa fa-fw fa-file-pdf-o"></i> PDF',
                 titleAttr: 'Export all data into PDF file',
                 title: boxTitle,
                 exportOptions: {
                     columns: 'th:not(:last-child)'
                 }
             },
             {
                  extend: 'print',
                  text: '<i class="fa fa-fw fa-print"></i> Print',
                  titleAttr: 'Print Data',
                  title: boxTitle,
                  exportOptions: {
                      columns: 'th:not(:last-child)'
                  }
              }
       ],
       order: [
         [0,"desc"]
       ]
   });
 </script>
</body>
</html>
