<?php
session_start();
echo session_id(); //あなたに割り振られたKEY
echo $_SESSION["name"];
echo $_SESSION["age"];