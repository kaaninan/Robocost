<?php 

	
$a = array ( 
    0 => array ( 'value' => 'America', ), 
    1 => array ( 'value' => 'England', ),  
    2 => array ( 'value' => 'Australia', ), 
    3 => array ( 'value' => 'America', ), 
    4 => array ( 'value' => 'England', ), 
    5 => array ( 'value' => 'Canada', ), 
);

$tmp = array();

foreach ($a as $row) 
    if (!in_array($row,$tmp)) array_push($tmp,$row);

print_r ($tmp);

?>