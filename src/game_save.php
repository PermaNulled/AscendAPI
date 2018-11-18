<?php
require_once("response_xml.php");

function handle_game_save($profile_id)
{
	$resp = new Response("GameSaveSignedUrlResponse");

	//As it stands I haven't found the game trying to handle any additional data here,
	//TODO: Add more data and breakpoint to determine if there's more data.
	$res = $resp->add_result();
	$resp->run();
}

?>