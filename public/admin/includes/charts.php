
      <!-- Area Chart Example-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Area Chart</div>
        <div class="card-body">
            
            <?php 
            $number_of_users = $params[0];
            $number_of_posts = $params[1];
            $number_of_categories = $params[2];
            $number_of_comments = $params[3];
            $numbers_of_sub = $params[4];
            $number_of_active_posts = $params[5];
            $number_of_draft_posts = $params[6];
            ?>
            
 <script type="text/javascript">  
     
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
            
            function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Count');
        data.addRows([
          ['Posts', <?php echo $number_of_posts ?>],
          ['Users', <?php echo $number_of_users ?>],
          ['Categories', <?php echo $number_of_categories ?>],
          ['Comments', <?php echo $number_of_comments ?>],
          ['Subscribers', <?php echo $numbers_of_sub ?>],
          ['Active posts',<?php echo $number_of_active_posts ?>],
          ['Draft posts',<?php echo $number_of_draft_posts ?>]
        ]);

        // Set chart options
       var options = {
                    chart: {
                        title: '',
                        subtitle: '',
                    }
                    };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
        chart.draw(data, options);
      }
            
 </script>     
 
          
          <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            
          <!--<canvas id="myAreaChart" width="100%" height="30"></canvas>-->
        </div>
        <div class="card-footer small text-muted">Updated <?php echo date(" Y-m-d H:i:s"); ?></div>
      </div>
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2017</small>
        </div>
      </div>
    </footer>
      
      
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    
    
    
    
    
    <!-- Logout Modal-->
<!--    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="/page/admin/includes/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>-->
    