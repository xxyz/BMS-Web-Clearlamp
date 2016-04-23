<?php
//songdata 분류
function add_song($song, $mode, $level, $i)
{
	if($mode === "clear") {
		if($i !== 0)
		{
			if(strcmp($song->{"level"}, $level) === 0 && strcmp($song->{"clear"}, $i) === 0)
				return true;
		} 
		else
		{
			if(strcmp($song->{"level"}, $level) === 0 && empty($song->{"clear"})){
				return true;
			}
		}
	} else {
		if(strcmp($song->{"level"}, $level) === 0)
		{
			switch($i) {
				case 6:
					if($song->{"notes"}*2 === $song->{"score"}) {
						return true;
					}
					break;
				case 5:
					if($song->{"notes"}*2*0.8889 <= $song->{"score"} && $song->{"notes"}*2 > $song->{"score"}) {
						return true;
					}
					break;
				case 4:
					if($song->{"notes"}*2*0.7778 <= $song->{"score"} && $song->{"notes"}*2*0.8889 > $song->{"score"}) {
						return true;
					}
					break;
				case 3:
					if($song->{"notes"}*2*0.6667 <= $song->{"score"} && $song->{"notes"}*2*0.7778 > $song->{"score"}) {
						return true;
					}
					break;
				case 2:
					if($song->{"notes"}*2*0.5556 <= $song->{"score"} && $song->{"notes"}*2*0.6667 > $song->{"score"}) {
						return true;
					}
					break;
				case 1:
					if($song->{"notes"}*2*0.5556 > $song->{"score"} && $song->{"score"} > 0) {
						return true;
					}
					break;
				case 0:
					if(empty($song->{"clear"})) {
						return true;
					}
					break;
			}
		}
	}
	return false;
}

//Tooltip용 링크데이터
function tooltip_string($cleararray) 
{
	$linkdata = "<ul class='song_list'>";
	foreach($cleararray as $clearedsong){
		$linkdata=$linkdata.
		"<li><a target='_blank' href='http://www.dream-pro.info/~lavalse/LR2IR/search.cgi?mode=ranking&bmsmd5=".$clearedsong->{"md5"}."'>".str_replace("\"", "", $clearedsong->{"title"})."</a></li>";
	}
	$linkdata = $linkdata."</ul>";
	return $linkdata;
}

