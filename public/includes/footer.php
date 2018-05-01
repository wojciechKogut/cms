    <footer class="py-5 bg-dark" id="footer" style="width: 100%; height: 6em; position: absolute; bottom: 0">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2017</p>
      </div>
      <!-- /.container -->
    </footer>


    <!-- Bootstrap core JavaScript -->
<!--    <script src="<?php // echo ROOT; ?>admin/vendor/jquery/jquery.min.js"></script>-->
    <script src="<?php echo ROOT ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ROOT ?>js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="<?php echo ROOT ?>js/responsiveslides.min.js"></script>
    
    <script>
      $(function() {
        $(".rslides").responsiveSlides({
          auto: false,
          pager:true,
          nav: true,
          speed: 500,
          maxwidth: 800,
          namespace: "centered-btns"
        });
      });
    </script>
    
  </body>

</html>



