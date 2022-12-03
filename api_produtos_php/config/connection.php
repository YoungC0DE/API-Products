<?php
class DB {
    public static function connect(){
        return new PDO("sqlite:database.db3");
    }
}