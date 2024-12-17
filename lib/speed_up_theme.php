<?php

class speed_up_theme
{
    public static function getUrl($file, $show_timestamp = true)
    {
        if ($show_timestamp) {
            $timestamp = '?timestamp=' . @filemtime(rex_path::base('theme/'.$file));
        }

        return rex_url::assets($file) . $timestamp;
    }

    public static function showUrl($file, $show_timestamp = true)
    {
        echo self::getUrl($file, $show_timestamp);
    }
}
