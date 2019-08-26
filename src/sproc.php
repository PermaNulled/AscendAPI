<?php
require_once("response_xml.php");
require_once("dbconf.php");
require_once("store_popjson.php");

class Sproc {
	private $sproc = "";
	private $xuid = 0;
	private $steamid = 0;
	private $target = 0;
	private $resp = null;
	private $mysql_conn = null;


	//TODO: Implement...
	//GetActiveWarChallengeXbox360 - not fully implemented
	// /game/sproc?sproc=GetActiveWarChallengeXbox360

	//GetWarRewardsXbox360 - not fully implemented
	// /game/sproc?sproc=GetWarRewardsXbox360&user=76561198009394515

	//GetStoreOffersXbox360 - not fully implemented
	// /game/sproc?sproc=GetStoreOffersXbox360

	//GetWarStatsXbox360 - not fully implemented
	// /game/sproc?sproc=GetWarStatsXbox360

	//GetPlayerBossesTopXbox360 - not fully implemented
	// /game/sproc?sproc=GetPlayerBossesTopXbox360&lightXuid=76561198168415956&darkXuid=76561198085826254&voidXuid=76561198085826254

	//GetRecentMsgsXbox360
	//GET /game/sproc?sproc=GetRecentMsgsXbox360&target=76561198009394515


	//ClaimTutorialBossXbox360
	//GET /game/sproc?sproc=ClaimTutorialBossXbox360&xuid=76561198046797610&level=11&align=2 HTTP/1.1", upstream: "fastcgi://unix:/run/php/php5.6-fpm.sock:", host: "new.thedefaced.org:80"

	//CapContentionPointXbox360
	//GET /game/sproc?sproc=CapContentionPointXbox360&xuid=76561198080432945&sessionId=1046777535&pointId=2&alignment=2 
	//GET /game/sproc?sproc=CapContentionPointXbox360&xuid=76561198009394515&sessionId=473740457&pointId=2&alignment=3

	//GetTotemByLevelXbox360 - PRIORITY
	//GET /game/sproc?sproc=GetTotemByLevelXbox360&targetXuid=76561198046797610&levelId=74 HTTP/1.1", upstream: "fastcgi://unix:/run/php/php5.6-fpm.sock:", host: "new.thedefaced.org:80"

	//GetTotemByLevelAndSeedXbox360
	//GET /game/sproc?sproc=GetTotemByLevelAndSeedXbox360&targetXuid=76561198058111756&levelId=33&levelSeed=2082596091
	//GET /game/sproc?sproc=GetTotemByLevelAndSeedXbox360&targetXuid=76561198009394515&levelId=6&levelSeed=458952197
	

	//TODO: Port to use PDO instead of standard MySQL bullshit that's been deprecated.
	//TODO: Make generic error function for logging.
	function run()
	{

		$method = $this->sproc;
		if (method_exists($this, $method))
     	{
         	$this->$method();
     	}else{
     		error_log("[ERROR - ASCEND API] SPROC Attempted to access invalid method! - Sproc: ".$this->sproc);
     		// If API isn't valid just return nothing
     		//$this->resp->run();

     		header('Content-type: text/json');
     		print('[ { "Result": "OK" } ]'); 

			$length = ob_get_length(); 
			header("Content-Length: $length");
     	}

	}


	//EnterPurgatoryXbox360
	//GET /game/sproc?sproc=EnterPurgatoryXbox360&xuid=76561198046797610&sessionId=1951473221
	function EnterPurgatoryXbox360()
	{
		//Generic response, could not find any handling code for this.
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	//AddDynamicLootItem1Xbox360
	//GET /game/sproc?sproc=AddDynamicLootItem1Xbox360&xuid=76561198046797610&sessionId=1951473221&chestId=33&name=Void_Store_L15_S_Med&resIdx=135 HTTP/1.1", upstream: "fastcgi://unix:/run/php/
	//AddDynamicLootItem1Xbox360&xuid=76561198009394515&sessionId=410562881&chestId=72&name=Armor_Component_179&resIdx=263
	function AddDynamicLootItem1Xbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$chestId = (int)$_GET['chestId'];
		$name = mysql_real_escape_string(urldecode($_GET['name']));
		$resIdx = (int)$_GET['resIdx'];

		$cidq = "SELECT CharacterID FROM accounts WHERE SteamId='".$steamID."';" or die (error_log("Ascender API encountered a MySQL error: ".mysql_error()));
		$hcid = mysql_query($cidq);

		if(mysql_num_rows($hcid) > 0)
		{
			$cido = mysql_fetch_object($hcid);

			$iiq = "INSERT INTO items (SteamId,CharacterId,ResIdx,Name) VALUES ($steamID,$cido->CharacterID,$resIdx,'$name')";
			$iir = mysql_query($iiq) or die(error_log("Ascender API MySQL error: ".mysql_error()));
			$id = mysql_insert_id();
		}

		$res = $this->resp->add_result();
		$res->add_attribute("Xuid",$this->steamid);
		$res->add_attribute("Id",$id);
		$res->add_attribute("Level",1);
		$res->add_attribute("Keep",1);
		$res->add_attribute("DurabilityLost",0);
		$res->add_attribute("ResIdx",$resIdx);
		$res->add_attribute("Name",$name);
		$res->add_attribute("Rune0",0);
		$res->add_attribute("Rune1",0);
		$res->add_attribute("Rune2",0);
		$this->resp->run();
	}

