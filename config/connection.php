<?php
class DB {
    public static function connect(){
        return new PDO("sqlite:config/.database.db3");
    }
}