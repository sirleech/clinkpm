<?php

$array['name'] = 'bob';
$array['dob'] = '2010-05-05';
$array['sex'] = 'M';

foreach ($array as $i => $value)
{
	echo $array[$i];
	echo '<br>';
}

if (isset($array['age'])){
	echo $array['age'];
	}

?>