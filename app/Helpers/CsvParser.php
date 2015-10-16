<?php
namespace Helpers;

class CsvParser{

    private $_fileName = null;

    private $_csvData  = null;

    private $_csvHeader  = null;

    private $_first_row_header = false;


    public function __construct($fileName,$first_row_header=false){

        # Check if file exists first
        if(file_exists($fileName))
          $this->_fileName = $fileName;
        else
            throw new \Exception("The file specified doesnot exist");

        $this->_first_row_header = $first_row_header;

        $this->__parse();

    }

    /*
     *  return the specified column data
     */
    public function getColumnData($column_name){

        if($this->_first_row_header)
          $columnIndex = array_search($column_name, $this->_csvHeader);
        else
          $columnIndex = $column_name;

        if($columnIndex===false)
            throw new \Exception("The column specified doesnot exist");

        return array_column($this->_csvData, $columnIndex);
    }




    /*
     *  parse the csv file
     */

    private function __parse(){
        if(!$this->_fileName)
            return false;

        $this->_csvData = array_map('str_getcsv', file($this->_fileName));

        # Check if the first row of the csv is the header
        if($this->_first_row_header)
            $this->_csvHeader = array_shift($this->_csvData);

        return $this;
    }




}

?>