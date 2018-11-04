<?php

header("Access-Control-Allow-Origin: *");


function fetchData(){
	return @file_get_contents('https://myanimelist.net/animelist/bazingarj/load.json');	
}


$i = date('Y-m-d-');
$j = (int) (date('H')/6);

$t = $i.$j;

$file = "cached.json";
if(file_exists($file)){
	$f = json_decode(@file_get_contents($file), true);
	if($f['time'] === $t){
		$opt = $f['data'];
	} else {
		$tmp['time'] = $t;
		$opt = $tmp['data'] = fetchData();
		@file_put_contents($file, json_encode($tmp));
	}
} else {
	$tmp['time'] = $t;
	$opt = $tmp['data'] = fetchData();

	@file_put_contents($file, json_encode($tmp));
}

echo $opt;