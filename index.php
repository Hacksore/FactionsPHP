<html>
<head>
	<title></title>
	<style>
		html, body{
			padding: 0;
			margin: 0;
			background-color: lightgray;
		}
		.user_line{
			background-color: #000;
			color: #F2E5EC;
			display: table;
			padding: 2px;
			margin: 6px 0px 6px 0px;
			border: 1px solid #000;
		}		
		.user_line:hover{
			background-color: #000;
			color: #fff;
			border-color: limegreen;
		}
		.container{
			margin: 0px auto 6px auto;
			height: 500px;
			overflow: auto;
			padding: 8px;
		}
		h2{
			color: #000;
		}
		A:link {color: #000; text-decoration: none}
		A:visited {color: #000; text-decoration: none}
		A:hover {color: #000; text-decoration: none}

	</style>
</head>
<body>
<div class="container">

	<?
	require "faction_api.php";
	$cl = new faction("factions.json", "players.json");

	$fid = $cl->getFactionIdFromName($_GET["f"]);
	if($fid != null){

	?>

	<h2>Faction: <?=$_GET["f"]?></h2> 
	<div class="user_line">
		ID: <?=$fid?>
	</div>	
	<div class="user_line">
		Power: <?=$cl->getFactionPower($fid)?>
	</div>	
	<div class="user_line">
		Members: <?=$cl->getFactionMembers($fid)?>
	</div>		
	<? } else{ 
		$factions = $cl->getAllFactions();
	?>
		<h2>Factions: <?=count($factions)?></h2> 
		<? foreach($factions as $k=>$v){ ?>
			<a href="?f=<?=$v["tag"]?>"><?=$v["tag"]?></a><br/>
		<? } ?>
	<? } ?>
</div>
</body>
</html>
