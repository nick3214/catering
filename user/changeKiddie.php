<?php
include'../config/db.php';

$counter = 0;
$function = $dbcon->query("SELECT * FROM menu_price WHERE no_menu ='".$_GET['field']."' AND head_type='1'") or die(mysqli_error());
while($functions = $function->fetch_assoc()){
	if($counter == 0){
		$_SESSION['ccomp'] = $functions['no_menu'];
		$counter += 1;
	}
	echo '<option value="'.$functions['menu_price'].'">'.$functions['menu_price'].'</option>';
}
?>