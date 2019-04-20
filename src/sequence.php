<?php
require_once("response_xml.php");
require_once("dbconf.php");

class Sequence {
	private $sequence = "";
	private $xuid = 0;
	private $target = 0;
	private $resp = null;
	private $mysql_conn = null;

	function run()
	{
		$method = $this->sequence;
		if (method_exists($this, $method))
     	{
         	$this->$method();
     	}else{
     		error_log("[ERROR - ASCEND API] Sequence Attempted to access invalid method! - Sequence: ".$this->sequence);
     	}
	}

	function SigninToAccountXbox360()
	{
		/* Response:
			XUID
			SteamId
			SteamOfferId
			SteamOrderId
			MarketplaceState
			CharacterId
			HideHelmet
			PendingSouls
			SystemSouls
			ContentionPointSouls
			WarChallengeSouls
			SoulGift
			SoulUpdateId
			BossGotKill
			Souls
			CharLevelCap
			AscLevelReqInc
			TranscCount
			AscCountLight
			AscCountDark
			AscCountVoid
			WarXp
			WarXpAsync
			WarXpLight
			WarXpDark
			WarXpVoid
			GameTime
			OfflineTime
			ContentVersion
			SessionId
			Banned

	*/

			$q = mysql_query("SELECT * FROM accounts WHERE SteamId='".$this->steamid."';") or die(error_log("Ascender API had an MySQL Error:".mysql_error()));
			$row = mysql_fetch_object($q);

			$res = $this->resp->add_result();
			$res->add_attribute("XUID",$this->steamid);
			$res->add_attribute("SteamId",$this->steamid);
			$res->add_attribute("SteamOfferId", $row->SteamOfferId);
			$res->add_attribute('SteamOrderId',$row->SteamOrderId);
			$res->add_attribute("MarketplaceState",$row->MarketplaceState);
			$res->add_attribute("CharacterID",$row->CharacterID); 
			$res->add_attribute("HideHelmet", $row->HideHelmet);
			$res->add_attribute("PendingSouls",$row->PendingSouls);
			$res->add_attribute("SystemSouls",$row->SystemSouls);
			$res->add_attribute("ContentionPointSouls",$row->ContentionPointSouls);
			$res->add_attribute("WarChallengeSouls",$row->WarChallengeSouls);
			$res->add_attribute("SoulUpdateId",$row->SoulUpdateId);
			$res->add_attribute("BossGotKill",$row->BossGotKill);
			$res->add_attribute("Souls",$row->Souls);
			$res->add_attribute("AscState",$row->AscState);
			$res->add_attribute("Achievements",$row->Achievements);
			$res->add_attribute("CharXp",$row->CharXp);
			$res->add_attribute("CharXpAtStart",$row->CharXpAtStart);
			$res->add_attribute("CharXpAtAsc",$row->CharXpAtAsc);
			$res->add_attribute("CharXpAsync",$row->CharXpAsync);
			$res->add_attribute("CharLevelCap",$row->CharLevelCap); 
			$res->add_attribute("AscLevelReqInc",$row->AscLevelReqInc);
			$res->add_attribute("TranscCount",$row->TranscCount);
			$res->add_attribute("AscCountLight",$row->AscCountLight);
			$res->add_attribute("AscCountDark",$row->AscCountDark);
			$res->add_attribute("AscCountVoid",$row->AscCountVoid);
			$res->add_attribute("WarXp",$row->WarXp);
			$res->add_attribute("WarXpAsync",$row->WarXpAsync);
			$res->add_attribute("WarXpLight",$row->WarXpLight);
			$res->add_attribute("WarXpDark",$row->WarXpDark);
			$res->add_attribute("WarXpVoid",$row->WarXpVoid);
			$res->add_attribute("GameTime",$row->GameTime);
			$res->add_attribute("OfflineTime",$row->OfflineTime);
			$res->add_attribute("ContentVersion",$row->ContentVersion); 
			$res->add_attribute("SessionId",mt_rand());
			$res->add_attribute("Banned",$row->Banned);

			if($row->CharacterID != 0)
			{
				$cq = mysql_query("SELECT * FROM characters WHERE CharacterID='".$row->CharacterID."';") or die(error_log("Ascender API had an MySQL Error: ".mysql_error()));
				$crow = mysql_fetch_object($cq);

				$res->add_attribute("Id",$crow->CharacterID);
				$res->add_attribute("CreatorXuid",$crow->SteamId);
				$res->add_attribute("Alignment",$crow->Alignment);
				$res->add_attribute("Name",base64_encode($crow->Name));
				$res->add_attribute("BodyParts",$crow->bodyParts);
				$res->add_attribute("EquipmentIds",$crow->EquipmentIds);
				$res->add_attribute("AbilityIds",$crow->AbilityIds);
				$res->add_attribute("MetaWarIds",$crow->MetaWarIds);
				$res->add_attribute("SkinColor",$crow->SkinColor);
				$res->add_attribute("HairColor",$crow->hairColor);

			}
			
			$this->resp->run();
	}

	function AddPendingSoulsAndXpXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function PushEventsXbox360()
	{
		//TODO: Reverse this further
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	} 

	function GetUserInfoSteam()
	{
		//TODO: Reverse further and determine actual response params
		$res = $this->resp->add_result();
		$res->add_attribute("OK",0);
		$res->add_attribute("Currency","1");
		$this->resp->run();
	}

	function __construct($params)
	{
		$this->mysql_conn = mysql_connect(db_host,db_user,db_pass) or die(error_log("AscenderAPI had a mysql error connecting! - ".mysql_error()));
		mysql_select_db("ascender");

		if(isset($params['xuid']))
			$this->steamid = mysql_real_escape_string($params['xuid']);
		
		if(isset($params['steamid']))
			$this->steamid = mysql_real_escape_string($params['steamid']);

		$this->sequence = $params['sequence'];
		$this->resp = new Response($this->sequence);
	
	}
}
?>