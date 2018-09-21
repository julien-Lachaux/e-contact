<?php
/**
 * Class Autoloader
 */
class Autoloader{

    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param [string] $class Le nom de la classe à charger
     */
    static function autoload($class){
        require 'src/class/' . $class . '.php';
    }

}