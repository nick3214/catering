<?php 
include'../config/db.php';
include'../config/main_function.php';
include'../config/functions.php';
?>
<html>
<title>Print Preview</title>
<link rel="stylesheet" href="../bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css">
<head></head>
<style>
 	
 	@media print {
  #hide {
    display: none;
  }
}

    @media screen{
    	thead{
    		display:none;
    	}
    }
    @media print{
    	thead{
    		display:table-header-group; margin-bottom:2px;
    	}
   	}
    @page{
    	margin-top:1cm;margin-left:1cm;margin-right:1cm;margin-bottom:1.5cm;
    	}
    }
</style>
<body>
	<table class="table table-bordered" style="font-size:10px;">
    <thead>
        <tr>
            <th colspan="10">
            	<center>
                    <img src="../images/logo.png" align="center" width="200">
                    <h3>Occasion Report</h3>
                </center>

                <center><span style="font-size:40px;">JMDC TRATTORIAS</span><br>Lot 8 Block 26, Katipunan St., Kingspoint Subd.
Bagbag, Quezon City
JOSE ANGELO CERDON – Prop.
09156726535</center>

            </th>
        </tr>
    </thead>
    <tbody>

  <tr>
    <td>Occasion Name</td>
    <td>Date Added</td>
  </tr>
<?php 
	$getOccasion = getdata("*","occasion");
?>
<?php 
	if(!empty($getOccasion)):
?>
<?php foreach ($getOccasion as $key => $value):?>
	<tr>
    <td><?php echo $value->occasion_name?></td>
    <td><?php echo $value->date_modified?></td>
    
  </tr>

<?php endforeach;?>
<?php else:?>
<?php endif;?>
    </tbody>

</table>
<div class="row">
<div class="col-md-4">Created by:<br><strong><?php echo $_SESSION['full_name']?></strong></div>
<div class="col-md-4">Signed by:<br><strong><?php echo $_SESSION['full_name']?></strong></div>
<div class="col-md-4">Date:<br><strong><?php echo date("Y-m-d");?></strong></div>
<center><a href="" class="btn btn-primary" id="hide" onclick="print()">Print Now</a></center>
</body>
</html>