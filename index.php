<?php 
/* 
*	index.php 
*	
*
*/
include_once('meta.php');
$handle = fopen("php://stdin","r");
$obj = new meta();
while ($site = fgets($handle)){
	$obj->retreiveMetaDetails($site);
}

?>