
<footer class="main-footer" style="width:87%; margin: 0 auto;">
    
    <strong>Copyright &copy; 2018.</strong> All rights
    reserved.
  </footer>
  
</div>

<script src="../bootstrap/bower_components/jquery/dist/jquery.min.js"></script>

<script src="../bootstrap/bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="../bootstrap/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bootstrap/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../bootstrap/bower_components/raphael/raphael.min.js"></script>
<script src="../bootstrap/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../bootstrap/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../bootstrap/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../bootstrap/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../bootstrap/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!--
<script src="../bootstrap/bower_components/moment/min/moment.min.js"></script>
<script src="../bootstrap/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../bootstrap/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
-->
<script src="../bootstrap/bower_components/moment/moment.js"></script>
<script src="../bootstrap/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../bootstrap/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bootstrap/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../bootstrap/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../bootstrap/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../bootstrap/dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        defaultView: 'month',
        events: {
            url: 'getEvent.php',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.');
            }
           
        }

    });
});
</script>
</body>
</html>