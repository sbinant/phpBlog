<?php
namespace App;

class URL {

    public static function getInt( string $name, ?int $default = null ):? int
    {
        if( !isset( $_GET[$name] )) return $default;
        if( $_GET[$name] === '0' ) return 0;
    
        if( ! filter_var( $_GET[$name], FILTER_VALIDATE_INT))
        {
            throw new \Exception("SB: parameter $name in the URL is not an intiger ");
        }
        return (int) $_GET[$name];
    }

    public static function getPositiveInt( string $name, ?int $default ):? int
    {
        $param = self::getInt( $name, $default );
    
        if( $param !== null && $param <= 0)
        {
            throw new \Exception("SB: parameter $name in the URL is not a positive intiger ");
        }
        return $param;
    }
}