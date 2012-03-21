<?

class faction{

	function faction($faction = "factions.json", $players = "players.json"){
		$this->factions = $faction;
		$this->players = $players;
		$this->factions_json = json_decode(file_get_contents($this->factions), true);
		$this->players_json = json_decode(file_get_contents($this->players), true);

	}

	function getFactionIdFromName($fname){
		$json = json_decode(file_get_contents($this->factions), true);
		foreach($json as $k=>$v){
			if($v["tag"] == $fname){
				return $k;
			}
		}
		return null;
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
			unset($this->factions_json[$this->getFactionIdFromName($k)]);
		}
		return $this->factions_json;
	}

	function getPlayersFaction($fid){
		return $this->factions_json[$fid]["tag"];
	}

	function getFactionMembers($fid){	
		$users = "";
		foreach($this->players_json as $k=>$v){
			if($v["factionId"] == $fid){			
				$users .= $k.", ";			
			}			
		}
		$users = substr($users, 0, strlen($users) - 2);
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


}
