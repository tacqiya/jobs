<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// try {
//     $need_PHP_Extentions = array('xml', 'gd', 'zip');
//     $php_v_min = '5.2.0';
//     $php_v_max = '8.0.1';
//     if(count(array_intersect(get_loaded_extensions(), $need_PHP_Extentions)) == count($need_PHP_Extentions)){
//         // All PHP extentions are loaded
//         if((phpversion() < $php_v_min) || ($php_v_max < phpversion())){
//             // PHP Version not compiled
//             throw new Exception('PHP Version is not compiled : PHP ≥ '.$php_v_min.' and < '.$php_v_max);
//         }else{
//             require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
//             require_once APPPATH . "third_party/PHPExcel/PHPExcel/IOFactory.php";
//         }
//     }else{
//         // PHP Extentions not loaded!
//         throw new Exception('PHP Extension(s) is missing to load : ' . implode(', ', array_diff($need_PHP_Extentions, array_intersect(get_loaded_extensions(), $need_PHP_Extentions))));
//     }    
// } catch (Exception $e) {
//     // die('Server Error : ' . $e->getMessage() . "\n");    
// }
require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";
            require_once APPPATH . "third_party/PHPExcel/PHPExcel/IOFactory.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
    // lead from zero
    public function __NOTUSE__getNameFromNumber($num){
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
    function getNameFromNumber($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }
}