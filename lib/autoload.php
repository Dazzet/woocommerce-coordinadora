<?php


/**
 * Autoload any file that its in /lib and has the namespace WCCoordinadora
 */
spl_autoload_register( function( $class ) {
    $prefix = 'WCCoordinadora\\';
    $baseDir = dirname(__DIR__) . '/lib/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return; //  move to next autoloader
    }

    $relativeClass = substr($class, $len);

    $fileToInclude = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    require_once $fileToInclude;
});



