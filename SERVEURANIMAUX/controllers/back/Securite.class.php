<?php

class Securite
{
    public static function secureHtml($string)
    {
        return htmlentities($string);
    }


    /**
     * Summary of verifAccessSession
     * @return bool
     */
    public static function verifAccessSession()
    {
        return (!empty($_SESSION['access']) && $_SESSION['access'] === 'admin') ;
    }
}