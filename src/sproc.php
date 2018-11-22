<?php
require_once("response_xml.php");
require_once("dbconf.php");

class Sproc {
	private $sproc = "";
	private $xuid = 0;
	private $steamid = 0;
	private $target = 0;
	private $resp = null;
	private $mysql_conn = null;

	//AddSouls3Xbox360
	//UpdatePlayerItem3Xbox360
	//BuyCustomizerItemXbox360
	//ReRollStoreXbox360
	//EnterPurgatoryXbox360
	//AddPlayerConsumableXbox360
	//UpgradeItemXbox360
	//AddPlayerAbilityXbox360

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


	function AddPlayerConsumableXbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("OK",1);
		$this->resp->run();
	}

	function UpgradeItemXbox360()
	{

		/*
			Response:
				Level
		*/
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function AddPlayerAbilityXbox360()
	{
		/*
			Request: /game/sproc?sproc=AddPlayerAbilityXbox360&xuid=123457&sessionId=22&name=Dark_Fireball
			Potential response must contain: Id, Upgrades, Keep, Name 
		*/
		//This works for now, ID is most likely unique to the server side in some way.
		$res = $this->resp->add_result(); 
		$res->add_attribute("Id","99");
		$res->add_attribute("Upgrades","0");
		$res->add_attribute("Keep","1");
		$res->add_attribute("Name",$_GET['name']);
		$this->resp->run();

	}

	function ReRollStoreXbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function BuyCustomizerItemXbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function UpdatePlayerItem3Xbox360()
	{
		/* The handler for this function is quite strange, we'll just try an JSON handler "OK" for now */
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function AddSouls3Xbox360()
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function CreateCharacter4Xbox360()
	{
		$alignment = mysql_real_escape_string($_GET['align']);
		$name = mysql_real_escape_string(base64_decode($_GET['name']));
		$bodyparts = mysql_real_escape_string($_GET['bodyParts']);
		$equipResIds = mysql_real_escape_string($_GET['equipResIds']);
		$skinColor = mysql_real_escape_string($_GET['skinColor']);
		$hairColor = mysql_real_escape_string($_GET['hairColor']);
		$equipNames = mysql_real_escape_string($_GET['equipNames']);

		$query = "INSERT INTO characters (SteamID,Alignment,Name,bodyParts,EquipmentIds,SkinColor,hairColor,Equipment) VALUES ('$this->steamid','$alignment','$name','$bodyparts','$equipResIds','$skinColor','$hairColor','$equipNames');";
		$q = mysql_query($query) or die(error_log(" (insert) Ascender API encountered an MySQL error! Error: ".mysql_error(). " query: ".$query));
		$character_id = mysql_insert_id();

		$uq = mysql_query("UPDATE accounts SET CharacterID='$character_id' WHERE SteamId='$this->steamid'") or die(error_log("(update) Ascender API encountered a MySQL error! error: ".mysql_error()));


		$res = $this->resp->add_result();
		$res->add_attribute("Id",1);
		$res->add_attribute("CreatorXuid",$_GET['xuid']);
		$res->add_attribute("Alignment",$_GET['align']);
		$res->add_attribute("Name",$_GET['name']);
		$res->add_attribute("BodyParts",$_GET['bodyParts']);
		$res->add_attribute("EquipmentIds",$_GET['equipResIds']);
		$res->add_attribute("AbilityIds","0");
		$res->add_attribute("MetaWarIds","0");
		$res->add_attribute("SkinColor",$_GET['skinColor']);
		$res->add_attribute("HairColor",$_GET['hairColor']);
		$res->add_attribute("Equipment",$_GET['equipNames']);
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

		/*
			Response:
			Id
			Name
			SoulScalar
			Type
		*/


		// probably does nothing, but we're not returning any data and it doesn't like it if there's not a Result.
		$res->add_attribute("Id","Starting_Armor_01_Gauntlets");
		$res->add_attribute("SoulScalar",1);
		$res->add_attribute("Type","HANDS");

		$this->resp->run();
	}

	function AddStoreItem($name,$souls = "1",$type = "Hands")
	{
		$item = $this->resp->add_result();
		$item->add_attribute("Name",$name);
		$item->add_attribute("Souls",$souls);
		$item->add_attribute("Type",$type);

	}

	function GetStoreItemsXbox360()
	{

		/* Response:
			Name
			Souls
			Type
		*/

		//Add more results for more items in the list
		/*
				Types:
					HEAD
					BODY
					HANDS
					FEET
					WEAPON
		*/

		$this->AddStoreItem("1H_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("2H_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("1H_starting_Uncommon","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Uncommon","1","WEAPON");
		$this->AddStoreITem("2H_Starting_Uncommon","1","WEAPON");
		$this->AddStoreItem("1H_starting_Store","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Store","1","WEAPON");
		$this->AddStoreItem("2H_Starting_Store","1","WEAPON");
		$this->AddStoreItem("Starting_Armor_01_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_01_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_01_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_01_Helmet","1","HEAD");
		$this->AddStoreItem("Starting_Armor_02_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_02_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_02_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_02_Helmet","1","HEAD");
		$this->AddStoreItem("Starting_Armor_03_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_03_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_03_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_03_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Dark01_Helmet_lvl1","1","HEAD");
		$this->AddStoreItem("Armor_Dark01_Chest_lvl1","1","BODY");
		$this->AddStoreItem("Armor_Dark01_Gauntlets_lvl1","1","HANDS");
		$this->AddStoreItem("demo_armor_boots_general_01","1","FEET");
		$this->AddStoreItem("Armor_Helmet_Void01","1","HEAD");
		$this->AddStoreItem("Armor_Void01","1","BODY");
		$this->AddStoreItem("Armor_Gauntlets_Void01","1","HANDS");
		$this->AddStoreItem("Armor_Boots_Void01","1","FEET");
		$this->AddStoreItem("Armor_Chain02_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Chain02_Chest","1","BODY");
		$this->AddStoreItem("Armor_Chain02_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Chain02_Boots","1","FEET");
		$this->AddStoreItem("Armor_Chain03_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Chain03_Chest","1","BODY");
		$this->AddStoreItem("Armor_Chain03_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Chain03_Boots","1","FEET");
		$this->AddStoreItem("Armor_Helmet_Void02","1","HEAD");
		$this->AddStoreItem("CaosPlateArmor","1","BODY");
		$this->AddStoreItem("Armor_Rust_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Rust_Boots","1","FEET");
		$this->AddStoreItem("Armor_Leather04_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Leather04_Chest","1","BODY");
		$this->AddStoreItem("Armor_Leather04_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Leather04_Boots","1","FEET");



		$this->resp->run();
		/*
		//Some test item data, should probably pull this from a db or something in the future.
		//TODO: Reverse Item names and types.
		$res->add_attribute("Name","Head15");
		$res->add_attribute("Souls",1);
		$res->add_attribute("Type","HANDS");*/

	}

	function GetPlayerItems1Xbox360() // PlayerSpecific Requires XUID
	{

		/*
			Response:
			Id
			Level
			Xuid
			Keep
			DurabilityLost
			ResIdx
			Name
			Rune0
			Rune1
			Rune2

		*/

		$query = "SELECT Equipment,EquipmentIds FROM characters WHERE SteamId='$this->steamid';";
		$q = mysql_query($query) or die("Ascend API had an MySQL error (GetPlayerItems1Xbox360) error: ".mysql_error());

		if(mysql_num_rows($q) > 0)
		{

			$row = mysql_fetch_object($q);

			$equipments = explode(",",$row->Equipment);
			$equipids = explode(",",$row->EquipmentIds);

			$index = 0;
			foreach($equipments as $equipment)
			{
				if(strlen($equipment) > 0)
				{	
					$res = $this->resp->add_result();

					$res->add_attribute("Id",mt_rand());
					$res->add_attribute("Name",$equipment);
					$res->add_attribute("Level","1");
					$res->add_attribute("Xuid",$this->steamid);
					$res->add_attribute("DruabilityLost","0");
					$res->add_attribute("ResIdx",$equipids[$index]);

				}
				$index++;
			}



		}

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

		/*
			Response
			Id
			Upgrades
			Keep
			Name
		*/
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetCustomizerItemsXbox360() // Player Specific Requires XUID
	{
		//Head01,NoHair,NoBeard,CaosBody,CaosHands,CaosFeet,
		$query = "SELECT bodyParts,Equipment FROM characters WHERE SteamId='$this->steamid';";
		$q = mysql_query($query) or die("Ascend API had an MySQL error (GetCustomizerItemsXbox360) error: ".mysql_error());

		if(mysql_num_rows($q) > 0)
		{

			$row = mysql_fetch_object($q);
			$items = explode(",",$row->bodyParts);
			$equipments = explode(",",$row->Equipment);

			foreach($items as $item)
			{

				if(strlen($item) > 0)
				{
					$res = $this->resp->add_result();
					$res->add_attribute("Name",$item);
				}
			}

			foreach($equipments as $equipment)
			{
				if(strlen($equipment) > 0)
				{
					$res = $this->resp->add_result();
					$res->add_attribute("Name",$equipment);
				}
			}



		}

		$this->resp->run();
	}


	function GetStoreCustomizerItemsXbox360()
	{

		/* Response:
			Name
			Souls
			Type
		*/

		for($i = 0;$i<21;$i++)
		{
			$num_padded = sprintf("%02d", $i);
			$this->AddStoreItem("Head$num_padded");
		}

		for($i = 0;$i<11;$i++)
		{
			$num_padded = sprintf("%02d", $i);
			$this->AddStoreItem("Hair$num_padded");
		}

		for($i = 0;$i<10;$i++)
		{
			$num_padded = sprintf("%02d", $i);
			$this->AddStoreItem("Beard$num_padded");
		}

		$this->AddStoreItem("1H_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("2H_Starting_Basic","1","WEAPON");
		$this->AddStoreItem("1H_starting_Uncommon","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Uncommon","1","WEAPON");
		$this->AddStoreITem("2H_Starting_Uncommon","1","WEAPON");
		$this->AddStoreItem("1H_starting_Store","1","WEAPON");
		$this->AddStoreItem("2HS_Starting_Store","1","WEAPON");
		$this->AddStoreItem("2H_Starting_Store","1","WEAPON");
		$this->AddStoreItem("Starting_Armor_01_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_01_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_01_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_01_Helmet","1","HEAD");
		$this->AddStoreItem("Starting_Armor_02_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_02_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_02_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_02_Helmet","1","HEAD");
		$this->AddStoreItem("Starting_Armor_03_Chest","1","BODY");
		$this->AddStoreItem("Starting_Armor_03_Boots","1","FEET");
		$this->AddStoreItem("Starting_Armor_03_Gauntlets","1","HANDS");
		$this->AddStoreItem("Starting_Armor_03_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Dark01_Helmet_lvl1","1","HEAD");
		$this->AddStoreItem("Armor_Dark01_Chest_lvl1","1","BODY");
		$this->AddStoreItem("Armor_Dark01_Gauntlets_lvl1","1","HANDS");
		$this->AddStoreItem("demo_armor_boots_general_01","1","FEET");
		$this->AddStoreItem("Armor_Helmet_Void01","1","HEAD");
		$this->AddStoreItem("Armor_Void01","1","BODY");
		$this->AddStoreItem("Armor_Gauntlets_Void01","1","HANDS");
		$this->AddStoreItem("Armor_Boots_Void01","1","FEET");
		$this->AddStoreItem("Armor_Chain02_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Chain02_Chest","1","BODY");
		$this->AddStoreItem("Armor_Chain02_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Chain02_Boots","1","FEET");
		$this->AddStoreItem("Armor_Chain03_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Chain03_Chest","1","BODY");
		$this->AddStoreItem("Armor_Chain03_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Chain03_Boots","1","FEET");
		$this->AddStoreItem("Armor_Helmet_Void02","1","HEAD");
		$this->AddStoreItem("CaosPlateArmor","1","BODY");
		$this->AddStoreItem("Armor_Rust_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Rust_Boots","1","FEET");
		$this->AddStoreItem("Armor_Leather04_Helmet","1","HEAD");
		$this->AddStoreItem("Armor_Leather04_Chest","1","BODY");
		$this->AddStoreItem("Armor_Leather04_Gauntlets","1","HANDS");
		$this->AddStoreItem("Armor_Leather04_Boots","1","FEET");
		$this->AddStoreItem("NoHair");
		$this->AddStoreItem("NoBeard");
		$this->AddStoreItem("CustomizerColors");
		$this->AddStoreItem("CustomizerColor_Skin1");
		$this->AddStoreItem("CustomizerColor_Skin9");
		$this->AddStoreItem("CustomizerColor_Brown");
		$this->AddStoreItem("CustomizerColor_Brown_Dark");
		$this->AddStoreItem("CustomizerColor_Brown_Dark2");
		$this->AddStoreItem("CustomizerColor_Skin2");
		$this->AddStoreItem("CustomizerColor_Skin3");
		$this->AddStoreItem("CustomizerColor_Skin4");
		$this->AddStoreItem("CustomizerColor_Skin5");
		$this->AddStoreItem("CustomizerColor_Skin6");
		$this->AddStoreItem("CustomizerColor_Skin7");
		$this->AddStoreItem("CustomizerColor_Skin8");
		$this->AddStoreItem("CustomizerColor_White");
		$this->AddStoreItem("CustomizerColor_Purple");
		$this->AddStoreItem("CustomizerColor_Green_Light");
		$this->AddStoreItem("CustomizerColor_Orange");
		$this->AddStoreItem("CustomizerColor_Blue_Dark");
		$this->AddStoreItem("CustomizerColor_Green_Dark");
		$this->AddStoreItem("CustomizerColor_Purple_Dark");
		$this->AddStoreItem("CustomizerColor_Red_Dark");
		$this->AddStoreItem("CustomizerColor_BlueGreen");
		$this->AddStoreItem("CustomizerColor_Green");
		$this->AddStoreItem("CustomizerColor_Blue");
		$this->AddStoreItem("CustomizerColor_Teal");
		$this->AddStoreItem("CustomizerColor_Blue_Light2");
		$this->AddStoreItem("CustomizerColor_Red");
		$this->AddStoreItem("CustomizerColor_Green2");
		$this->AddStoreItem("CustomizerColor_Yellow");
		$this->AddStoreItem("CustomizerColor_Orange_Dark");
		$this->AddStoreItem("CustomizerColor_Purple_Light");
		$this->AddStoreItem("CustomizerColor_Blue_Light");
		$this->AddStoreItem("CustomizerColor_Black");


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
		$this->mysql_conn = mysql_connect(db_host,db_user,db_pass) or die(error_log("AscenderAPI had a mysql error connecting! - ".mysql_error()));
		mysql_select_db("ascender");

		if(isset($params["xuid"]))
			$this->steamid = mysql_real_escape_string($params["xuid"]);

		if(isset($params['target']))
			$this->target = mysql_real_escape_string($params["target"]);
		
		$this->sproc = $params["sproc"];

		$this->resp = new Response($this->sproc);


	}
}


?>