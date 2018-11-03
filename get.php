<?php

 header("Access-Control-Allow-Origin: *");
echo @file_get_contents('https://myanimelist.net/animelist/bazingarj/load.json');
