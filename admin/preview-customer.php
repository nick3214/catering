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
            	<center><img src="../images/logo.png" align="center" width="200"> </center>
                <center><span style="font-size:40px;">JMDC TRATTORIAS</span><br>Lot 8 Block 26, Katipunan St., Kingspoint Subd.
Bagbag, Quezon City
JOSE ANGELO CERDON – Prop.
09156726535</center>

            </th>
        </tr>
    </thead>
    <tbody>

  <tr>
    <td>Full Name</td>
    <td>Email</td>
    <td>Contact Number</td>
    <td>Age</td>
    <td>Gender</td>
  </tr>
<?php 
	$getCustomer = getdata_where("*","user_role","user_account","1");
?>
<?php 
	if(!empty($getCustomer)):
?>
<?php foreach ($getCustomer as $key => $value):?>
	<tr>
    <td><?php echo $value->full_name?></td>
    <td><?php echo $value->user_email?></td>
    <td><?php echo $value->contact_num?></td>
    <td><?php echo $value->age?></td>
    <td><?php echo $value->gender?></td>
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