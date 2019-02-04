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
                <center><span style="font-size:16px;">JMDC TRATTORIAS</span><br>Lot 8 Block 26, Katipunan St., Kingspoint Subd.
Bagbag, Quezon City
JOSE ANGELO CERDON – Prop.
09156726535</center>
            </th>
        </tr>
        <tr>
            <th><h4>Product List</h4> </th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>

  <tr>
    <td>Item Name</td>
    <td>Price</td>
    
  </tr>
<?php 
	$getMenu = getdata("*","freebies");
?>
<?php 
	if(!empty($getMenu)):
?>
<?php foreach ($getMenu as $key => $value):?>
	<tr>
    <td><?php echo $value->freebie_name?></td>
    <td><?php echo $value->f_price?></td>
  </tr>

<?php endforeach;?>
<?php else:?>
<?php endif;?>
    </tbody>
<tr>
        <td>Created by: <strong><?php echo $_SESSION['full_name']?></strong></td>

        <td>Signed by: <strong><?php echo $_SESSION['full_name']?></strong></td>
    </tr>
<tr>
    <td>Date:</td>
    <td><strong><?php echo date("Y-m-d");?></strong></td>
</tr>
</table>
<center><a href="" class="btn btn-primary" id="hide" onclick="print()">Print Now</a></center>
</body>
</html>