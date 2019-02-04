<?php 
include'config/db.php';
include'config/functions.php';
include'config/main_function.php';
?>
<?php include'assets/header.php';?>

      </nav> 

    </div>
  </div>
  <div style="margin:100px;"></div>
   <div class="container" style="background:white; padding:20px;">
    <h3><i class="fa fa-calendar"></i> Schedule of Events</h3><hr>
    <p>Here are the list of schedule of events.</p>
    <br>
    <?php 
    $date = date("Y-m-d");
    $kweri = $dbcon->query("SELECT * FROM reservations WHERE reservation_status = 'Fully Paid' AND event_date >= '$date'") or die(mysqli_error());
    if(mysqli_num_rows($kweri) == 0){
      echo '<div class="alert alert-danger">There are no records on the database.</div>';
    }else{
      echo '<div class="row">';
      while($row = $kweri->fetch_assoc()){
    ?>
      <div class="col-sm-4">
        <div class="panel panel-success">
          <div class="panel-heading">Event Name: <?php echo $row['event_name']?></div>
            <div class="panel-body">
            <ul style="list-style: none; padding:5px;">
              <li><i class="fa fa-arrow-right"></i> Date / Time: <?php echo $row['event_date']?> / <?php echo date("h:i a",strtotime($row['event_time']));?> </li>
              <li><i class="fa fa-arrow-right"></i> Venue: <?php echo $row['event_venue']?></li>
            </ul>
            </div>
        </div>
      </div>
    
    <?php 
      }
      echo '</div>';
    }
    ?>


        <!-- / row -->
    </div><!-- / container -->
    <div style="margin:100px;"></div>
<?php include'assets/footer.php';?>
</body>
</html>



