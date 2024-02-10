<?php
session_start();
echo session_id();
session_destroy();
// header('Location: login.php');