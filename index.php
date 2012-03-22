<html>
<head>
	<title></title>
	<style>
		html, body{
			padding: 0;
			margin: 0;
			background-color: lightgray;
		}
		.user_line a{
			color: #fff !important;
		}	
		.user_line{
			background-color: #000;
			color: #F2E5EC;
			#display: table;
			padding: 2px;
			margin: 6px 0px 6px 0px;
			border: 1px solid #000;
			font-weight: bold;
		}		
		.user_line:hover{
			background-color: #000;
			color: #fff;
			border-color: limegreen;
		}
		.container{
			margin: 0px auto 6px auto;
			height: 500px;
			width: 500px;
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
	<form action="" method="GET">
		Username: <input type="text" name="u" />
		<input type="submit" value="Search" />
	</form>
	<form action="" method="GET">
		Faction: <input type="text" name="f" />
		<input type="submit" value="Search" />
	</form>
	<?
	require "faction_api.php";
	$cl = new faction("factions.json", "players.json", "board.json", "conf.json");
	$username = $_GET["u"];
	$fid = $cl->getFactionIdFromTagname($_GET["f"]);
	$_fid = $cl->getFactionIdFromUsername($username);
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
		Land: <?=$cl->getFactionLand($fid)?>
	</div>	
	<div class="user_line">
		<?
		$members = $cl->getFactionMembers($fid);
		?>
		Members: <?=$members["list"]?>
	</div>		
	<?
	}
	elseif($_GET["u"]){
	?>

	<h2>User: <?=$_GET["u"]?></h2> 
	<div class="user_line">
		Faction: <?=$cl->getFactionTag($_fid)?>
	</div>	
	<div class="user_line">
		Role: <?=$cl->getPlayerFactionRole($username)?>
	</div>		
	<div class="user_line">
		Power: <?=$cl->getPlayerPower($username)?>
	</div>		
	<?
	}

	else{ 
		$factions = $cl->getAllFactions();
	?>
		<h2>Factions: <?=count($factions)?></h2> 
		<? foreach($factions as $k=>$v){ ?>
			<div class="user_line">
				<a href="?f=<?=$v["tag"]?>"><?=$v["tag"]?> (<?=$cl->getFactionLand($k)?> / <?=$cl->getFactionPower($k)?> / <?=$cl->getFactiomMaxPower($k)?>)</a> 
			</div>
		<? } ?>
	<? } ?>
</div>
</body>
</html>
