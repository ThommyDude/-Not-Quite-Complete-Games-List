# Steam Games List
This is step 1 of a larger idea/project I'm trying to make, final product should be a "complete" games list, getting games from Steam, GOG and Uplay all in one list!

## Demo Link
[Here is a link to my own personal page with my personal games list.](http://thomas.vanderven.se/games)

## What's there?
Currently if you input a Steam webAPI key and a Steam64 ID into the config.php file (found in the config folder) the page will generate a list of all games (Not including games with Beta and/or Test in their name).

**_Update #1_**
Now also showing the 3 last played games in order of most to least playtime of the last 2 weeks.
I'm suprised by the fact that there isn't just a "lastplayed" entry holding the date and/or a timestamp so you could actually order them in order of playing them, instead of just the amount of time... Valve should really get on that!

**_Update #2_**
There is now a small profile section. This is done by downloading another JSON file containing information about your profile.
If the profile is set to public and you're currently in-game a small section will be created showing the game's logo and name.

**_Update #2.5_**
There is also a small dot next to your status that gets updated (colour changes) depending on what your status is currently set to.
I haven't made anything for _Looking to Play_ and _Looking to Trade_ because I couldn't decide on a good colour for these options, and also I never ever EVER use these nor have I ever seen anyone else use them. So I don't know if it's really needed.

**_Update #3_**
**SORTING IS HERE!**
By moving some code around, adding some Javascript/JQuery and AJAX, the list itself is now created dynamically and with the push of a button the list will be re-ordered and re-added to the page. Currently the only sorting possibilities are Alphabetical (which is the default when you arrive on the page) and sorted by Total Playtime, meaning that your most played games will be at the top and the games that you've never played, the games you've forgotten you even owe, the games that are slowly withering away somewhere in your Steam Library, those games will be at the bottom.

### So why?
Mainly just to see if I could, and getting some experience working a bit more with API's created by other people.

##### Also dude, why does it look like shit?
First off, fuck you. Second, I'm a functional guy, I don't care much about how it looks. I used bootstrap to at least make it presentable... :wink::ok_hand: