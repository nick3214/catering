<?php 
include'../config/db.php';

$type = $_POST['type'];
$list = $_POST['list'];
$comp = $dbcon->query("SELECT * FROM motif WHERE occasion_id ='".$list."'&&motif_type='".$type."'") 
or die(mysqli_error());
while($comps = $comp->fetch_assoc()){
	echo '<option value="'.$comps['id'].'">'.$comps['motif'].' </option>';
}
?>