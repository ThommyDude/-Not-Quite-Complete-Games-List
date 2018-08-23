        <script>
            $().ready(function()
            {
                function updateListView(newGames)
                {
                    var ajaxGames;
                    if(newGames)
                    {
                        ajaxGames = newGames;
                    }
                    else
                    {
                        ajaxGames = <?php echo(json_encode($games)); ?>;
                    }
                    
                    $.ajax(
                    {
                        method: "POST",
                        url: "./ajax/createListHtml.php",
                        data: {
                            gamesarr: ajaxGames
                        }
                    })
                    .done(function(resp)
                    {
                        if(resp !== "false" && resp !== "")
                        {
                            $("#gamesContainer").html(resp);
                        }
                        else
                        {
                            $("#gamesContainer").empty();
                        }
                    });
                }

                updateListView();
                $("#alpha").hide();
                
                $("#alpha").on("click", function()
                {
                    <?php
                        usort($games, "alphabeticSort");
                        $jsGames = json_encode($games);
                        echo('var alpGames = ' . $jsGames . ';');
                    ?>
                    updateListView(alpGames);
                    $("#alpha").hide();
                    $("#playtime").show();
                });

                $("#playtime").on("click", function()
                {
                    <?php
                        usort($games, "totalPlaytimeSort");
                        $jsGames = json_encode($games);
                        echo('var ptGames = ' . $jsGames . ';');
                    ?>
                    updateListView(ptGames);
                    $("#alpha").show();
                    $("#playtime").hide();
                });
            });
        </script>
    </body>
</html>