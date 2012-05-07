<?

class faction{

	function __construct($f = "factions.json", $p = "players.json", $b = "board.json", $c = "conf.json"){

		$this->factions = json_decode(file_get_contents($f), true);
		$this->players = json_decode(file_get_contents($p), true);
		$this->board = json_decode(file_get_contents($b), true);
		$this->conf = json_decode(file_get_contents($c), true);

	}

	function getFactionIdFromTagname($fname){		
		foreach($this->factions as $k=>$v){
			if($v["tag"] == $fname){
				return $k;
			}
		}
		return null;
	}

	function getFactionIdFromUsername($username){
		foreach($this->players as $k=>$v){
			if($k == $username){			
				return $v["factionId"];
			}			
		}
	}

	function getAllPlayers(){
		return $this->players;
	}

	function getAllFactions(){
		$skip = array(
			"§2Wilderness",
			"WarZone",
			"SafeZone"
		);
		foreach($skip as $k){
			unset($this->factions[$this->getFactionIdFromTagname($k)]);
		}
		return $this->factions;
	}

	function getPlayersFaction($fid){
		return $this->factions[$fid]["tag"];
	}	

	function getPlayerFactionRole($user){
		return $this->players[$user]["role"] == "ADMIN" ? "**" : ($this->players[$user]["role"] == "MODERATOR" ? "*" : "" ); 
	}	

	function getPlayerPower($user){
		return floor($this->players[$user]["power"]);
	}

	function getFactionTag($fid){
		return $this->factions[$fid]["tag"];
	}

	function getFactionMembers($fid){	
		$users = array();
		foreach($this->players as $k=>$v){
			if($v["factionId"] == $fid){			
				$users["list"] .= $this->getPlayerFactionRole($k).$k.", ";
				$users["array"][] = $k;		
			}			
		}
		$users["list"] = substr($users["list"], 0, strlen($users["list"]) - 2);

		return $users;
	}	

	function getFactionPower($fid){		
		$pow = 0;
		foreach($this->players as $k=>$v){
			if($v["factionId"] == $fid){
				$pow += floor($v["power"]);
			}
		}
		return $pow;
	}

	function getFactiomMaxPower($fid){
		$members = $this->getFactionMembers($fid);
		$pow = $this->conf["powerPlayerMax"];
		$ret = 0;
		for($i=0;$i<count($members["array"]);$i++){
			$ret += $pow;
		}
		return $ret;
	}


	function getFactionLand($fid, $worlds = array("world")){
		$land = 0;
		foreach($worlds as $w){
			if($this->board[$w] != null) { 
				foreach($this->board[$w] as $k=>$v){
					if($fid == $v){
						$land++;
					}
				}
			}
		}
		return $land;
	}

}
