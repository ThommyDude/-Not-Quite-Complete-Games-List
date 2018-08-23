<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once("./incl/functions.php");

    $steamData = loadSteam();

    $profile = $steamData["profile"];
    $games = $steamData["games"];
    $latest = $steamData["latest"];

    require_once("./incl/head.php");
?>
        <h1>Steam Profile</h1>
        <?php
            $created = date("j-n-Y H:i:s", $profile["timecreated"]);
            
            $status = getStatus($profile["personastate"]);

            echo('<div class="card"><div class="row no-gutters"><div class="col-auto">');
            echo('<img src="' . $profile["avatarfull"] . '" class="img-fluid">');
            echo('</div><div class="col"><div class="card-block px-2">');
            echo('<h4 class="card-title">' . $profile["personaname"] . '</h4>');
            echo('<p class="card-text">');
            echo($status[0] . ' <svg height="10" width="10"><circle cx="5" cy="5" r="4" stroke="darkgrey" stroke-width="1" fill="' . $status[1] . '" /></svg>');
            echo('<br/>');
            echo('<a href="' . $profile["profileurl"] . '">Check profile on Steam</a>');
            echo('<br/>');
            echo('Active Since: ' . $created);
            echo('</p></div></div>');
            if(isset($profile["gameid"]))
            {
                echo('<div class="col"><div class="card-block"><h4 class="card-title">Currently In-Game</h4><p class="card-text">');
                for($i = 0; $i < count($games); $i++)
                {
                    if($games[$i]["appid"] == $profile["gameid"])
                    {
                        echo('<img src="http://media.steampowered.com/steamcommunity/public/images/apps/' . $games[$i]["appid"] . '/' . $games[$i]["img_logo_url"] . '.jpg">');
                        echo('<h3>' . $games[$i]["name"] . '</h3>');
                    }
                }
                echo('</p></div></div>');
            }
            echo('</div></div>');
        ?>
        <h2>Steam Games:</h2>
        <h3>Last 3 games I played (ordered by playtime in the last 2 weeks)</h3>
        <div id="latestContainer" class="card-deck" style="width: 90%; margin: 5%;">
            <?php
                foreach($latest as $game)
                {
                    echo('<div class="card text-center" style="min-width:184px; max-width: calc(90% / 3); margin-bottom: 20px;">');
                    if($game["img_logo_url"] !== "")
                    {
                        echo('<img class="card-img-top" src="http://media.steampowered.com/steamcommunity/public/images/apps/' . $game["appid"] . '/' . $game["img_logo_url"] . '.jpg" alt="img-top">');
                    }
                    echo('<div class="card-body">');
                    echo('<h4 class="card-title">' . $game['name'] . '</h4>');
                    echo('<h6 class="card-subtitle">' . $game['appid'] . '</h6>');
                    echo('</div>');
                    echo('</div>');
                }
            ?>
        </div>
        <h3>Complete Games List</h3>
        <div id="buttonContainer">
            <button id="alpha" type="button" class="btn btn-outline-info">Alphabetical</button>
            <button id="playtime" type="button" class="btn btn-outline-info">Playtime</button>
        </div>
        <div id="gamesContainer" class="card-deck" style="width: 90%; margin: 5%;">
            <!-- This'll be replaced with the list created with Javascript/JQuery/PHP -->
        </div>
<?php
    require_once("./incl/foot.php");
?>