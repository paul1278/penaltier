<?php
class Config {
    /**
     * contains the path to the configFile
     * @var String configFile
     */
    private static $configFile;

    /**
     * contains the config as array
     * @var Array config
     */
    private static $config;

    /**
     * is Config initialized?
     * @var Boolean init
     */
    private static $init;

    /**
     * Set the config-file to use
     * @param String $s Path to the config-file
     */
    public static function setConfigFile(String $s, $output = true) {
        if(file_exists($s)) {
            self::$configFile = $s; 
            $i = self::init();
            if(!$i) {
                return false;
            }
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Get a value from the config
     * A query string is like a path to go through the array
     * e.g. /moodle/baseUrl
     * @param  String $q Query-String
     * @return Mixed
     */
    public static function get(String $q) {
        if($q[0] == '/') {
            $q = substr($q, 1);
        }
        // $q = /path/to/some/setting
        $qs = explode("/", $q);
        $finalSetting = self::$config;
        foreach($qs as $t) {
            if(!isset($finalSetting[$t])) {
                return NULL;
            }
            else {
                $finalSetting = $finalSetting[$t];
            }
        }
        return $finalSetting;

    }

    /**
     * Initinalise the config
     * Read the config-file and save into self::$config
     * @return Boolean was the process successful
     */
    private static function init() {
        if(self::$init != true) {
            if(self::$configFile == NULL) {
                return false;
            }
            $file = file_get_contents(self::$configFile);
            self::$config = json_decode($file, true);
            if(self::$config == NULL) {
                return false;
            }
            self::$init = true;
            return true;
        }
    }
}

Config::setConfigFile(__DIR__ . "/../conf.json");
?>