<?

class faction{

	function faction($faction = "factions.json", $players = "players.json", $board = "board.json", $conf = "conf.json"){
		$this->factions = $faction;
		$this->players = $players;
		$this->board = $board;
		$this->conf = $conf;
		$this->factions_json = json_decode(file_get_contents($this->factions), true);
		$this->players_json = json_decode(file_get_contents($this->players), true);
		$this->board_json = json_decode(file_get_contents($this->board), true);
		$this->conf_json = json_decode(file_get_contents($this->conf), true);

	}

	function getFactionIdFromTagname($fname){
		$json = json_decode(file_get_contents($this->factions), true);
		foreach($json as $k=>$v){
			if($v["tag"] == $fname){
				return $k;
			}
		}
		return null;
	}

	function getFactionIdFromUsername($username){
		foreach($this->players_json as $k=>$v){
			if($k == $username){			
				return $v["factionId"];
			}			
		}
	}

	function getAllPlayers(){
		return $this->players_json;
	}

	function getAllFactions(){
		$skip = array(
			"§2Wilderness",
			"WarZone",
			"SafeZone"
		);
		foreach($skip as $k){
			unset($this->factions_json[$this->getFactionIdFromTagname($k)]);
		}
		return $this->factions_json;
	}

	function getPlayersFaction($fid){
		return $this->factions_json[$fid]["tag"];
	}	

	function getPlayerFactionRole($user){
		return $this->players_json[$user]["role"];
	}	
	function getPlayerPower($user){
		return floor($this->players_json[$user]["power"]);
	}

	function getFactionTag($fid){
		return $this->factions_json[$fid]["tag"];
	}

	function getFactionMembers($fid){	
		$users = array();
		foreach($this->players_json as $k=>$v){
			if($v["factionId"] == $fid){			
				$users["list"] .= $k.", ";
				$users["array"][] = $k;		
			}			
		}
		$users["list"] = substr($users["list"], 0, strlen($users["list"]) - 2);

		return $users;
	}	

	function getFactionPower($fid){		
		$pow = 0;
		foreach($this->players_json as $k=>$v){
			if($v["factionId"] == $fid){
				$pow += floor($v["power"]);
			}
		}
		return $pow;
	}

	function getFactiomMaxPower($fid){
		$members = $this->getFactionMembers($fid);
		$pow = $this->conf_json["powerPlayerMax"];
		$ret = 0;
		for($i=0;$i<count($members["array"]);$i++){
			$ret += $pow;
		}
		return $ret;
	}

	function getFactionLand($fid, $worlds = array("world")){
		$land = 0;
		foreach($worlds as $w){
			foreach($this->board_json[$w] as $k=>$v){
				if($fid == $v){
					$land++;
				}
			}	
		}
		return $land;
	}

}
