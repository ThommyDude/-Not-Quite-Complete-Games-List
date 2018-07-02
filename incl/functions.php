<?php
    $config = require './config/config.php';
    
    function loadGames()
    {
        if( (!file_exists("./steam_cache/steam_games.json")) || (file_exists("./steam_cache/steam_games.json") && time() - filemtime("./steam_cache/steam_games.json") > 3600) )
        {
            file_put_contents("./steam_cache/steam_games.json", file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=' . $config["steam_api_key"] . '&input_json={"steamid":"' . $config["steam_user_id"] . '","include_appinfo":true,"include_played_free_games":true}&format=json'));
            $jsondata = json_decode(file_get_contents("./steam_cache/steam_games.json"), true);
        }
        else
        {
            $jsondata = json_decode(file_get_contents("./steam_cache/steam_games.json"), true);
        }
        
        $games = $jsondata["response"]["games"];
        usort($games, "cmp");

        return $games;
    }

    function cmp($a, $b)
    {
        $regex = "\p{Ll}\p{Lu}\p{Nl}\p{Nd}'";
        
        $nameA = mb_convert_encoding(strtolower($a["name"]), "UTF-8");
        $nameB = mb_convert_encoding(strtolower($b["name"]), "UTF-8");

        preg_match("/^[$regex]+([ &]+[$regex]+)?/u", $nameA, $tempMatch);
        $nameA = $tempMatch[0];
        preg_match("/^[$regex]+([ &]+[$regex]+)?/u", $nameB, $tempMatch);
        $nameB = $tempMatch[0];

        if(strcoll($nameA, $nameB) == 0)
        {
            return intval($a["appid"]) - intval($b["appid"]);
        }

        return strcoll($nameA, $nameB);
    }