function get_currentclear($mode, $i, &$indexlabelcolor)
{
	if($mode === "clear") {
		switch ($i) {
			case 5:
				$currentclear = "FC";
				$indexlabelcolor = "#171717";
				break;
			case 4:
				$currentclear = "HARD";
				break;
			case 3:
				$currentclear = "CLEAR";
				break;
			case 2:
				$currentclear = "EASY";
				break;
			case 1:
				$currentclear = "FAILED";
				break;
			case 0:
				$currentclear = "Not Played";
				$indexlabelcolor = "#171717";
				break;
			default:
				break;
		}
	} else {
		switch ($i) {
			case 6:
				$currentclear = "MAX";
				break;
			case 5:
				$currentclear = "AAA";
				$indexlabelcolor = "#171717";
				break;
			case 4:
				$currentclear = "AA";
				$indexlabelcolor = "#171717";
				break;
			case 3:
				$currentclear = "A";
				break;
			case 2:
				$currentclear = "B";
				break;
			case 1:
				$currentclear = "C~F";
				$indexlabelcolor = "#171717";
				break;
			case 0:
				$currentclear = "Not Played";
				$indexlabelcolor = "#171717";
				break;
			default:
				break;
		}
	}
	return $currentclear;
}
function get_time() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
function read_url($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function randomcolor()
{
	$red = intval((mt_rand(0,256)+160)/2);
	$green = intval((mt_rand(0,256)+160)/2);
	$blue = intval((mt_rand(0,256)+160)/2);
	return "rgb(".$red.",".$green.",".$blue.")";
}

//LR2 cgi
function get_lr2_cgi($lr2ID) 
{
	return read_url("http://www.dream-pro.info/~lavalse/LR2IR/2/getplayerxml.cgi?id=".$lr2ID);
}
function get_playername($lr2_cgi)
{
	return mb_convert_encoding(substr($lr2_cgi, strpos($lr2_cgi, "<rivalname>")+11, strlen($lr2_cgi)-strpos($lr2_cgi, "<rivalname>")- 24), "UTF-8", "SJIS");
}

$table_url = $_GET["table_url"];
$html = read_url($table_url);
$lr2ID = $_GET["lr2ID"];
$mode = $_GET["mode"];
if(empty($_GET["mode"]))
{
	$mode = 'clear';
}

if(empty($lr2ID)===FALSE &&  $html !== FALSE)
{
    $start = get_time();
	
	$lr2_cgi = get_lr2_cgi($lr2ID);
	
	//playername, score들 get
	$playername = get_playername($lr2_cgi);
	$scorexml = simplexml_load_string(substr($lr2_cgi, 1, strpos($lr2_cgi, rivalname)-2));
	
	//table URL에서 html파싱 후  header.json url get
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$header_url;
	foreach($dom->getElementsByTagName('meta') as $link) 
	{
        if(strpos($link->getAttribute('content'), "json")!== FALSE)
		{
			$header_url = $link->getAttribute('content');
			if(strpos($header_url, "http") === FALSE)
				$header_url = substr($table_url, 0, strrpos($table_url, "/")+1).$header_url;
		}
	}
	
	//header.json
	$headerjson = json_decode(trim(trim(read_url($header_url), "\x00..\x1F"), "\x80..\xFF"));
	if(json_last_error() === JSON_ERROR_NONE)
	{
		$tablename = $headerjson->{"name"};
		$tablesymbol = $headerjson->{"symbol"};
		$data_url = $headerjson->{"data_url"};
	}
	
	//songdata.json
	if(strpos($data_url, "http") === FALSE)
		$data_url = substr($header_url, 0, strrpos($header_url, "/")+1).trim($data_url, "./");
	$songdata = json_decode($datastring = read_url($data_url));
	
	if(json_last_error() !== JSON_ERROR_NONE)
	{
		$datastring = trim(trim($datastring, "\x00..\x1F"), "\x80..\xFF");
		$songdata = json_decode( $datastring );
	}
	
    if(count($songdata)===0)
    {
    	exit("Unable to open Table <br><a href=\"javascript:history.go(-1)\">GO BACK</a>");
    }
    
	//Level의 목록을 get하고 clear항목을 cgi와 대조해 추가
	$levelarr = array();
	$all_level_count = array(0,0,0,0,0,0);

	if($songdata.length)
	foreach($songdata as $song)
	{
		foreach($scorexml->score as $score)
		{
			if(strcasecmp($score->hash, $song->{"md5"})===0)
			{
				$song->{"clear"} = $score->clear;
				$all_level_count[(int)$song->clear]++;
				$song->{"score"} = ((int)($score->pg))*2 + ((int)($score->gr));
				$song->{"notes"} = (int)($score->notes);
			}
		}
		if(!in_array($song->{"level"}, $levelarr))
			$levelarr[] = $song->{"level"};
	}
	natsort($levelarr);
	$levelarr=array_reverse($levelarr);
	
    $cleartime = get_time();
    
	//canvajs용 데이터 만들기
	$datafullstring;
	if($mode === "clear")
		$numberofLegend = 5;
	else
		$numberofLegend = 6;

	for($i = $numberofLegend; $i>=0; $i--)
	{
		$indexlabelcolor = "white";
		$currentclear = get_currentclear($mode, $i, $indexlabelcolor);

		//level 갯수에 따라 폰트사이즈 조정
		$indexfontsize = 22;
		$label_fontsize = 24;
		if(count($levelarr) < 16){
			$indexfontsize = 30;
			$label_fontsize = 30;
		} else if(count($levelarr) > 30){
			$label_fontsize = 17;
		}
		
		$datastring = "
		{
			indexLabelFontSize: ".$indexfontsize.",
			type: 'stackedBar100',
			showInLegend: true,
			toolTipContent: \"<span class='tooltip_h'>{label} {name} ({count})</span><hr/>{linkdata}\",
			name: '".$currentclear."',
			dataPoints:
			[
				";
		
		$all_level_counter = 0;

		foreach($levelarr as $level)
		{
			$cleararray = array();
			
			//songdata를 돌면서 현재 클리어(i)상태인 곡들 cleararray에 추가
			foreach($songdata as $song) {
				if(add_song($song, $mode, $level, $i)) 
				{
					$cleararray[] = $song;
				}
			}

			$currlevel_counter = count($cleararray);
			$all_level_counter +=$currlevel_counter;

			

			if($currlevel_counter > 0)
			{
				$linkdata = tooltip_string($cleararray);

				$datastring = $datastring."{y: ".$currlevel_counter.",
				linkdata: \"".$linkdata."\",
				count: '".$currlevel_counter."',
				label: '".$tablesymbol.$level."',
				indexLabelFontColor: '".$indexlabelcolor."',
				indexLabel: '".$currlevel_counter."',
				indexLabelPlacement: 'inside',
				},";
			}
			else 
			{
				$datastring = $datastring."{y: ".$currlevel_counter.",
				label: \"".$tablesymbol.$level."\"},";
			}
		}

		/* 
		//all level 추가
		if($all_level_counter>0)
		{
			$all_level_count[$i] = $all_level_counter;
			$datastring = $datastring."{y: ".$all_level_counter.",
			linkdata: \"\",
			count: \"".$all_level_counter."\",
			label: \"".$tablesymbol."All"."\",
			indexLabelFontColor: \"".$indexlabelcolor."\",
			indexLabel: \"".$all_level_counter."\",
			indexLabelPlacement: \"inside\",
			},";
		}
		else{
			$datastring = $datastring."{y: ".$all_level_counter.",
			label: \"".$tablesymbol."All"."\"},";
		}
		*/

		//끝부분 정리
		$datastring = substr($datastring, 0, strlen($datastring)-1)."]},";
		$datafullstring .=$datastring;
	}
	$datafullstring = "
    {
    	title: {
    		text: \"".$tablename." ".strtoupper($mode)." LAMP (Player: ".$playername.")\",
    		horizontalAlign: 'left',
    		fontSize: 25,
    		fontFamily: \"arial\",
    	},
    	backgroundColor: 'white',
    	animationEnabled: true,
		animationDuration: 1500,
    	toolTip: {
	      	shared: false,
	      	borderColor: \"black\",
	      	fontSize: 25,
	    },
	    legend:{
	    	fontSize: 20,
	    	fontFamily: \"arial\",
	    	verticalAlign: \"top\",
	    	horizontalAlign: \"right\",
		 },
    	colorSet: \"pastel\",
    	axisX:{
    		interval: 1,
    		labelFontSize: ".$label_fontsize.",
    	},
    	axisY:{
    		interval: 100,
    		labelFontColor: \"white\",
    	},
    	data:[".substr($datafullstring, 0, strlen($datafullstring)-1)."]}";
}

?>