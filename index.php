<?php
  $pageTitle = "Job Done Posts";
  include './template/header.php';
?>


<!-- Start blog-posts Area -->
<section class="blog-posts-area section-gap">
  <div class="container">
    <div class="row">

      <!-- list post -->
      <div class="col-lg-8 post-list blog-post-list">

        <?php
          if($user_id != ""){
            ?>
            <form class="form-area single-widget" id="myForm" action="mail.php" method="post" class="contact-form text-right" enctype="multipart/form-data" onsubmit="return confirm('Post status?');">
              <div class="row">
                <div class="col-lg-12 form-group">
                  <input name="title" placeholder="Enter post Title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter post Title'" class="common-input mb-20 form-control" required="" type="text">

                  <textarea class="common-textarea mt-10 form-control" name="experience" placeholder="Share your job experience" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Share your job experience'" required=""></textarea>

                  <input name="image" class="common-input mb-20 form-control" type="file" id="jobImage">

                  <button class="primary-btn mt-20 text-white" style="float: right;" type="submit" name="newPost">Post Job Done</button>
                  <div class="mt-20 alert-msg" style="text-align: left;"></div>
                </div>
              </div>
            </form>
            <?php
          } ?>

        <?php

        for($i=0;$i<3;$i++) {
          ?>

          <div class="single-post">

            <a href="blog-single.html">
              <h1>
                Memotong Rumput di UiTM
              </h1>
            </a>

            <table>
              <tr>
                <td>
                  <img src="./template/img/blog/c2.jpg" alt=""> &nbsp;
                </td>
                <td>
                  <br>
                  <h5><a href="#">Emilly Blunt</a></h5>
                  <p class="date">December 4, 2017 at 3:12 pm </p>

                </td>
              </tr>
            </table>

            <p><i class="fa fa-building" aria-hidden="true"></i> Universiti Teknologi MARA, Tapah</p>
            <p>
              <img class="img-fluid" src="./template/img/blog/p3.jpg" alt=""> <br><br>
              MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. who has the willpower to actually sit through a self-imposed MCSE training.
            </p>

            <hr>

          </div>

          <?php
        }

        ?>
      </div>
      <!-- end post -->

      <!-- sidebar -->
      <div class="col-lg-4 sidebar">
        <div class="single-widget search-widget">
          <form class="example" action="#" style="margin:auto;max-width:300px">
            <input type="text" placeholder="Search Posts" name="search2">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>

        <div class="single-widget category-widget">
          <h4 class="title">Post Categories</h4>
          <ul>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Techlology</h6> <span>37</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Lifestyle</h6> <span>24</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Fashion</h6> <span>59</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Art</h6> <span>29</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Food</h6> <span>15</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Architecture</h6> <span>09</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Adventure</h6> <span>44</span></a></li>
          </ul>
        </div>

        <div class="single-widget recent-posts-widget">
          <h4 class="title">Recent Posts</h4>
          <div class="blog-list ">
            <div class="single-recent-post d-flex flex-row">
              <div class="recent-thumb">
                <img class="img-fluid" src="img/blog/r1.jpg" alt="">
              </div>
              <div class="recent-details">
                <a href="blog-single.html">
                  <h4>
                    Home Audio Recording
                    For Everyone
                  </h4>
                </a>
                <p>
                  02 hours ago
                </p>
              </div>
            </div>
            <div class="single-recent-post d-flex flex-row">
              <div class="recent-thumb">
                <img class="img-fluid" src="img/blog/r2.jpg" alt="">
              </div>
              <div class="recent-details">
                <a href="blog-single.html">
                  <h4>
                    Home Audio Recording
                    For Everyone
                  </h4>
                </a>
                <p>
                  02 hours ago
                </p>
              </div>
            </div>
            <div class="single-recent-post d-flex flex-row">
              <div class="recent-thumb">
                <img class="img-fluid" src="img/blog/r3.jpg" alt="">
              </div>
              <div class="recent-details">
                <a href="blog-single.html">
                  <h4>
                    Home Audio Recording
                    For Everyone
                  </h4>
                </a>
                <p>
                  02 hours ago
                </p>
              </div>
            </div>
            <div class="single-recent-post d-flex flex-row">
              <div class="recent-thumb">
                <img class="img-fluid" src="img/blog/r4.jpg" alt="">
              </div>
              <div class="recent-details">
                <a href="blog-single.html">
                  <h4>
                    Home Audio Recording
                    For Everyone
                  </h4>
                </a>
                <p>
                  02 hours ago
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="single-widget category-widget">
          <h4 class="title">Post Archive</h4>
          <ul>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Dec '17</h6> <span>37</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Nov '17</h6> <span>24</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Oct '17</h6> <span>59</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Sep '17</h6> <span>29</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Aug '17</h6> <span>15</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Jul '17</h6> <span>09</span></a></li>
            <li><a href="#" class="justify-content-between align-items-center d-flex"><h6>Jun '17</h6> <span>44</span></a></li>
          </ul>
        </div>

        <div class="single-widget tags-widget">
          <h4 class="title">Tag Clouds</h4>
           <ul>
            <li><a href="#">Lifestyle</a></li>
            <li><a href="#">Art</a></li>
            <li><a href="#">Adventure</a></li>
            <li><a href="#">Food</a></li>
            <li><a href="#">Techlology</a></li>
            <li><a href="#">Fashion</a></li>
            <li><a href="#">Architecture</a></li>
            <li><a href="#">Food</a></li>
            <li><a href="#">Technology</a></li>
           </ul>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- End blog-posts Area -->

<?php include './template/footer.php'; ?>

<script>
  $(function () {
    $("#jobImage").fileinput({
      theme: 'fa',
      dropZoneEnabled: false,
      showUpload: false,
      allowedFileExtensions: ['png','jpg','jpeg'],
      maxFileSize: 5000,
      msgPlaceholder: 'Choose image...',
    });
  });
  </script>
