<?php
session_start();
require("config.php");
session_unregister("SESS_ADMINLOGGEDIN");
header("Location: " . $config_basedir);
?>