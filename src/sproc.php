<?php
require_once("response_xml.php");

class Sproc {
	private $sproc = "";
	private $xuid = 0;
	private $target = 0;
	private $resp = null;

	function run()
	{

		$method = $this->sproc;
		if (method_exists($this, $method))
     	{
         	$this->$method();
     	}else{
     		error_log("[ERROR - ASCEND API] SPROC Attempted to access invalid method! - Sproc: ".$this->sproc);
     		// If API isn't valid just return nothing
     		$this->resp->run();
     	}

	}
	
	/*
	/game/sproc?sproc=CreateCharacter4Xbox360&xuid=123457&sessionId=22&align=0&bodyParts=Head02%2CNoHair%2CNoBeard%2CCaosBody%2CCaosHands%2CCaosFeet%2C&skinColor=AgDz8nI%2F19ZWP8zLSz8AAIA%2F&equipNames=Starting_Armor_02_Helmet%2C%2C%2CStarting_Armor_02_Chest%2CStarting_Armor_02_Gauntlets%2CStarting_Armor_03_Boots%2C2HS_Starting_Basic&equipResIds=324%2C65535%2C65535%2C205%2C331%2C207%2C1&equipIds=0%2C0%2C0%2C0%2C0%2C0%2C0&hairColor=AgDz8nI%2F19ZWP8zLSz8AAIA%2F&name=AFAAZQByAG0AYQBOAHUAbABs
	*/

