<!-- start footer Area -->
<footer style="background-color: #222222; padding-top:20px">
  <div class="container">

    <div class="row d-flex justify-content-between">
      <p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Job Finding Portal
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
      </p>
      <div class="col-lg-4 col-sm-12 footer-social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-dribbble"></i></a>
        <a href="#"><i class="fa fa-behance"></i></a>
      </div> <br><br>
    </div>
  </div>
</footer>
<!-- End footer Area -->

<script src="./template/js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="./template/js/vendor/bootstrap.min.js"></script>
  <script src="./template/js/easing.min.js"></script>
<script src="./template/js/hoverIntent.js"></script>
<script src="./template/js/superfish.min.js"></script>
<script src="./template/js/jquery.ajaxchimp.min.js"></script>
<script src="./template/js/jquery.magnific-popup.min.js"></script>
<script src="./template/js/owl.carousel.min.js"></script>
<script src="./template/js/jquery.sticky.js"></script>
<script src="./template/js/jquery.nice-select.min.js"></script>
<script src="./template/js/parallax.min.js"></script>
<script src="./template/js/mail-script.js"></script>
<script src="./template/js/main.js"></script>
<!-- DataTables -->
<script src="./dashboard/template/bower_components/DataTables/datatables.js"></script>
<!-- Bootstrap FileInput -->
<script src="./dashboard/template/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="./dashboard/template/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- CK Editor -->
<script src="./dashboard/template/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function() {
    // add active class to navbar
    var url = window.location.pathname;
    var filename = url.substring(url.lastIndexOf('/')+1);
    $('a[href="./' + filename + '"]').parent().addClass('navActive');

    if(filename == "") {
      $('a[href="./index.php"]').parent().addClass('navActive');
    }

    $('.select2').select2();
  })
</script>
</body>
</html>
