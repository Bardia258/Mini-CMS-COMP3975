<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in!!!');
} else {
    echo 'You are authenticated';
}
