<?php
session_start();

if ( !empty($_GET) && !isset($_GET["current_page_hash"]) ) {
    $_SESSION["current_page_hash"] = $_GET["current_page_hash"];
}