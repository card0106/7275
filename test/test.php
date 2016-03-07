<?php
$__readexcel_called = false;
function readexcel( $filePath) {  
    if(!$__readexcel_called){  
        $__readexcel_called = true;  
        require_once './classes/PHPExcel/IOFactory.php';//根据你的情况修改路径  
    }
    $PHPExcel = PHPExcel_IOFactory::load($filePath);  
                   
    $currentSheet = $PHPExcel->getSheet(0);  /**取得一共有多少列*/  
    $allColumn = $currentSheet->getHighestColumn();     /**取得一共有多少行*/  
    $allRow = $currentSheet->getHighestRow();  
    $all = array();  
    for( $currentRow = 1 ; $currentRow <= $allRow ; $currentRow++){    
        $flag = 0;  
        $col = array();  
        for($currentColumn='A'; ord($currentColumn) <= ord($allColumn) ; $currentColumn++){        
            $address = $currentColumn.$currentRow;
            $cell = $currentSheet->getCell($address);
            if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){
                $value = $cell->getValue();
                $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();
                $formatcode=$cellstyleformat->getFormatCode();
                if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)) {
                    $value=gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($value));
                }else{
                    $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);
                }
            }else
                $value = $cell->getFormattedValue();
            $col[$flag] = $value;            
            $flag++;  
        }  
        $all[] = $col;  
    }  
    return $all;  
}

