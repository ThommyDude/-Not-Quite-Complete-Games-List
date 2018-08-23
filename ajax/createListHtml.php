<?php
    if(!isset($_POST["gamesarr"]))
    {
        echo("Something went very VERY wrong!");
    }
    else
    {
        $games = $_POST["gamesarr"];

        foreach($games as $game)
        {
            if($game["playtime_forever"] == 0)
            {
                $playtime_str = "Never played";
            }
            elseif($game["playtime_forever"] < 60)
            {
                $playtime_str = $game["playtime_forever"] . " Minutes";
            }
            else
            {
                $rndtime = round($game["playtime_forever"]/60);
                if($rndtime == 1)
                {
                    $playtime_str = "Around " . $rndtime . " hour";
                }
                else
                {
                    $playtime_str = "Around " . $rndtime . " hours";
                }
            }

            echo('<div class="card text-center" style="min-width:184px; max-width:184px; margin-bottom: 20px;">');
            if($game["img_logo_url"] !== "")
            {
                echo('<img class="card-img-top" src="http://media.steampowered.com/steamcommunity/public/images/apps/' . $game["appid"] . '/' . $game["img_logo_url"] . '.jpg" alt="img-top">');
            }
            echo('<div class="card-body">');
            echo('<h4 class="card-title">' . $game['name'] . '</h4>');
            echo('<h6 class="card-subtitle">' . $game['appid'] . '</h6>');
            echo('</div>');
            echo('<div class="card-footer text-muted">');
            echo('<span href="#" data-toggle="tooltip" title="' . $game["playtime_forever"] . ' Minutes">' . $playtime_str . '</span>');
            echo('</div>');
            echo('</div>');
        }
    }
?>