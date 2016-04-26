<?php

function randomcolor()
{
	$red = intval((mt_rand(0,256)+160)/2);
	$green = intval((mt_rand(0,256)+160)/2);
	$blue = intval((mt_rand(0,256)+160)/2);
	return "rgb(".$red.",".$green.",".$blue.")";
}

?>