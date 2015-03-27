<?php 
/* 
*	search.php 
*	
*
*/
include_once('meta.php');
$handle = fopen("php://stdin","r");
$obj = new meta();
while ($site = fgets($handle)){
    $output = $obj->searchEngine($site);
    if (!empty($output)){
        foreach($output as $key => $value)
        {
            if ($key == 'site_url')
                echo $value;
        }
    }
}

   

?>