	function CreateCharacter4Xbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Equipment","Starting_Armor_02_Helmet,,,Starting_Armor_02_Chest,Starting_Armor_02_Gauntlets,Starting_Armor_03_Boots,2HS_Starting_Basic");
		$this->resp->run();
	}

	function UpdateCharacter5Xbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function UpdateAccount8Xbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetActiveWarChallengeXbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetWarRewardsXbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetStoreOffersXbox360()
	{
		$res = $this->resp->add_result(); 

		// probably does nothing, but we're not returning any data and it doesn't like it if there's not a Result.
		$res->add_attribute("Id","Starting_Armor_01_Gauntlets");
		$res->add_attribute("SoulScalar",1);
		$res->add_attribute("Type","HANDS");

		$this->resp->run();
	}

	function GetStoreItemsXbox360()
	{

		//Add more results for more items in the list
		$res = $this->resp->add_result();

		//Some test item data, should probably pull this from a db or something in the future.
		//TODO: Reverse Item names and types.
		$res->add_attribute("Name","Starting_Armor_01_Gauntlets");
		$res->add_attribute("Souls",0);
		$res->add_attribute("Type","HANDS");

		$this->resp->run();
	}

	function GetPlayerItems1Xbox360() // PlayerSpecific Requires XUID
	{
		//TODO: Implement database functionality to actually store player items and return here!
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function ResolveConsumableGiftTimersClient() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerConsumables1Xbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetDepositBoxesXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerAbilitiesXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetCustomizerItemsXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetStoreCustomizerItemsXbox360()
	{
		$res = $this->resp->add_result();

		//Some test item data, should probably pull this from a db or something in the future.
		//TODO: Reverse Item names and types.
		$res->add_attribute("Name","Starting_Armor_01_Gauntlets");
		$res->add_attribute("Souls",0);
		$res->add_attribute("Type","HANDS");

		$this->resp->run();
	}

	function GetPlayerBossesForCreatorXbox360() // Possibly Player specific.
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetContentionPoints2Xbox360() // Non-Player Specific Should be filled.
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetContentionPointTitlesXbox360() // Player specific sends XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetRegionsXbox360()
	{
		//TODO: Reverse where the data gets stored in this response to determine if this is accurate.
		$res_region1 = $this->resp->add_result();
		$res_region1->add_attribute("Id",0);
		$res_region1->add_attribute("Name","REGION_DEMO");
		
		$res_region2 = $this->resp->add_result();
		$res_region2->add_attribute("Id",1);
		$res_region2->add_attribute("Name","REGION_HUB");
		
		$res_region3 = $this->resp->add_result();
		$res_region3->add_attribute("Id",2);
		$res_region3->add_attribute("Name","REGION_NONE");

		$res_region4 = $this->resp->add_result();
		$res_region4->add_attribute("Id",3);
		$res_region4->add_attribute("Name","REGION_SWAMPLANDS");

		$res_region5 = $this->resp->add_result();
		$res_region5->add_attribute("Id",4);
		$res_region5->add_attribute("Name","REGION_BADLANDS");

		$res_region6 = $this->resp->add_result();
		$res_region6->add_attribute("Id",5);
		$res_region6->add_attribute("Name","REGION_HIGHLANDS");

		$this->resp->run();
	}

	function GetLevelsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		
		$res = $this->resp->add_result();
		$res->add_attribute("Id",0);
		$res->add_attribute("RegionId",1);
		$res->add_attribute("Seed",1);
		$res->add_attribute("Name","bl_01_dune_foothills");

		$this->resp->run();
	}

	function GetRemoteAccountsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results

		$res = $this->resp->add_result();
		$res->add_attribute("XUID",$this->xuid);
		$res->add_attribute("SteamId",$this->xuid);
		$res->add_attribute("SteamOfferId",-1);
		$res->add_attribute('SteamOrderId',-1);
		$res->add_attribute("MarketplaceState",-1);
		$res->add_attribute("CharacterID",-1);
		$res->add_attribute("HideHelmet", 0);
		$res->add_attribute("PendingSouls",0);
		$res->add_attribute("SystemSouls",0);
		$res->add_attribute("ContentionPointSouls",0);
		$res->add_attribute("WarChallengeSouls",0);
		$res->add_attribute("SoulGift",-1);
		$res->add_attribute("SoulUpdateId",-1);
		$res->add_attribute("BossGotKill","false");
		$res->add_attribute("Souls",0);
		$res->add_attribute("AscState",-1);
		$res->add_attribute("Achievements",0);
		$res->add_attribute("CharXp",-1);
		$res->add_attribute("CharXpAtStart",-1);
		$res->add_attribute("CharXpAtAsc",-1);
		$res->add_attribute("CharXpAsync",-1);
		$res->add_attribute("CharLevelCap",-1);
		$res->add_attribute("AscLevelReqInc",-1);
		$res->add_attribute("TranscCount",-1);
		$res->add_attribute("AscCountLight",-1);
		$res->add_attribute("AscCountDark",-1);
		$res->add_attribute("AscCountVoid",-1);
		$res->add_attribute("WarXp",-1);
		$res->add_attribute("WarXpAsync",-1);
		$res->add_attribute("WarXpLight",-1);
		$res->add_attribute("WarXpDark",-1);
		$res->add_attribute("WarXpVoid",-1);
		$res->add_attribute("GameTime",-1);
		$res->add_attribute("OfflineTime",-1);
		$res->add_attribute("ContentVersion","1.2.3"); // TODO: Verify how this is used.
		$res->add_attribute("SessionId",-1); // TODO: Generate randomly and store some where.
		$res->add_attribute("Banned",0);
		$this->resp->run();

	}

	function GetPlayerBossesTopXbox360() // seems to expect XUID specific data
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetSoulPackOffersSteam()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerItemsByIdXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerAbilitiesByIdXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesAbilitiesXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesItemsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetWarStatsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results		
		/*$res = $this->resp->add_result();
		$res->add_attribute("WarXpLight",0);
		$res->add_attribute("WarXpDark",0);
		$res->add_attribute("CharCountLight",0);
		$res->add_attribute("CharCountDark",0);
		$res->add_attribute("CharCountVoid",0);
		$res->add_attribute("BossCountLight",0);
		$res->add_attribute("BossCountDark",0);
		$res->add_attribute("BossCountVoid",0);
		$res->add_attribute("ChallengeWinsLight",0);
		$res->add_attribute("ChallengeWinsDark",0);
		$res->add_attribute("ChallengeWinsVoid",0);*/
		$this->resp->run();
	}

	function GetRecentMsgsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function __construct($params)
	{
		if(isset($params["xuid"]))
			$this->xuid = $params["xuid"];

		if(isset($params['target']))
			$this->target = $params["target"];
		
		$this->sproc = $params["sproc"];

		$this->resp = new Response($this->sproc);
	}
}


?>