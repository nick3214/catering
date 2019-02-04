<?php 
include'../config/db.php';

$comp = $dbcon->query("SELECT * FROM sub_category WHERE cat_id ='".$_GET['key']."'") 
or die(mysqli_error());
while($comps = $comp->fetch_assoc()){
	echo '<option value="'.$comps['sub_id'].'">'.$comps['sub_name'].' </option>';
}
?>