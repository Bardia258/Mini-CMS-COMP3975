<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /app');
    die('You need to be logged in!!!');
}
