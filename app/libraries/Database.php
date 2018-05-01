<?php //
//
//class Database
//{
//
//    private static $connection;
//
//    private function connection()
//    {
//        try
//        {
//            $mysql = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
//            self::$connection = new PDO($mysql, DB_USERNAME, DB_PASS);
//        }
//        catch (Exception $ex)
//        {
//            print $ex->getMessage();
//        }
//    }
//    
//    public static function getCon(){
//        self::connection();
//        return self::$connection;
//    }
//
//}
