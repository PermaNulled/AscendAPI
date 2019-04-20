<?php
require_once("steamauth.php");
require_once("game_save.php");
require_once("sproc.php");
require_once("sequence.php");
require_once("response_xml.php");
require_once("dbconf.php");

header("ETag: ".md5(mt_rand())); // Not a real ETag header, but it'll fool the game.
header('Cache-Control: no-cache');
header('Content-type: text/xml');

$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

if(strstr($path,"/game/save/"))
{
	$npath = explode("/",$path);
	$type = $npath[3];

	if($type == "load")
	{
		load_game($npath[4]);
	}

	if($type == "put")
	{
		save_game($npath[4]);
	}
}

switch($path)
{
	case "/game/auth/steam":
		handle_steam_ticket($_GET['x'],$_GET['AuthTicket'],$_GET['ClientVersion']);
	break;

	//TODO: Move this to game_save.php
	case "/game/save/signed-url": // only accepts a JSON response
		handle_save_load($_GET['ProfileId']);
	break;

	case "/game/sproc":
		$sproc = new Sproc($_GET);
		$sproc->run();
	break;

	case "/game/sequence":
		$sequence = new Sequence($_GET);
		$sequence->run();
	break;

	case "/users/me/id":
			// Seems to be unused currently
	break;

	case "/game/verifystrings":

		header('Content-type: text/json');

		/*
		 We honestly don't care what name they use,
		 We may want to check that it's not the same as someone else in the future though.
		*/
		print('[ { "Result": "OK" } ]'); 

		$length = ob_get_length(); 
		header("Content-Length: $length");
	break;
}

?>