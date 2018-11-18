<?php
require_once("response_xml.php");

class Sequence {
	private $sequence = "";
	private $xuid = 0;
	private $target = 0;
	private $resp = null;

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
		//TODO: Pull from database based on provided XUID...
		//Doing so obviously has risks of it's own (like account hijacking, this implementation they had sucks)
		$res = $this->resp->add_result();
		$res->add_attribute("XUID",$this->xuid);
		$res->add_attribute("SteamId",$this->xuid);
		$res->add_attribute("SteamOfferId","0");
		$res->add_attribute('SteamOrderId',"0");
		$res->add_attribute("MarketplaceState",0);
		//$res->add_attribute("CharacterID",0); // if we don't return a CharacterID there is no character and you should create one.
		$res->add_attribute("HideHelmet", 0);
		$res->add_attribute("PendingSouls",0);
		$res->add_attribute("SystemSouls",0);
		$res->add_attribute("ContentionPointSouls",0);
		$res->add_attribute("WarChallengeSouls",0);
		$res->add_attribute("SoulGift",0);
		$res->add_attribute("SoulUpdateId",0);
		$res->add_attribute("BossGotKill","false");
		$res->add_attribute("Souls",4000);
		$res->add_attribute("AscState",0);
		$res->add_attribute("Achievements",0);
		$res->add_attribute("CharXp","0");
		$res->add_attribute("CharXpAtStart","0");
		$res->add_attribute("CharXpAtAsc","0");
		$res->add_attribute("CharXpAsync","0");
		$res->add_attribute("CharLevelCap",-1); // code sets this by default
		$res->add_attribute("AscLevelReqInc",-1); // code sets this by default
		$res->add_attribute("TranscCount","0");
		$res->add_attribute("AscCountLight","0");
		$res->add_attribute("AscCountDark","0");
		$res->add_attribute("AscCountVoid","0");
		$res->add_attribute("WarXp","0");
		$res->add_attribute("WarXpAsync","0");
		$res->add_attribute("WarXpLight","0");
		$res->add_attribute("WarXpDark","0");
		$res->add_attribute("WarXpVoid","0");
		$res->add_attribute("GameTime","0");
		$res->add_attribute("OfflineTime","0");
		$res->add_attribute("ContentVersion","1.2.3"); // TODO: Verify how this is used.
		$res->add_attribute("SessionId","22"); // TODO: Randomly generate this
		$res->add_attribute("Banned",0);
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
		if(isset($params['xuid']))
			$this->xuid = $params['xuid'];
		if(isset($params['steamid']))
			$this->steamid = $params['steamid'];

		$this->sequence = $params['sequence'];

		$this->resp = new Response($this->sequence);
	}
}
?>