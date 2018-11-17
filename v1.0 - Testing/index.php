<?php
echo parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$login_file = "login_data.xml";
$store_offer_file = "store_offers.xml";
$save_file = "save_response.xml";
$store_items_file = "store_items.xml";
$signin_file = "xbox_signin.xml";
$player_item_file = "player_items.xml";
$steam_info_file = "steam_userinfo.xml";
$warstats_file = "warstats.xml";

header("ETag: ".rand(100,123)."-a");

$fh = fopen("object.txt","a");
fwrite($fh,"Dumping \$_REQUEST Data\r\n");
$data = print_r($_REQUEST,true);
fwrite($fh,"Dumping \$_SERVER Data\r\n");
$data.= print_r($_SERVER,true);
fwrite($fh,$data);

if($_SERVER['REQUEST_URI'] == "/users/me/id")
{
        echo "1";
}

if(strstr($_SERVER['REQUEST_URI'],"/game/auth/steam?x=0"))
{
    header('Content-Length: ' . filesize($login_file));
    fwrite($fh,"Handling Steam AuthTicket\r\n");
    readfile($login_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/save/signed-url?ProfileId="))
{
   header('Content-Length: ' . filesize($save_file));
   fwrite($fh,"Handling Save/signed-url!");
   readfile($save_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetStoreOffersXbox360"))
{
   header('Content-Length: '. filesize($store_offer_file));
   fwrite($fh,"Handling StoreOffersXbox360\r\n");
   readfile($store_offer_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetStoreItemsXbox360"))
{
   header('Content-Length: '. filesize($store_items_file));
   fwrite($fh,"Handling StoreItemsXbox360\r\n");
   readfile($store_items_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sequence?sequence=SigninToAccountXbox360&xuid="))
{
   header('Content-Length: '. filesize($signin_file));
   fwrite($fh,"Handling SigninToAccountXbox360\r\n");
   readfile($signin_file);
}


if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerItems1Xbox360&xuid="))
{
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerItems1Xbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=ResolveConsumableGiftTimersClient&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling ResolveConsumableGiftTimersClient\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerConsumables1Xbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerConsumables1Xbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetDepositBoxesXbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetDepositBoxesXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerAbilitiesXbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerAbilitiesXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetCustomizerItemsXbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerAbilitiesXbox360\r\n");
   readfile($player_item_file);
}


if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetStoreCustomizerItemsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetStoreCustomizerItemsXbox360\r\n");
   readfile($player_item_file);
}


if(strstr($_SERVER['REQUEST_URI'],"/game/sequence?sequence=AddPendingSoulsAndXpXbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetStoreCustomizerItemsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerBossesForCreatorXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerBossesForCreatorXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetContentionPoints2Xbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetContentionPoints2Xbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetContentionPointTitlesXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetContentionPointTitlesXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetRegionsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetRegionsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetLevelsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetLevelsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetRemoteAccountsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetRemoteAccountsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerBossesTopXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerBossesTopXbox360\r\n");
   readfile($player_item_file);
}


if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetSoulPackOffersSteam"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetSoulPackOffersSteam\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerItemsByIdXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerItemsByIdXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerAbilitiesByIdXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerAbilitiesByIdXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerBossesAbilitiesXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerBossesAbilitiesXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetPlayerBossesItemsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetPlayerBossesItemsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetWarStatsXbox360"))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($warstats_file));
   fwrite($fh,"Handling GetWarStatsXbox360\r\n");
   readfile($warstats_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sequence?sequence=PushEventsXbox360&xuid="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling PushEventsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sproc?sproc=GetRecentMsgsXbox360&target="))
{
   /* TODO: Update to the proper file */
   header('Content-Length: '. filesize($player_item_file));
   fwrite($fh,"Handling GetRecentMsgsXbox360\r\n");
   readfile($player_item_file);
}

if(strstr($_SERVER['REQUEST_URI'],"/game/sequence?sequence=GetUserInfoSteam&steamid="))
{
   header('Content-Length: '. filesize($steam_info_file));
   fwrite($fh,"Handling GetUserInfoSteam\r\n");
   readfile($steam_info_file);
}




fclose($fh);
exit;
?>
