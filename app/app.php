<?php
use Helpers\CsvParser;
use Helpers\Stat;

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

class App{

    private static function __autoload(){
        spl_autoload_register(function ($class) {
            include  __DIR__ . DS. str_replace("\\","/", $class). '.php';
        });
    }

    public static function bootstrap(){

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        self::__autoload();

    }

}


class Shell{
    private static $__args = array();


    private static function __parseArgs($args){

        if($args){
            self::$__args = $args;
            array_shift(self::$__args); // remove first  value
        }
    }


    public static function run(){

        self::__parseArgs($_SERVER['argv']);


        try{
            # Fetch the parameters
            if(count(self::$__args) != 2){
                echo "Please specify the required parameters \n\n";
                die(self::__usageHelp());
            }

            $file_name = self::$__args[0]; // filename
            $col_name  = self::$__args[1]; // columnname

            $columnData = (new CsvParser($file_name,true))
                    ->getColumnData($col_name);

            if(!$columnData)
                die("Data doesnot exists for the specified column \n\n");


            //$columnData =  array(2,0,3,5,6);

            $stat = new Stat($columnData);

            echo "\n===Mean, Media, Mode, Standard Deviation==\n\n";
            echo "Mean: ",  $stat->mean();
            echo "\n";
            echo "Median: ",$stat->median();
            echo "\n";

            $mode = $stat->mode();

            echo  "Mode: ", $mode?$mode:"Mode for the given data set doesnot exits";
            echo "\n";
            echo  "Standard Deviation: ",$stat->standardDeviation();
            echo "\n\n";
            die();
        } catch (\Exception $e){
            echo $e->getMessage(),"\n";
        }

    }

    private static function __usageHelp()
    {
        return <<<USAGE
Example Usage: php  index.php ./data.csv C1\n\n
USAGE;
    }

}


?>