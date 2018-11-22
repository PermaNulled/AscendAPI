<?php
require_once("response_xml.php");

function load_game($profile_id)
{
	header('Content-type: text/json');
	
	if(!is_numeric($profile_id))
	{
		error_Log("Ascender API - load_game profile_id !numeric - ".$profile_id);
		exit;
	}

	$save_content = file_get_contents("saves/".$profile_id.".savej");
	print($save_content);
	$length = ob_get_length();
	header("Content-Length: ".$length);
	exit;
}

function save_game($profile_id)
{
	if(!is_numeric($profile_id))
	{
		error_Log("Ascender API - save_game profile_id !numeric - $profile_id");
		exit;
	}

	$save_content = file_get_contents("php://input");
	$fh = fopen("saves/".$profile_id.".savej","w");
	fwrite($fh,$save_content);
	fclose($fh);

	header('Content-type: text/json');
	print('[ { "Result": "OK" } ]');  // hope this is all it needs...

	$length = ob_get_length(); 
	header("Content-Length: $length");
	exit;
}

function handle_save_load($profile_id)
{

		if(!is_numeric($profile_id))
		{
			error_log("ASCENDER API - handle_save_load profile_id was not numeric aborting!");
			exit;
		}

		header('Content-type: text/json');

		$resp = array(
				array("Result"=>"OK"),
			    array(
			        "Id"=>"0",
			        "BaseUri"=>"http://new.thedefaced.org/",
			        "GetUri"=>"game/save/load/".$profile_id,
			        "PutUri"=>"game/save/put/".$profile_id,
			     	"LastModified"=>"20181121000000",
			     	"Length"=>"".filesize("saves/".$profile_id.".savej")."",
			     	"ETag"=>"a-112"
			    ),
			    array(
			        "Id"=>"1",
			        "BaseUri"=>"http://new.thedefaced.org/",
			        "GetUri"=>"game/save/geturi2",
			        "PutUri"=>"game/save/put/".$profile_id
			    ),
			    array(
			        "Id"=>"2",
			        "BaseUri"=>"http://new.thedefaced.org/",
			        "GetUri"=>"game/save/geturi3",
			         "PutUri"=>"game/save/put/".$profile_id
			    ),
			   array(
			        "Id"=>"3",
			        "BaseUri"=>"http://new.thedefaced.org/",
			        "GetUri"=>"game/save/geturi4",
			        "PutUri"=>"game/save/put/".$profile_id
			  )
			);
	
		print json_encode($resp);

		$length = ob_get_length(); 
		header("Content-Length: $length");
		exit;
}

?>