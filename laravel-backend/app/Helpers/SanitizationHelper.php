<?php

namespace App\Helpers;

class SanitizationHelper
{
    /**
     * Sanitize basic input - removes special characters, escapes HTML
     */
    public static function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Sanitize HTML content - strips tags except allowed ones
     * Allows common formatting and structural tags from Quill editor
     */
    public static function sanitizeHtml($data)
    {
        $data = trim($data);
        // Allow tags commonly used by Quill editor and basic HTML formatting
        $data = strip_tags($data, "<p><h1><h2><h3><h4><h5><h6><strong><em><u><s><span><div><br><ol><ul><li><a><img><blockquote><code><pre>");
        return $data;
    }
}
