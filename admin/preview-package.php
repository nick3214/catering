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
    h4{
        font-size:13px;
    }
</style>
<body style="font-size:11px;">
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
    </tbody>
    <tr>
        <td colspan="100">
           <?php if($_GET['package'] == '0'):?>
<?php 
    $query = "SELECT * FROM packages WHERE p_type = '0' AND custom_user='0'";
    $stnd = getdata_inner_join($query);
?>
<?php if(!empty($stnd)):?>
<?php foreach ($stnd as $key => $stnds):?>
    <?php $viewPackage = single_get("*","code","packages",$stnds->code);?>
    <h4><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h4>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <p>Minimum of <?php echo $viewPackage['no_person']?> pax</p>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$stnds->code." ORDER BY `package_extension`.`package_sync` DESC";
                $fetchEx = getdata_inner_join($query);
                ?>
                <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              <hr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php elseif($_GET['package'] == '1'):?>
    <?php 
    $query = "SELECT * FROM packages WHERE p_type = '1' AND custom_user='0'";
    $full = getdata_inner_join($query);
?>
<?php if(!empty($full)):?>
<?php foreach ($full as $key => $fulls):?>
    <?php $viewPackage = single_get("*","code","packages",$fulls->code);?>
    <h4><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h4>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <p>Minimum of <?php echo $viewPackage['no_person']?> pax</p>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$fulls->code." ORDER BY `package_extension`.`package_sync` DESC";
                $fetchEx = getdata_inner_join($query);
                ?>
                <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              <hr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php elseif($_GET['package'] == '2'):?>
<?php 
    $query = "SELECT * FROM packages WHERE p_type = '2' AND custom_user='0'";
    $kiddie = getdata_inner_join($query);
?>
<?php if(!empty($kiddie)):?>
<?php foreach ($kiddie as $key => $kiddies):?>
    <?php $viewPackage = single_get("*","code","packages",$kiddies->code);?>
    <h4><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h4>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <p>Minimum of <?php echo $viewPackage['no_person']?> pax</p>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$kiddies->code." ORDER BY `package_extension`.`package_sync` DESC";
                $fetchEx = getdata_inner_join($query);
                ?>
                <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              <hr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php elseif($_GET['package'] == '3'):?>
            <?php 
    $query = "SELECT * FROM packages WHERE custom_user='1'";
    $custom = getdata_inner_join($query);
?>
<?php if(!empty($custom)):?>
<?php foreach ($custom as $key => $customs):?>
    <?php $viewPackage = single_get("*","code","packages",$customs->code);?>
    <h4><?php echo $viewPackage['package_name'];?> - &#8369; <?php echo $viewPackage['total_price']?></h4>
                <?php if($viewPackage['no_person'] == '0'):?>
                  Min. of <?php echo $viewPackage['no_adults']?> pax-adults & <?php echo $viewPackage['no_kids']?>pax-kids
                <?php else:?>
                <p>Minimum of <?php echo $viewPackage['no_person']?> pax</p>
              <?php endif;?>
                <?php 
                $query = "SELECT * FROM package_extension WHERE code = ".$customs->code." ORDER BY `package_extension`.`package_sync` DESC";
                $fetchEx = getdata_inner_join($query);
                ?>
                <?php if(!empty($fetchEx)):?>
                  <ul>
                <?php foreach ($fetchEx as $key => $value):?>
                  <li><?php echo $value->ex_name?></li>
                <?php endforeach;?>
                  </ul>
              <?php else:?>
                <div class="alert alert-danger">No records on the database.</div>
              <?php endif;?>
              <hr>
<?php endforeach;?>
<?php else:?>
<?php endif;?>
<?php endif;?> 
        </td>
    </tr>
    <tr>
        <td>Created by:</td>
        <td>
            <strong><?php echo $_SESSION['full_name']?></strong>
        </td>
        <td>Signed by:</td>
        <td>
            <strong><?php echo $_SESSION['full_name']?></strong>
        </td>
        <td>Date:</td>
        <td><strong><?php echo date("Y-m-d");?></strong></td>
    </tr>
</table>

<center><a href="" class="btn btn-primary" id="hide" onclick="print()">Print Now</a></center>
</body>
</html>