	//AddDynamicLootSouls2Xbox360
	///game/sproc?sproc=AddDynamicLootSouls2Xbox360&xuid=76561198080432945&sessionId=1046777535&souls=51&id=55 
	//AddDynamicLootSouls2Xbox360&xuid=76561198009394515&sessionId=410562881&souls=147&id=54
	function AddDynamicLootSouls2Xbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$souls = (int)$_GET['souls'];

		//Not sure how id is used in the context of this... will implement later.
		$id = (int)$_GET['id'];

		$this->AddAccountSouls($souls);

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	
	//AddLootSouls2Xbox360
	// /game/sproc?sproc=AddLootSouls2Xbox360&xuid=76561198009394515&sessionId=410562881&souls=154&id=23
	// /game/sproc?sproc=AddLootSouls2Xbox360&xuid=76561198009394515&sessionId=410562881&souls=104&id=27
	function AddLootSouls2Xbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$souls = (int)$_GET['souls'];

		//Not sure how id is used in the context of this... will implement later.
		$id = (int)$_GET['id'];

		$this->AddAccountSouls($souls);

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}
	//SellConsumableXbox360
	//GET /game/sproc?sproc=SellConsumableXbox360&xuid=76561198046797610&sessionId=956665258&id=146&souls=50
	function SellConsumableXbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$id = (int)$_GET['id'];
		$souls = (int)$_GET['souls'];

		$rcq = "DELETE FROM consumables WHERE SteamId='$steamID AND Id='$id';";
		$rcr = mysql_query($rcq) or die(error_log("Ascender API MySQL error: ".mysql_error()));

		if($rcr)
		{
			$this->AddAccountSouls($souls);
		}

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	//SellItemXbox360
	//GET /game/sproc?sproc=SellItemXbox360&xuid=76561198046797610&sessionId=956665258&id=522&souls=21&charEquipmentIds=527%2C0%2C0%2C526%2C528%2C525%2C524
	function SellItemXbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$id = (int)$_GET['id'];
		$souls = (int)$_GET['souls'];

		//Assuming this is provided to prevent selling of equipped items
		//TODO: Implement with this.
		$charEquipmentIds = mysql_real_escape_string(urldecode($_GET['charEquipmentIds']));

		$riq = "DELETE FROM items WHERE SteamId='$steamID' AND Id='$id';";
		$rir = mysql_query($riq) or die(error_log("Ascender API MySQL error: ".mysql_error()));

		if($rir)
		{
			$this->AddAccountSouls($souls);
		}

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	//AddLootItem1Xbox360
	//GET /game/sproc?sproc=AddLootItem1Xbox360&xuid=76561198046797610&sessionId=1359719260&chestId=26&name=Armor_leathermail_var_02&resIdx=203
	// /game/sproc?sproc=AddLootItem1Xbox360&xuid=76561198046797610&sessionId=1476977440&chestId=26&name=Skull_Blade_of_Ice&resIdx=71
	// NEXT CALL: /game/sproc?sproc=UpdateAccount8Xbox360&xuid=76561198046797610&sessionId=1476977440&charXp=121005&warXp=0&gameTime=33173&levelId=&hideHelmet=0
	//TODO: Find a way to get the currently logged in character under the session.
	function AddLootItem1Xbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$chestId = (int)$_GET['chestId'];
		$name = mysql_real_escape_string(urldecode($_GET['name']));
		$resIdx = (int)$_GET['resIdx'];

		$cidq = "SELECT CharacterID FROM accounts WHERE SteamId='".$steamID."';" or die (error_log("Ascender API encountered a MySQL error: ".mysql_error()));
		$hcid = mysql_query($cidq);

		if(mysql_num_rows($hcid) > 0)
		{
			$cido = mysql_fetch_object($hcid);

			$iiq = "INSERT INTO items (SteamId,CharacterId,ResIdx,Name) VALUES ($steamID,$cido->CharacterID,$resIdx,'$name')";
			$iir = mysql_query($iiq) or die(error_log("Ascender API MySQL error: ".mysql_error()));
			$id = mysql_insert_id();
		}

		$res = $this->resp->add_result();
		$res->add_attribute("Xuid",$this->steamid);
		$res->add_attribute("Id",$id);
		$res->add_attribute("Level",1);
		$res->add_attribute("Keep",1);
		$res->add_attribute("DurabilityLost",0);
		$res->add_attribute("ResIdx",$resIdx);
		$res->add_attribute("Name",$name);
		$res->add_attribute("Rune0",0);
		$res->add_attribute("Rune1",0);
		$res->add_attribute("Rune2",0);
		$this->resp->run();
	}

	//AddLootConsumableXbox360
	//GET /game/sproc?sproc=AddLootConsumableXbox360&xuid=76561198046797610&sessionId=413852839&chestId=19&name=Storm_Vial&type=3&count=1 
	//Looking at the binary there doesn't seem to be a response to this.
	function AddLootConsumableXbox360()
	{
		$steamID = $this->steamid;
		$sessionId = (int)$_GET['sessionId'];
		$chestId = (int)$_GET['chestId'];
		$name = mysql_real_escape_string(urldecode($_GET['name']));
		$type = (int)$_GET['type'];
		$count = (int)$_GET['count'];

		$icq = "INSERT INTO consumables (SteamId,Name,Count,Keep,Type) VALUES ($steamID,'$name',$type,$count)";
		$icr = mysql_query($icq) or die(error_log("Ascender API MySQL error: ".mysql_error()));


		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}



	function GetLevelItems1Xbox360()
	{
		$levelId = (int)$_GET['levelId'];
		$liq = "SELECT * FROM LevelItems WHERE levelId='$levelId';";
		$hli = mysql_query($liq) or die(error_log("Ascender API MySQL error: ".mysql_error()));

		while($row = mysql_fetch_object($hli))
		{
			$res = $this->resp->add_result();
			$res->add_attribute("Id",$row->Id);
			$res->add_attribute("LevelId",$row->levelId);
			$res->add_attribute("ItemType",$row->itemType);
			$res->add_attribute("XOffset",$row->X);
			$res->add_attribute("YOffset",$row->Y);
			$res->add_attribute("Unlocked",$row->Unlocked);
			$res->add_attribute("Name",$row->Name);
		}

		$this->resp->run();

	}

	///game/sproc?sproc=GetDynamicLevelItems2Xbox360&xuid=76561198058111756&levelId=33&levelSeed=208259609
	// This function is used to determine items for the specific user.
	// Part of this is checking if the user has unlocked these items yet.
	// For now we'll return dummy data.

	function GetDynamicLevelItems2Xbox360()
	{
		$levelId = (int)$_GET['levelId'];
		$levelSeed = (int)$_GET['levelSeed'];
		$q = "SELECT * FROM DynamicLevelItems WHERE levelId='$levelId' AND levelSeed='$levelSeed';";
		$hq = mysql_query($q) or die(error_log('Ascender API encountered a MySQL error: '.mysql_error()));


		if(mysql_num_rows($hq) > 0)
		{
			while($row = mysql_fetch_object($hq))
			{
				$res = $this->resp->add_result();
				$res->add_attribute("Id",$row->Id);
				$res->add_attribute("LevelId",$row->levelId);
				$res->add_attribute("LevelSeed",$row->levelSeed);
				$res->add_attribute('Floor',$row->floor);
				$res->add_attribute('Y',$row->y);
				$res->add_attribute('X',$row->x);
				$res->add_attribute('ItemType',$row->itemType);
				$res->add_attribute('Unlocked',"0");
			}
	
		}else{
			$res = $this->resp->add_result();
			$res->add_attribute("Id","0");
			$res->add_attribute("LevelId","-1");
		}

		$this->resp->run();
	}

	///game/sproc?sproc=GetDynamicLevelItems2Xbox360&xuid=76561198009394515&levelId=6&levelSeed=458952197
	// Not really sure how this works.
	// Added to it using debug client previously, the seeds are never random which is odd.
	function AddDynamicLevelItemXbox360()
	{
		$levelId = (int)$_GET['levelId'];
		$levelSeed =(int)$_GET['levelSeed'];
		$floor = (int)$_GET['floor'];
		$x = (int)$_GET['x'];
		$y = (int)$_GET['y'];
		$itemType = (int)$_GET['itemType'];

		$q = "SELECT * FROM DynamicLevelItems WHERE levelId='$levelId' AND x='$x' AND y='$y';";
		$hq = mysql_query($q) or die(error_log("Ascender API encountered a MySQL error: ".mysql_error()));
		if(mysql_num_rows($hq) == 0)
		{
			$adliq = "INSERT INTO DynamicLevelItems (levelId,levelSeed,floor,x,y,ItemType) VALUES ('$levelId','$levelSeed','$floor','$x','$y','$itemType');";
			$hadli = mysql_query($adliq) or die(error_log("Ascender API encountered MySQL error: ".mysql_error()));
			$id = mysql_insert_id();
			$res = $this->resp->add_result();
			$res->add_attribute("Id",$id);
		}

		$this->resp->run();
	}

	function AddLevelItemAdmin()
	{
		$levelId = (int)$_GET['levelId'];
		$name = mysql_real_escape_string(urldecode($_GET['name']));
		$x = (int)$_GET['x'];
		$y = (int)$_GET['y'];
		$itemType = (int)$_GET['itemType'];

		$q = "SELECT * FROM LevelItems WHERE X='$x' AND Y='$y' AND levelId='$levelId';";
		$hq = mysql_query($q);
		if(mysql_num_rows($hq) == 0)
		{
			$aliaq = "INSERT INTO LevelItems (levelId,Name,X,Y,itemType) VALUES ('$levelId','$name','$x','$y','$itemType');";
			$halia = mysql_query($aliaq) or die(error_log("Ascender API encountered an MySQL error: ".mysql_error()));
		}

		header('Content-type: text/json');
     	print('[ { "Result": "OK" } ]'); 

		$length = ob_get_length(); 
		header("Content-Length: $length");
	}

	function UpdateLevelAdmin()
	{
     		header('Content-type: text/json');
     		print('[ { "Result": "OK" }, {"Id": "1"} ]'); 

			$length = ob_get_length(); 
			header("Content-Length: $length");
	}

	function AddAccountSouls($souls)
	{
		$asq = "UPDATE accounts SET Souls=(Souls+$souls) WHERE SteamId='$this->steamid';";
		mysql_query($asq) or die(error_log("Ascender API - AddAccountSouls() - MySQL Error Occured: ".mysql_error()));

	}

	function SubtractAccountSouls($souls)
	{
		$asq = "UPDATE accounts SET Souls=(Souls-$souls) WHERE SteamId='$this->steamid';";
		mysql_query($asq) or die(error_log("Ascender API - SubtractAccountSouls() - MySQL Error Occured: ".mysql_error()));
	}

	function GetRecentMsgsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function BuyItem1Xbox360()
	{
		$name = mysql_real_escape_string($_GET['name']);
		$souls = (int)$_GET['souls'];
		$offerId = (int)$_GET['offerId'];
		$resIdx = (int)$_GET['resIdx'];

		//TODO: Find currently logged in character, ascending will probably break this code.
		$cidq = "SELECT CharacterID FROM accounts WHERE SteamId='".$this->steamid."';" or die (error_log("Ascender API encountered a MySQL error: ".mysql_error()));
		$hcid = mysql_query($cidq);

		if(mysql_num_rows($hcid) > 0)
		{
			$cido = mysql_fetch_object($hcid);

			$biq  = "INSERT INTO items (SteamId,CharacterId,ResIdx,Name) VALUES ('$this->steamid','$cido->CharacterID','$resIdx','$name');";
			$hbi = mysql_query($biq) or die(error_log("Ascender API encountered a MySQL error: ".mysql_error()));

			$item_id =  mysql_insert_id();

			$res = $this->resp->add_result();
			$res->add_attribute("Xuid",$this->steamid);
			$res->add_attribute("Id",$item_id);
			$res->add_attribute("Level",1);
			$res->add_attribute("Keep",1);
			$res->add_attribute("DurabilityLost",0);
			$res->add_attribute("ResIdx",$resIdx);
			$res->add_attribute("Name",$name);

			$this->SubtractAccountSouls($souls);

			$this->resp->run();
		}
		else
			error_log("Ascender API BuyItem1Xbox360() - Could not find SteamID $this->steamid in Database!");
	}

	function BuyConsumablesXbox360()
	{
		$name = mysql_real_escape_string($_GET['name']);
		$qty = (int)$_GET['qty'];
		$type = (int)$_GET['type'];
		$souls = (int)$_GET['souls'];

		$bcq = "SELECT * FROM consumables WHERE SteamId='$this->steamid' AND Name='$name';";
		$hbcq = mysql_query($bcq) or die(error_log("Ascencder API - BuyConsumablesXbox360() - MySQL error occured - Error: ".mysql_error()));

		if(mysql_num_rows($hbcq) > 0)
		{
			$bcuq = "UPDATE consumables SET Count=($qty+Count) WHERE SteamId='$this->steamid' AND Name='$name';";
			mysql_query($bcuq) or die(error_log("Ascender API - BuyConsumablesXbox360() - bcuq - MySQL error occured - Error: ".mysql_error()));

		}else{
			$bciq = "INSERT INTO consumables (SteamId,Name,Count,Type) VALUES ('$this->steamid','$name','$qty','$type');";
			mysql_query($bciq) or die(error_log("Ascender API - BuyConsumablesXbox360() - bciq - MySQL error occured - Error: ".mysql_error()));
		}

		$this->SubtractAccountSouls($souls);

		$this->resp->run();
	}

	function GetPlayerConsumables1Xbox360()
	{
		$pcq = "SELECT * FROM consumables WHERE SteamId='$this->steamid';";
		$hpcq = mysql_query($pcq) or die(error_log("Ascender API - GetPlayerConsumables1Xbox360() - MySQL error occured - Error: ".mysql_error()));
		
		if(mysql_num_rows($hpcq) > 0)
		{
			while($row = mysql_fetch_object($hpcq))
			{
				$res = $this->resp->add_result();
				$res->add_attribute("Id",$row->Id);
				$res->add_attribute("Name",$row->Name);
				$res->add_attribute("Type",$row->Type);
				$res->add_attribute("Count",$row->Count);
				$res->add_attribute("Keep",$row->Keep);
			}
		}

		$this->resp->run();
	}

	function AddPlayerConsumableXbox360()
	{
		$name = mysql_real_escape_string($_GET['name']);
		$type = (int)$_GET['type'];
		$count = (int)$_GET['count'];

		$acq = "INSERT INTO consumables (SteamId,Name,Count,Type) VALUES ('$this->steamid','$name','$count','$type');";
		$hac = mysql_query($acq) or die(error_log("Ascender API - AddPlayerConsumableXbox360() - MySQL error occured - Error: ".mysql_error()));
		
		$consumable_id = mysql_insert_id();

		$res = $this->resp->add_result();

		$res->add_attribute("Id",$consumable_id); // Unique random stored in the db.
		$res->add_attribute("Name",$_GET['name']);
		$res->add_attribute("Type",$_GET['type']);
		$res->add_attribute("Count",$_GET['count']);
		$res->add_attribute("Keep","1");

		$this->resp->run();
	}

	function UpgradeAbility1Xbox360()
	{
		$id = (int)$_GET['id'];
		$souls = (int)$_GET['souls'];
		$upgrades = (int)$_GET['upgrades'];

		$auq = "UPDATE abilities SET upgrades='$upgrades' WHERE Id='$id';";
		mysql_query($auq) or die(error_log("Ascender API - UpgradeAbility1Xbox360() - MySQL Error Occured - ERROR: ".mysql_error()));

		$this->SubtractAccountSouls($souls);

		$this->resp->run();
	}
	
	function AddPlayerAbilityXbox360()
	{
		$name = mysql_real_escape_string($_GET['name']);

		$aq = "INSERT INTO abilities (Steamid,Name) VALUES('$this->steamid','$name');";
		$haq = mysql_query($aq) or die(error_log("Ascender API - AddPlayerAbilityXbox360() - MySQL Error Occured - ERROR: ".mysql_error()));
		
		$ability_id = mysql_insert_id();

		$auq = "UPDATE characters SET AbilityIds=CONCAT(AbilityIds,',$ability_id') WHERE SteamId='$this->steamid';";
		mysql_query($auq) or die(error_log("Ascender API - AddPlayerAbilityXbox360() - MySQL Error Occured - ERROR: ".mysql_error()));

		$res = $this->resp->add_result();

		$res->add_attribute("Id",$ability_id);
		$res->add_attribute("Upgrades","0");
		$res->add_attribute("Keep","1");
		$res->add_attribute("Name",$_GET['name']);

		$this->resp->run();

	}

	function GetPlayerAbilitiesByIdXbox360()
	{
		error_log("Ascender API - GetPlayerAbilitiesByIdXbox36() ".print_r($_GET,true));
		$this->resp->run();
	}

	function GetPlayerAbilitiesXbox360() // Player Specific Requires XUID
	{
		$aq = "SELECT * FROM abilities WHERE SteamId='".$this->steamid."';";
		$haq = mysql_query($aq) or die("Ascender API GetPlayerAbilitiesXbox360() - MySQL Error - Error: ".mysql_error());
		if(mysql_num_rows($haq) > 0)
		{
			while($row = mysql_fetch_object($haq))
			{
				$res = $this->resp->add_result();
				$res->add_attribute("Id",$row->Id);
				$res->add_attribute("Upgrades",$row->Upgrades);
				$res->add_attribute("Keep",$row->Keep);
				$res->add_attribute("Name",$row->Name);
			}
		}

		$this->resp->run();
	}

	function ReRollStoreXbox360()
	{
		$souls = (int)$_GET['souls'];
		$lvl = (int)$_GET['lvl'];

		$this->SubtractAccountSouls($souls);

		$this->resp->run();
	}

	//TODO: Reduce souls properly.
	function BuyCustomizerItemXbox360()
	{
		$souls = (int)$_GET['souls'];
		$name = mysql_real_escape_string($_GET['name']);

		$this->SubtractAccountSouls($souls);

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function RepairItemXbox360()
	{
		$id = (int)$_GET['id'];
		$souls = (int)$_GET['souls'];

		$ri_q = "UPDATE items SET DurabilityLost='0' WHERE Id='$id';";
		$hri = mysql_query($ri_q) or die(error_log("Ascender API encountered an MySQL error: ".mysql_error()));

		$this->SubtractAccountSouls($souls);

		$this->resp->run();
	}

	function UpdatePlayerItem3Xbox360()
	{

		$id = (int)$_GET['id'];
		$durabilityLost = (int)$_GET['durabilityLost'];

		$upi_q = "UPDATE items SET DurabilityLost='$durabilityLost' WHERE Id='$id';";
		$hupi = mysql_query($upi_q) or die(error_log("Ascender API encountered an MySQL error: ".mysql_error()));

		$this->resp->run();
	}

	function AddSouls3Xbox360()
	{
		$souls = (int)$_GET['souls'];

		$this->AddAccountSouls($souls);

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
		$equipIds = mysql_real_escape_string($_GET['equipIds']);

		$query = "INSERT INTO characters (SteamID,Alignment,Name,bodyParts,EquipmentIds,SkinColor,hairColor,Equipment) VALUES ('$this->steamid','$alignment','$name','$bodyparts','$equipResIds','$skinColor','$hairColor','$equipNames');";
		$q = mysql_query($query) or die(error_log(" (insert) Ascender API encountered an MySQL error! Error: ".mysql_error(). " query: ".$query));
		$character_id = mysql_insert_id();

		$uq = mysql_query("UPDATE accounts SET CharacterID='$character_id' WHERE SteamId='$this->steamid'") or die(error_log("(update) Ascender API encountered a MySQL error! error: ".mysql_error()));

		$equip_names = explode(",",$equipNames);
		$equip_resids = explode(",",$equipResIds);

		$equipment_ids = "";

		$index = 0;
		foreach($equip_names as $equipment_name)
		{
			$equipment_resid = mysql_real_escape_string($equip_resids[$index]);
			$equipment_name = mysql_real_escape_string($equipment_name);
			$eiq = mysql_query("INSERT INTO items (CharacterID,SteamId,ResIdx,Name,Keep,Level) VALUES ('$character_id','$this->steamid','$equipment_resid','$equipment_name','1','1');") or die(error_log("(insert equipment) Ascender API Encounterd a MySQL Error! - Error: ".mysql_error()));

			$equipment_ids.="".mysql_insert_id().",";

			$index++;
		}

		$uqc = mysql_query("UPDATE characters SET EquipmentIds='".$equipment_ids."' WHERE CharacterID='".$character_id."';") or die(error_log("(update equip ids) Ascender API Encountered a MySQL error - Error:".mysql_error()));


		$res = $this->resp->add_result();
		$res->add_attribute("Id","$character_id");
		$res->add_attribute("CreatorXuid",$_GET['xuid']);
		$res->add_attribute("Alignment",$_GET['align']);
		$res->add_attribute("Name",$_GET['name']);
		$res->add_attribute("BodyParts",$_GET['bodyParts']);
		$res->add_attribute("EquipmentIds",$equipment_ids);
		$res->add_attribute("AbilityIds","0");
		$res->add_attribute("MetaWarIds","0");
		$res->add_attribute("SkinColor",$_GET['skinColor']);
		$res->add_attribute("HairColor",$_GET['hairColor']);
		$res->add_attribute("Equipment",$_GET['equipNames']);
		$this->resp->run();

	}

	function UpdateCharacter5Xbox360()
	{
		$id = (int)$_GET['id'];
		$align = (int)$_GET['align'];
		$equipmentIds = mysql_real_escape_string($_GET['equipmentIds']);
		$abilityIds = mysql_real_escape_string($_GET['abilityIds']);
		$metaWarIds = mysql_real_escape_string($_GET['metaWarIds']);

		$uc_q = "UPDATE characters SET Alignment='$align',EquipmentIds='$equipmentIds',AbilityIds='$abilityIds',MetaWarIds='$metaWarIds' WHERE CharacterID='$id';";
		$huc = mysql_query($uc_q) or die(error_log("Ascender API UpdateCharacter5Xbox360() - MySQL Error - Error: ".mysql_error()));

		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}


	function UpdateAccount8Xbox360()
	{
		$charXp = (int)$_GET['charXp'];
		$warXp = (int)$_GET['warXp'];
		$gameTime = (int)$_GET['gameTime'];
		$levelId = (int)$_GET['levelId'];
		$hideHelmet = (int)$_GET['hideHelmet'];


		$uaq = "UPDATE accounts SET CharXp='$charXp',WarXp='$warXp',GameTime='$gameTime',HideHelmet='$hideHelmet' WHERE SteamId='$this->steamid';";
		$hua = mysql_query($uaq) or die(error_log("Ascender API UpdateAccount8Xbox360() - MySQL Error - Error: ".mysql_error()));

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
		ob_start();

		header('Content-type: application/json');
		$item_pop = new ItemPopJson(false);
		$items = $item_pop->populate_store_items();
		ob_start();


		print json_encode($items);

		$length = ob_get_length(); 
		header("Content-Length: $length");
		ob_end_flush();

		exit;
	}


	function UpgradeItemXbox360()
	{
		$itemid = (int)$_GET['itemId'];
		$souls = (int)$_GET['souls'];
		$target_level = (int)$_GET['targetLevel'];
		$isArmor = (int)$_GET['isArmor'];

		$ui_q = "UPDATE items SET Level='$target_level' WHERE Id='$itemid';";
		$hui = mysql_query($ui_q) or die("Ascender API error - MySQL error: ".mysql_error());

		$res = $this->resp->add_result();
		$res->add_attribute("Level","$target_level");
		$this->resp->run();
	}

	function GetPlayerItems1Xbox360() 
	{
		$query = "SELECT * FROM items WHERE SteamId='$this->steamid';";
		$q  = mysql_query($query);
		if(mysql_num_rows($q) > 0)
		{
			while($row = mysql_fetch_object($q))
			{
				$res = $this->resp->add_result();
				$res->add_attribute("Id",$row->Id);
				$res->add_attribute("Level",$row->Level);
				$res->add_attribute("Xuid",$this->steamid);
				$res->add_attribute("Keep",$row->Keep);
				$res->add_attribute("DurabilityLost",$row->DurabilityLost);
				$res->add_attribute("ResIdx",$row->ResIdx);
				$res->add_attribute("Name",$row->Name);
				$res->add_attribute("Rune0",$row->Rune0);
				$res->add_attribute("Rune1",$row->Rune1);
				$res->add_attribute("Rune2",$row->Rune2);
			}
		}

		$this->resp->run();
	}


	function ResolveConsumableGiftTimersClient() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}


	function GetDepositBoxesXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		//Relates to the ascension
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetCustomizerItemsXbox360()
	{
		$query = "SELECT bodyParts FROM characters WHERE SteamId='$this->steamid';";
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

		}

		$this->resp->run();
	}


	function GetStoreCustomizerItemsXbox360()
	{
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
		$this->resp->run();
	}


	function AddContentionPoint($id,$LightCount,$DarkCount,$VoidCount,$Type,$LevelId,$Name,$pos)
	{
		$res = $this->resp->add_result();
		$res->add_attribute("Id",$id);
		$res->add_attribute("LightCount",$LightCount);
		$res->add_attribute("DarkCount",$DarkCount);
		$res->add_attribute("VoidCount",$VoidCount);
		$res->add_attribute("Type",$Type);
		$res->add_attribute("LevelId",$LevelId);
		$res->add_attribute("Name",$Name);
		$res->add_attribute("Position",$pos);
	}

	function GetContentionPoints2Xbox360() // Non-Player Specific Should be filled.
	{

		$content_q = "SELECT * FROM ContentionPoints;";
		$hcontent = mysql_query($content_q);

		if(mysql_num_rows($hcontent) > 0)
		{	
			while($row = mysql_fetch_object($hcontent))
			{
				$this->AddContentionPoint($row->Id,$row->LightCount,$row->DarkCount,$row->VoidCount,$row->Type,$row->LevelId,$row->Name,$row->Position);
			}

			$this->resp->run();
		}

	}

	function GetContentionPointTitlesXbox360() // Player specific sends XUID
	{
		/* 
			Response:
				PointId
				Xuid
				Alignment
				CapXuid
				CapBossId
		*/

		//TODO: Implement some database functionality, and return appropriate results
		//$res = $this->resp->add_result();
		//$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetRegionsXbox360()
	{
		$res_region1 = $this->resp->add_result();
		$res_region1->add_attribute("Id","1");
		$res_region1->add_attribute("Name","RegionName_World_01");
		
		$res_region2 = $this->resp->add_result();
		$res_region2->add_attribute("Id","2");
		$res_region2->add_attribute("Name","RegionName_World_02");
		
		$this->resp->run();
	}

	function AddLevelAdmin()
	{
		$regionId = (int)$_GET['regionId'];
		$name = mysql_real_escape_string($_GET['name']);
		$groupName = mysql_real_escape_string($_GET['groupName']);
		$seed = mt_rand();
		
		$lq = "SELECT * FROM Levels WHERE RegionId='$regionId' AND name='$name';";
		$hlq = mysql_query($lq);

		if(mysql_num_rows($hlq) == 0)
		{
			$ala_q = "INSERT INTO Levels (RegionId,Name,groupName,Seed) VALUES('$regionId','$name','$groupName','$seed');";
			$hala = mysql_query($ala_q) or die(error_log("Ascender API encountered a MySQL error: ".mysql_error()));
			$id = mysql_insert_id();			
		}

		$this->resp->run();

	}

	function GetLevelsXbox360()
	{

		$lq = "SELECT * FROM Levels;";
		$hlq = mysql_query($lq);

		while($row = mysql_fetch_object($hlq))
		{
			$res = $this->resp->add_result();
			$res->add_attribute("Id",$row->Id);
			$res->add_attribute("RegionId",$row->RegionId);
			$res->add_attribute("Seed",$row->Seed);
			$res->add_attribute("Name",$row->Name);
		}

		$this->resp->run();
	}


	//This is for leaderboard data, we'll deal with it when leaderboards are fixed in some way.
	function GetRemoteAccountsXbox360()
	{
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
		$this->resp->run();
	}


	function GetPlayerBossesAbilitiesXbox360()
	{
		$this->resp->run();
	}

	function GetPlayerBossesItemsXbox360()
	{
		$this->resp->run();
	}

	function GetWarStatsXbox360()
	{		
		//TODO: Start looking into WarXP tracking, may need ascension working before this works.
		$WarXpLightQuery = "SELECT SUM(WarXpLight) FROM accounts;";
		$WarXpDarkQuery = "SELECT SUM(WarpXpDark) FROM accounts;";
		$WarXpVoidQuery = "SELECT SUM(WarXpVoid) FROM accounts;";


		$CharactersLightQuery = "SELECT count(Alignment) FROM characters WHERE Alignment=1;"; 
		$CharactersLightHandle = mysql_query($CharactersLightQuery) or die(error_log("Ascender API GetWarStatsXbox360() - CharactersLightQuery - encountered a MySQL error: ".mysql_error()));
		$CharactersLightCount = mysql_num_rows($CharactersLightHandle);

		$CharactersVoidQuery = "SELECT count(Alignment) FROM characters WHERE Alignment=2;";
		$CharactersVoidHandle = mysql_query($CharactersVoidQuery) or die(error_log("Ascender API GetWarStatsXbox360() - CharactersVoidQuery - encountered a MySQL error:".mysql_error()));
		$CharactersVoidCount = mysql_num_rows($CharactersVoidHandle);

		$CharactersDarkQuery = "SELECT count(Alignment) FROM characters WHERE Alignment=3;";
		$CharactersDarkHandle = mysql_query($CharactersDarkQuery) or die(error_log("Ascender API GetWarStatsXbox360() - CharactersDarkQuery - encountered a MySQL error:".mysql_error()));
		$CharactersDarkCount = mysql_num_rows($CharactersDarkHandle);

		$res = $this->resp->add_result();
		$res->add_attribute("WarXpLight",0);
		$res->add_attribute("WarXpDark",0);
		$res->add_attribute("WarXpVoid",0);
		$res->add_attribute("CharCountLight",$CharactersLightCount);
		$res->add_attribute("CharCountDark",$CharactersDarkCount);
		$res->add_attribute("CharCountVoid",$CharactersVoidCount);
		$res->add_attribute("BossCountLight",0);
		$res->add_attribute("BossCountDark",0);
		$res->add_attribute("BossCountVoid",0);
		$res->add_attribute("ChallengeWinsLight",0);
		$res->add_attribute("ChallengeWinsDark",0);
		$res->add_attribute("ChallengeWinsVoid",0);
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