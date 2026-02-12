<?php

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sanitize_html($data)
{
    $data = trim($data);
    $data = strip_tags($data, "<p><h1><h2><h3><strong><ol><span><ll><ul><a><em><u>");
    return $data;
}

?>

