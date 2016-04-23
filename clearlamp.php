<?php
	require('canvas_data.php');
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="@xxyzzzzz" />
		<meta name="twitter:title" content="BMS ClearLamp" />
		<meta name="twitter:description" content="<?php echo $tablename." ".strtoupper($mode)." LAMP"; if(!empty($playername)) echo " (".$playername.")";?>" />
		<script type="text/javascript" src="canvasjs.min.js"></script>
		<script type="text/javascript" src="classie.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<link href="style.css" rel="stylesheet" type="text/css">
		<title><?php echo $tablename." ".strtoupper($mode)." LAMP"; if(!empty($playername)) echo " (".$playername.")";?></title>
		
		<style>
			<?php $rancol = randomcolor();?>
			.lamp_header {
				background-color:<?=$rancol?>;
			}
			.ha-header-front form select option{
				background-color:<?=$rancol?>;
			}
			#formbutton:hover{
				color: <?=$rancol?>;
			}
			#imageexport a:hover{
				color: <?=$rancol?>;
			}
			#modeselect input[type="radio"]:checked + label {
				background: white;
				color: <?=$rancol?>;
			}
			#modeselect label:hover {
				background: white;
				color: <?=$rancol?>;
			}
		</style>
	</head>
	
	<body>
		<header id="lamp_header" class="lamp_header">
			<div class="ha-header-front">
				
				<h1 id='tablename'><span><?=$tablename?> ClearLamp</span></h1>
				
				<?php
					if(!empty($playername))
						echo "<h2 id='playername'>Player: <a target='_blank' href='http://www.dream-pro.info/~lavalse/LR2IR/search.cgi?mode=mypage&playerid=".$lr2ID."'>".$playername." (".$lr2ID.")"."</a></h2>";
					if(empty($lr2ID)===FALSE &&  $html !== FALSE) {
						echo '<div id="imageexport">
								<a class="shrinkbutton" id="download" href="#" download="'.$tablename." ".strtoupper($mode)." LAMP (Player:".$playername.').png">Save as PNG</a>
							</div>';
					}
				?>
				
				<form name="LR2IDForm" method="GET" action="clearlamp">
					<button id="formbutton">OK</button>
					<div class="leftdiv">
						<label for="lr2ID">
							LR2ID:
						</label>
						<input type="text" name="lr2ID" id="lr2ID" pattern="[0-9]{0,6}" value="<?php echo $lr2ID; ?>">
						<div id="modeselect" class="">
							<input type="radio" id="clear" name="mode" value="clear" checked <?php if(strcmp($mode, "clear") === 0) echo "checked"; ?>><label for="clear" class="toggle-btn">Clear</label>
							<input type="radio" id="judge" name="mode" value="judge" <?php if(strcmp($mode, "judge") === 0) echo "checked"; ?>><label for="judge" class="toggle-btn">Judgement</label>
						</div>
					</div>
					<div class="leftdiv">
						<label for="urlselect">	URL:</label>
						<select id="urlselect" class="urlselect" onchange="this.nextElementSibling.value=this.value, this.form.submit()">
							<option value=" <?=$table_url?>">
								<?php 
									if(empty($tablename) ===FALSE){echo $tablename;}
									else {echo "Select Table";}
								?>
							</option>
							<option value="">────────SP / 7keys────────</option>
						    <option value="http://www.ribbit.xyz/bms/tables/insane.html">発狂BMS難易度表</option>
						    <option value="http://www.ribbit.xyz/bms/tables/normal.html">通常難易度表</option>
						    <option value="http://www.ribbit.xyz/bms/tables/overjoy.html">Overjoy</option>
						    <option value="http://www.ribbit.xyz/bms/tables/genocideproposal.html">GENOCIDE新規提案一覧表</option>
						    <option value="http://flowermaster.web.fc2.com/lrnanido/gla/LN.html">LN難易度</option>
						    <option value="http://bmsnormal2.syuriken.jp/table.html">第2通常難易度表</option>
						    <option value="http://bmsnormal2.syuriken.jp/table_insane.html">第2発狂難易度表</option>
						    <option value="http://minddnim.web.fc2.com/sara/AllMusic/bms_sara_all.html">皿難易度表</option>
						    <option value="http://kdiff.web.fc2.com/sptable.html">K BMS TABLE (SP)</option>
						    <option value="http://www.geocities.jp/vinyl8310/gl/resjoygl.html">resjoy</option>
						    <option value="http://kinokonohakkyounanido.web.fc2.com/index.html">きのこの難易度表</option>
						    <option value="http://3228monsta.web.fc2.com/monstajoy.html">MonstaJoy</option>
						    <option value="http://swamelo.web.fc2.com/01_HK.html">swa倉庫</option>
						    <option value="http://moriosabun.digi2.jp/morio.HTML">morio難易度表</option>
						    <option value="http://jakko.web.fc2.com/table.html">jakko難易度表</option>
						    <option value="http://akred.web.fc2.com/ak-red-new.html">赤い人難易度表</option>
						    <option value="http://akred.web.fc2.com/baecon-new.html">BAECON難易度表</option>
						    <option value="http://kspinbms.web.fc2.com/insanetable.html">K-SPIN発狂難易度表</option>
						    <option value="http://xyzzz.net/objxyz.php">obj.XYZ</option>
						    <option value="http://hogeeeeeee.ma-jide.com/outsideln.html">LN表外難易度</option>
						    <option value="http://infinity.s60.xrea.com/bms/gla/">連打難易度表</option>
						    <option value="http://kspinbms.web.fc2.com/insanetable.html">K-SPIN発狂難易度表</option>
						    <option value="http://lxrlr.web.fc2.com/overjoykz.html">Overjoy勝手に改造</option>
							<option value="http://kusefumen.web.fc2.com/kuse/kuse_nannido.html">癖譜面コレクション(仮)</option>
							<option value="http://walkure.net/hakkyou/for_glassist/bms/?lamp=easy">発狂BMS難度推定表 EASY</option>
							<option value="http://walkure.net/hakkyou/for_glassist/bms/?lamp=normal">発狂BMS難度推定表 NORMAL</option>
							<option value="http://walkure.net/hakkyou/for_glassist/bms/?lamp=hard">発狂BMS難度推定表 HARD</option>
							<option value="http://walkure.net/hakkyou/for_glassist/bms/?lamp=fc">発狂BMS難度推定表 FC</option>
						    <option value="">────────DP / 14keys────────</option>
						    <option value="http://dpbmsdelta.web.fc2.com/table/insane.html">発狂DP難易度表</option>
						    <option value="http://dpbmsdelta.web.fc2.com/table/dpdelta.html">δ難易度表</option>
						    <option value="http://yuyuyu.soudesune.net/DPgottani/insane2.html">発狂DPBMSごった煮難易度表</option>
						    <option value="http://kdiff.web.fc2.com/dptable.html">K BMS TABLE (DP)</option>
						    <option value="">────────PMS / 9keys────────</option>
						    <option value="http://hiiiii.web.fc2.com/pms/Table.htm">通常PMS難易度表</option>"
						    <option value="http://stellawingroad.web.fc2.com/new/pms.html">発狂PMS難易度表</option>
						    <option value="http://stellawingroad.web.fc2.com/new2/pms.html">発狂PMS表外案内所</option>
						    <option value="http://stellawingroad.web.fc2.com/new3/pms.html">発狂PMS表外案内所隔離枠</option>
						    <option value="http://stellawingroad.web.fc2.com/new4/pms.html">準発狂PMS難易度表</option>
						    <option value="http://zatsuzatsupms.yokochou.com/jsonver/jsonindex.html">酸素PMS難易度表</option>
						    <option value="http://nigo10sabun.web.fc2.com/nigo10json.html">西ヶ蜂難易度表</option>
						    <option value="http://stellawingroad.web.fc2.com/g2r/pms.html">G2R PMS難易度表</option>
						    <option value="">────────Custom URL────────</option>
						</select>
						<input type="text" id="table_url" name="table_url" class="urlinput" value="<?php echo $table_url;?>" />
					</div>
				</form>
			</div>
		</header>
		<div class="wrapper">
			<div id="chartContainer" class="chartdiv"></div>
			<div id="tableContainer" class="tablediv">
				<?php
				//make table
					if(empty($lr2ID)===FALSE &&  $html !== FALSE && $mode === "clear") {
						echo "
						<table id='count_table'>
							<thead>
								<tr class='count_table_head'>
									<th>FC</th>
									<th>HARD</th>
									<th>GROOVE</th>
									<th>EASY</th>
									<th>FAILED</th>
									<th>NotPlayed</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class='FC'>".$all_level_count[5]."</td>
									<td class='HARD'>".$all_level_count[4]."</td>
									<td class='GROOVE'>".$all_level_count[3]."</td>
									<td class='EASY'>".$all_level_count[2]."</td>
									<td class='FAILED'>".$all_level_count[1]."</td>
									<td class='NOPLAY'>".$all_level_count[0]."</td>
							</tbody>
						</table>";
					} else if(empty($lr2ID)===FALSE &&  $html !== FALSE && $mode === "judge") {
						echo "
						<table id='count_table'>
							<thead>
								<tr class='count_table_head'>
									<th>MAX</th>
									<th>AAA</th>
									<th>AA</th>
									<th>A</th>
									<th>B</th>
									<th>C~F</th>
									<th>NotPlayed</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class='MAX'>".(int)($all_level_count[6])."</td>
									<td class='AAA'>".$all_level_count[5]."</td>
									<td class='AA'>".$all_level_count[4]."</td>
									<td class='A'>".$all_level_count[3]."</td>
									<td class='B'>".$all_level_count[2]."</td>
									<td class='CF'>".$all_level_count[1]."</td>
									<td class='NOPLAY'>".$all_level_count[0]."</td>
							</tbody>
						</table>";
					}
					
				?>
			</div>
			<div id="twitbuttondiv">
				<a href="https://twitter.com/share" class="twitter-share-button" data-size="large">Tweet</a>
				<script>
				!function(d,s,id){
					var js,fjs=d.getElementsByTagName(s)[0], p=/^http:/.test(d.location)?'http':'https';
					if(!d.getElementById(id)) {
						js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
						fjs.parentNode.insertBefore(js,fjs);
					}
				}(document, 'script', 'twitter-wjs');
				</script>
			</div>
		</div>
		<script>
			window.onload = function () {
				<?php
					if($mode === "clear")
						echo 'CanvasJS.addColorSet("pastel", ["#FFC000", "#D9534F", "#FF8C00", "#40C000", "#606060", "#F0F0F0",]);';
					else
						echo 'CanvasJS.addColorSet("pastel", ["#CC0000", "#ffd040", "#BFC1C2", "#CD7F32", "#B0E57C", "#ACD1E9", "#F0F0F0"]);';
				?>
    			var chart = new CanvasJS.Chart("chartContainer", <?php echo $datafullstring;?>);
    			chart.render();
    			imagefiledownload();
    			resizeh1();
    		}
    		
    		window.onresize = function(event){
    			resizeh1();
    		}
    		
    		document.getElementById('download').addEventListener('click', function() {
			    imagefiledownload();
			}, false);

    		function imagefiledownload() {
    			var canvas = document.getElementsByClassName("canvasjs-chart-canvas");
    			var img = canvas[0].toDataURL("image/png").replace("image/png", "image/octet-stream");
    			document.getElementById('download').setAttribute("href", img)
    		}
    		
    		function resizeh1() {
    			var winwidth = Math.max($(window).width(), 800);
    			var h2width = $('#playername').width();
    			$('#tablename').css({'width': (winwidth-h2width-180)+'px'});
    		};
    		
    		$('input[type=radio]').on('change', function() {
			    $(this).closest("form").submit();
			});
    		
			var cbpAnimatedHeader = (function() {	
				var docElem = document.documentElement,
					header = document.querySelector( '.lamp_header' ),
					button = document.querySelector( '.shrinkbutton')
					didScroll = false,
					changeHeaderOn = 10;
			
				function init() {
					window.addEventListener( 'scroll', function( event ) {
						if( !didScroll ) {
							didScroll = true;
							setTimeout( scrollPage, 250 );
						}
					}, false );
				}
			
				function scrollPage() {
					var sy = scrollY();
					if ( sy >= changeHeaderOn ) {
						classie.add( header, 'lamp_header-shrink' );
						classie.add( button, 'shrinkbutton-shrink');
					}
					else {
						classie.remove( header, 'lamp_header-shrink' );
						classie.remove( button, 'shrinkbutton-shrink');
					}
					didScroll = false;
				}
			
				function scrollY() {
					return window.pageYOffset || docElem.scrollTop;
				}
			
				init();
			
			})();
			
			//google analytics
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-51935531-1', 'auto');
		  ga('send', 'pageview');
		</script>
	</body>
</html>