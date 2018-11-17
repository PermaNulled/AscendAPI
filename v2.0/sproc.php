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
     	}

	}

	function GetStoreOffersXbox360()
	{
		$res = $this->resp->add_result(); 

		// probably does nothing, but we're not returning any data and it doesn't like it if there's not a Result.
		$res->add_attribute("Error",1); 
		$this->resp->run();
	}

	function GetStoreItemsXbox360()
	{

		//Add more results for more items in the list
		$res = $this->resp->add_result();

		//Some test item data, should probably pull this from a db or something in the future.
		//TODO: Reverse Item names and types.
		$res->add_attribute("Name","Test");
		$res->add_attribute("Souls",0);
		$res->add_attribute("Type",1);

		$this->resp->run();
	}

	function GetPlayerItems1Xbox360() // PlayerSpecific Requires XUID
	{
		//TODO: Implement database functionality to actually store player items and return here!
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function ResolveConsumableGiftTimersClient() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerConsumables1Xbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetDepositBoxesXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerAbilitiesXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetCustomizerItemsXbox360() // Player Specific Requires XUID
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetStoreCustomizerItemsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesForCreatorXbox360() // Possibly Player specific.
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetContentionPoints2Xbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetContentionPointTitlesXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetRegionsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetLevelsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetRemoteAccountsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesTopXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
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
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerAbilitiesByIdXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesAbilitiesXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetPlayerBossesItemsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetWarStatsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
		$this->resp->run();
	}

	function GetRecentMsgsXbox360()
	{
		//TODO: Implement some database functionality, and return appropriate results
		$res = $this->resp->add_result();
		$res->add_attribute("Error",1);
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