<?php
namespace Helpers;


class Stat{

    private $data = null;


    public function __construct($dataArray){
        if(is_array($dataArray) && !empty($dataArray))
            $this->data = $dataArray;
    }


    /*
     *  Calculate Mean
     *
     *  mean = sum of the numbers / n.
     */

    public function mean(){
        if(!is_array($this->data) or empty($this->data))
            return false;

        return array_sum($this->data)/count($this->data);

    }

     /*
     *  Calculate Median
     *
     * The center number (n) where n is odd and if n is even the median is average of the two center values
     */

    public function median(){
        if(!is_array($this->data) or empty($this->data))
            return false;

        $mIndex = (count($this->data)+1)/2;

        if(is_float($mIndex))
            return ($this->data[(int)$mIndex-1] +  $this->data[(int)$mIndex]) / 2;

        return $this->data[(int)$mIndex-1];
    }


    /*
     *  Calculate Median
     *
     *  The frequently repeated number.
     */

    public function mode(){
        if(!is_array($this->data) or empty($this->data))
            return false;

        $cnts = array_count_values($this->data);

        arsort($cnts); // Sort  descending order

        $modes  = array_keys($cnts, current($cnts), true);

        // if the total number of values is equal to the count the mode simply doesnot exist
        if (count($this->data) === count($cnts))
            return false;

        if (count($modes) === 1)
            return $modes[0];

        return implode(",",$modes);
    }


     /*
     *  Calculate Standard Deviation
     *
     *  Square Root of ([ (a1 - mean)2 + (a2 - mean)2 + (a3 - mean)2 + ... + (an - mean)2 ] / [n - 1])
     */

    public function standardDeviation(){

        if(!is_array($this->data) or empty($this->data))
            return false;

        $mean = $this->mean(); // get the mean
        $variance = null;

        foreach ($this->data as $i)
            $variance += pow($i - $mean, 2); //[ (a1 - mean)2 + (a2 - mean)2 + (a3 - mean)2 + ... + (an - mean)2 ]

        $variance /= count($this->data) - 1 ;

        return round((float) sqrt($variance),4);
    }


}

?>