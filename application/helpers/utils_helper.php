<?php
    if (!function_exists('dateFormat')){
        function dateFormat($strDate,$inputFormat,$outputFormat = 'Y-m-d H:i:s'){

            $date = DateTime::createFromFormat($inputFormat, $strDate);            
            if($date){
                return $date->format($outputFormat);
            }else{
                return date($outputFormat,$date);
            }
        }
    }
    if (!function_exists('dBDateFormat')){
        function dBDateFormat($strDate,$inputFormat=''){
            $inputFormat = ($inputFormat == '' ) ? DATEPICKER_FORMAT_ALIAS : $inputFormat;

            $date = DateTime::createFromFormat($inputFormat, $strDate);
            if($date){
                return $date->format('Y-m-d');
            }else{
                return date('Y-m-d',0);
            }
        }
    }
    if (!function_exists('dBDateTimeFormat')){
        function dBDateTimeFormat($strDate,$inputFormat=''){
            $inputFormat = ($inputFormat == '' ) ? DATEPICKER_FORMAT_ALIAS . " H:i:s" : $inputFormat;
            
            $date = DateTime::createFromFormat($inputFormat, $strDate);
            if($date){
                return $date->format('Y-m-d H:i:s');
            }else{
                return date('Y-m-d H:i:s',0);
            }
        }
    }

    if (!function_exists('parseNumber')){
        function parseNumber($strNumber,$commaSeparators=''){
            
            $commaSeparators = ($commaSeparators == '') ? DECIMAL_SIGN : $commaSeparators;
            $thousandsSeparators =  ($commaSeparators == ".") ? "," : ".";            
            $strNumber = str_replace($thousandsSeparators,"",$strNumber);
            $strNumber =  ($commaSeparators == ",") ? str_replace(",",".",$strNumber) : $strNumber ;
            return (float) $strNumber;
        }
    }

    if (!function_exists('formatNumber')){
        function formatNumber($number,$digitComma = 0,$commaSeparators=''){
            $commaSeparators = ($commaSeparators == '') ? DECIMAL_SIGN : $commaSeparators;
            $thousandsSeparators =  ($commaSeparators == ".") ? "," : ".";            
            echo number_format($number,$digitComma,$commaSeparators,$thousandsSeparators);
        }
    }
    if (!function_exists('getDbConfig')){
        function getDbConfig($key){
            $CI = & get_instance();
            $ssql ="select fst_value from config where fst_key = ? and fst_active = 'A'";
            $qr = $CI->db->query($ssql,[$key]);
            $rw = $qr->row();
            if ($rw){
                return $rw->fst_value;
            }
            return null;
        }
    }

    if (!function_exists('distance')){
        function distance($lat1, $lon1, $lat2, $lon2, $unit="M") {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                return 0;
            }else{
                $theta = floatval($lon1) - floatval($lon2);
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);
            
                if ($unit == "K") { //Kilo meter
                    return ($miles * 1.609344);
                } else if ($unit == "N") { //Nautical Miles<
                    return ($miles * 0.8684);
                } else if ($unit == "M") { //Meters
                    return ($miles * 1.609344 * 1000);
                } else { //Miles<
                    return $miles;
                }
            }
        }
    }

    if (!function_exists('calculateDisc')){
        function calculateDisc($strDisc,$amount){

            if ($strDisc == null || $strDisc ==""){
                $strDisc = "100";
            }
            $arrDisc = explode("+",$strDisc);    
            $totalDisc = 0;
            foreach($arrDisc as $disc){
                $disc = trim($disc);
                $discAmount = $amount * ($disc/100);
                $totalDisc +=  $discAmount;
                $amount = $amount - $discAmount;
            }
            return $totalDisc;
        }
    }

    function visit_day_name($day){
        switch ($day) {
            case 1:
                return lang("Senin");
                break;
            case 2:
                return lang("Selasa");
                break;
            case 3:
                return lang("Rabu");
                break;
            case 4:
                return lang("Kamis");
                break;
            case 5:
                return lang("Jumat");
                break;
            case 6:
                return lang("Sabtu");
                break;
            case 7:
                return lang("Minggu");
                break;
        }

    }