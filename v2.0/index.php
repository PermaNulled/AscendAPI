<?php
require_once("steamauth.php");
require_once("game_save.php");
require_once("sproc.php");
require_once("sequence.php");

header("ETag: ".rand(100,123)."-a"); // Not a real ETag header, but it'll fool the game.
header('Content-type: text/xml');

$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

switch($path)
{
	case "/game/auth/steam":
		handle_steam_ticket($_GET['x'],$_GET['AuthTicket'],$_GET['ClientVersion']);
	break;

	case "/game/save/signed-url":
		handle_game_save($_GET['ProfileId']);
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
}

?>