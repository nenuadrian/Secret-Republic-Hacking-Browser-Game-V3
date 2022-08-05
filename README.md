# NOT ACTIVELY MAINTAINED - PLEASE SUBMIT PULL REQUESTS IF YOU ARE ABLE TO ADD ANY FIXES/DOCS/FEATURES

# Secret Republic - V3

<p align="center">

![Cover](screens/cover.jpg)

<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a>

</p>


# Live Demo

Live demo: https://secretrepublic-v3.nenuadrian.com

Hosted on [DreamHost](https://mbsy.co/dreamhost/92571715)

# Read about the journey

[Read article on Medium](https://medium.com/@adrian.n/secret-republic-open-sourced-hacker-simulation-futuristic-rpg-browser-based-game-php-843d393cb9d7)

# Overview

Audio trailer: https://www.youtube.com/watch?v=6thfiGb-b7c

A lot of work has gone into this but it (and more in its previous version) is not a documented (as of yet) project.

It's been through years of development with this being its 3rd full do-over.

However, the project on stand-by so I've decided to make the source available of nothing else

# Main Features

1. Audio AI (woman, same as trailer) voice speaks when interacting with the game

2. Futuristic bootstrap based UI, mostly mobile ready

3. UNIX like terminal/command line based missions

4. In-game Mission designer with BBCode like syntax features (see attached Guides and screens)

5. Community features: forums, organizations (guilds), organization forums, blogs, friends, messaging system, automatic mission based tournamens (hackdown), organization specific mission, the grid

6. The grid: every players gets a node to start with and can initialize or conquer other nodes from other players. The world is split in multiple zones, which are split into clusters with a final node granularity. Damage and spy attacks can be triggered between nodes. There's an attempt at a simulator for attacks

7. Abilities & skills which semi-influence command execution time in missions

8. Servers with upgradable hardware (motherboard, ram, hdd, power source, software)

9. Tutorial system

10. Rewards system

# SecretAlpha V4 

V4 is newer, more responsive made with mobile-first in mind, but way less featured.

https://github.com/nenuadrian/Secret-Republic-Hacker-Game-ORPBG-Alpha

# Simple Setup

You need a webserver (e.g. MAMP/WAMP/XAMPP) able to run PHP (tested with 7.3) and an MySQL database (LAMP stack).

1. Install `composer` (the PHP dependency management system - `brew install composer` for MacOS) and run `composer install`

2. You will need to create an empty Database in MySQL - it's name is not relevant but you will need it in the next step. For MAMP, you would go to `http://localhost:8888/phpMyAdmin5`

3. Visit `http://localhost/public_html/setup` - this may be different if you are using another port or directory structure, e.g. `http://localhost:8888/sr/public_html/setup` and follow the setup process


You may need to manually execute the following SQL if you see a GROUP BY related error on the missions page:

```
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
```

![Screenshot](screens/setup.png)


# Optional useful cron jobs

These ensure processes run as required, that hacking competitions start, that attack reports are generated and that time based resources are given to players.

Set these up to run periodically as the parameters suggest. The resources one should run every minute.

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/attacks/true

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/hourly/true

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/daily/true

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/hackdown/true

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ/rankings/true

localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/attacks/true

e.g.

*/2 * * * * wget -O - http://localhost/cron/key1/MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=/attacks/true >/dev/null 2>&1

https://en.wikipedia.org/wiki/Cron

# screens

<p align="center">

![Screenshot](screens/1.jpg)

![Screenshot](screens/2.jpg)

![Screenshot](screens/3.jpg)

![Screenshot](screens/4.jpg)

![Screenshot](screens/5.jpg)

![Screenshot](screens/6.jpg)

![Screenshot](screens/7.jpg)

![Screenshot](screens/8.jpg)

![Screenshot](screens/9.jpg)

![Screenshot](screens/10.jpg)

![Screenshot](screens/11.jpg)

</p>


# License

This initial version was created by [Adrian Nenu] (https://github.com/nenuadrian) 

<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a>

Please link and contribute back to this repository if using the code or assets :)
