<?php

/**
 * This class represents the database-connector
 */
class Database {
    /**
     * Contains the mysqli-link
     * @var mysqli
     */
    private static $link;

    /**
     * Was initialisation successful?
     * @var Boolean
     */
    private static $init;

    /**
     * Initialises the class / connection
     * @return Boolean Was initialisation successful?
     */
    public static function init() {
        if(self::$init == true) {
            return true;
        }
        $link = mysqli_connect(
            Config::get("database/url"),
            Config::get("database/username"),
            Config::get("database/password"),
            Config::get("database/database")
        );
        if (!$link) {
            return false;
        }
        self::$link = $link;
        self::$init = true;
		self::dbQuery("SET NAMES 'utf8'");
        return true;
    }

    /**
     * Prepare a statement
     * @param  String $q Query
     * @return mysqli_stmt
     */
    public static function prepare(String $q) {
        if(!self::init()) {
            return NULL;
        }
        $p = mysqli_prepare(self::$link, $q);
        self::error("prepare", $q);
        return $p;
    }

    /**
     * Get an error object
     * @param  String $s A simple indicator where it was
     * @param  String $meta e.g. query
     */
    public static function getError() {
        $e = mysqli_errno(self::$link);
        if($e != null) {
            $o = new stdClass();
            $o->errno = $e;
            $o->error = mysqli_error(self::$link);
            return $o;
        }
        return null;
    }

    /**
     * If there was an error, log it
     * @param  String $s A simple indicator where it was
     * @param  String $meta e.g. query
     */
    public static function resultToArray($r) {
        $p = [];
        while($o = mysqli_fetch_object($r)) {
            $p[] = $o;
        }
        return $p;
    }

    /**
     * If there was an error, log it
     * @param  String $s A simple indicator where it was
     * @param  String $meta e.g. query
     */
    public static function error(String $s, String $meta = "") {
        $e = mysqli_errno(self::$link);
        return $e;
    }

    /**
     * Execute a query
     * @param  String $q Query
     * @return mixed The query-result
     */
    public static function dbQuery(String $q) {
        if(!self::init()) {
            return NULL;
        }
        return mysqli_query(self::$link, $q);
    }

    public static function bind($stmt, $types, $values) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
    }

    public static function ebind($stmt, $types, $values) {
        self::bind($stmt, $types, $values);
        mysqli_stmt_execute($stmt);
    }

    public static function exec($statement, $types, $values, $result = true) {
        $pr = self::prepare($statement);
        self::ebind($pr, $types, $values);
        if($result) {
            return mysqli_stmt_get_result($pr);
        } else {
            return $pr;
        }
    }
}

Database::init();
?>