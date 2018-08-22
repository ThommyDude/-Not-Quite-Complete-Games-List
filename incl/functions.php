<?php
    $config = require './config/config.php';
    
    function loadSteam()
    {
        global $config;
        
        if(!file_exists("./steam_cache/steam_profile.json") || (file_exists("./steam_cache/steam_profile.json") && time() - filemtime("./steam_cache/steam_games.json") > 300))
        {
            file_put_contents("./steam_cache/steam_profile.json", file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $config["steam_api_key"] . '&steamids=' . $config["steam_user_id"] . '&format=json'));
            $jsonprofile = json_decode(file_get_contents("./steam_cache/steam_profile.json"), true);
        }
        else
        {
            $jsonprofile = json_decode(file_get_contents("./steam_cache/steam_profile.json"), true);
        }

        if($config["testing"] == true)
        {
            $jsongames = json_decode(file_get_contents("./steam_cache/steam_games.json"), true);
            $jsonlatest = json_decode(file_get_contents("./steam_cache/steam_latest.json"), true);
        }
        elseif( (!file_exists("./steam_cache/steam_games.json")) || (file_exists("./steam_cache/steam_games.json") && time() - filemtime("./steam_cache/steam_games.json") > 3600) )
        {
            file_put_contents("./steam_cache/steam_games.json", file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=' . $config["steam_api_key"] . '&input_json={"steamid":"' . $config["steam_user_id"] . '","include_appinfo":true,"include_played_free_games":true}&format=json'));
            file_put_contents("./steam_cache/steam_latest.json", file_get_contents('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=' . $config["steam_api_key"] . '&input_json={"steamid":"' . $config["steam_user_id"] . '","count":3}&format=json'));
            $jsongames = json_decode(file_get_contents("./steam_cache/steam_games.json"), true);
            $jsonlatest = json_decode(file_get_contents("./steam_cache/steam_latest.json"), true);
        }
        else
        {
            $jsongames = json_decode(file_get_contents("./steam_cache/steam_games.json"), true);
            $jsonlatest = json_decode(file_get_contents("./steam_cache/steam_latest.json"), true);
        }
        
        $profile = $jsonprofile["response"]["players"][0];

        $games = $jsongames["response"]["games"];
        usort($games, "alphabeticSort");

        $latest = $jsonlatest["response"]["games"];
        usort($latest, "playtimeSort");
        
        $data["profile"] = $profile;
        $data["games"] = $games;
        $data["latest"] = $latest;

        return $data;
    }

    function getStatus($x)
    {
        switch($x)
        {
            case 0:
                return ["Offline", "red"];
                break;
            case 1:
                return ["Online", "green"];
                break;
            case 2:
                return ["Busy", "yellow"];
                break;
            case 3:
                return ["Away", "orange"];
                break;
            case 4:
                return ["Snooze", "darkblue"];
                break;
            case 5:
                // return ["Looking to Trade", ""];
                return ["Online", "green"];
                break;
            case 6:
                // return ["Looking to Play", ""];
                return ["Online", "green"];
                break;
            default:
                return "Offline";
                break;
        }
    }

    function alphabeticSort($a, $b)
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

    function playtimeSort($a, $b)
    {
        $a = $a["playtime_2weeks"];
        $b = $b["playtime_2weeks"];
        
        return $b <=> $a;
    }