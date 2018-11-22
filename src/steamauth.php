<?php
require_once("response_xml.php");
require_once("dbconf.php");

function handle_steam_ticket($x,$AuthTicket,$ClientVersion)
{
	$resp = new Response("LoginResponse");
	$conn = mysql_connect(db_host,db_user,db_pass) or die("Ascender API had a mysql error: ".mysql_error());
	mysql_select_db("ascender");

	if(isset($_GET['AuthTicket']))
	{
		$SteamID = mysql_real_escape_string($_GET['AuthTicket']);
		$q = mysql_query("SELECT SteamId FROM accounts WHERE SteamId='".$SteamID."'") or die(error_log("Ascender API had an MySQL error:".mysql_error()));
		if(mysql_num_rows($q) == 0)
		{
			mysql_query("INSERT INTO accounts (SteamId,Souls) VALUES (".$SteamID.",20000)") or die(error_log("Ascender API had an MySQL error:".mysql_error()));
		}


		$res = $resp->add_result();
		$res->add_attribute("UserId",$SteamID);
		$res->add_attribute("AccountId",$SteamID);
		$resp->run();
	}
}


?>