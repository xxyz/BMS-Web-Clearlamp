<?php
    header("Content-type: text/css; charset: UTF-8");
    
    function randomcolor(&$darkercolor)
    {
        $red = intval((mt_rand(0,256)+160)/2);
        $green = intval((mt_rand(0,256)+160)/2);
        $blue = intval((mt_rand(0,256)+160)/2);
        $darkercolor = "rgb(".intval($red*0.8).",".intval($green*0.8).",".intval($blue*0.8).")";
        return "rgb(".$red.",".$green.",".$blue.")";
    }
    $darkercolor;
    $randomcolor = randomcolor($darkercolor);
    
?>

#fs-form-wrap {
	position: absolute;
	top:0; right:0; bottom:0; left:0;
	background: <?php echo $randomcolor; ?>;
}
#fs-header {
	background: <?php echo $darkercolor; ?>;
	padding: 10px 0 10px 0;
}
#fs-form-wrap h1 {
	text-align: center;
	font-size: 3em;
	color: white;
	margin: 0;
}
#fs-form {
	min-width: 800px;
	width: 80%;
	margin: auto;
	margin-top: 7%;
}
#fs-form label {
	font-size: 2.5em;
	color: white;
}
#fs-form input {
	display: block;
	margin: 0;
	border: none;
	width: 100%;
	background-color: transparent;
	font-size: 2.2em;
	border-bottom: 2px solid #364556;
	color: white;
	margin-bottom: 3%;
}
#fs-form input:focus {
	border-bottom: 3px solid white;
	outline: none;
}
#fs-form label{
	display: block;
}

#fs-urlselect {
	background-color: <?php echo $darkercolor; ?>;
	color: white;
	font-size: 2em;
	border: none;
	outline: none;
	margin-top: 2%;
}
#fs-button {
	float: right;
	background: transparent;
	border: 3px solid white;
	color: white;
	font-size: 2.5em;
	cursor: pointer;
	padding: 5px 45px 5px 45px;
	
	transition: color 0.3s, background 0.3s;
}

#fs-button:hover {
	color: #364556;
	background: white;
}