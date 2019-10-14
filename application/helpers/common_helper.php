<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('ccflogdata')) {

    function ccflogdata($username, $tablename, $action, $details) {
        $CI = & get_instance();
        $sessiondata = $CI->session->userdata('logindata');
        if ($sessiondata['companyid'] == ''):
            $companyid = '0';
        else:
            $companyid = $sessiondata['companyid'];
        endif;
        $CI->load->library('user_agent');
        #$device = 'Host Name: ' . gethostname();
        #$device = $device . '  | ' . 'OS: ' . $CI->agent->platform();
        if ($CI->agent->is_browser()) {
            $browser = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_robot()) {
            $browser = $CI->agent->robot();
        } elseif ($CI->agent->is_mobile()) {
            $browser = $CI->agent->mobile();
        } else {
            $browser = 'Undefined User Agent';
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        #$device = GetHostByName($ip);
        $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        #$locationinfo = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
        $location = "";
        #$location .= ' City: ' . $locationinfo->city . ' Region: ' . $locationinfo->region . ' Country: ' . $locationinfo->country;
        $timezone = +6; //(GMT -5:00) EST (U.S. & Canada)
        $gmtdate = gmdate("Y-m-d H:i:s", time() + 3600 * ($timezone + date("I")));
        $logdataarray = array(
            'username' => $username,
            'action' => $action,
            'device' => $device,
            'browser' => $browser,
            'ip' => $ip,
            'location' => $location,
            'details' => $details,
            'time' => $gmtdate,
            'companyid' => $companyid
        );
        $savestatus = $CI->db->insert($tablename, $logdataarray);
    }

}

if (!function_exists('convert_number_to_words')) {

    function convert_number_to_words($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Fourty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
            100 => 'Hundred',
            1000 => 'Thousand',
            1000000 => 'Million',
            1000000000 => 'Billion',
            1000000000000 => 'Trillion',
            1000000000000000 => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

}



// convert number to bangla format plugin 2

if (!function_exists('convert_number')) {

    function convert_number($num) {
  
        $res3 = "";
        if (strrpos($num, ".") > 0):
            $my_number = explode(".", $num);
            $number = $my_number[0];

            $pointnumber = $my_number[1];
        else:
            $number = $num;
            $pointnumber = 0;

        endif;


        if ($pointnumber > 0) {
            $pointlength = strlen($pointnumber);
            $Dn3 = floor($pointnumber / 10);       /* Tens (deca) */
            $n3 = $pointnumber % 10;

            $ones3 = array("", "One", "Two", "Three", "Four", "Five", "Six",
                "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                "Nineteen");
            $tens3 = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                "Seventy", "Eigthy", "Ninety");

            if ($Dn3 || $n3) {
                if (!empty($res3)) {
                    $res3 .= " And ";
                }

                if ($Dn3 < 2) {
                    if ($Dn3 == 0 && $pointlength != 1) {
                        $res3 .= "Zero ";
                        $res3 .= $ones3[$Dn3 * 10 + $n3];
                    } else if ($Dn3 == 0 && $pointlength == 1) {
                        $res3 .= $ones3[$Dn3 * 10 + $n3];
                        $res3 .= " Zero ";
                    } else {
                        $res3 .= $ones3[$Dn3 * 10 + $n3];
                    }
                } else {
                    $res3 .= $tens3[$Dn3];

                    if ($n3) {
                        $res3 .= "-" . $ones3[$n3];
                    }
                }
            }
            if (empty($res3)) {
                $res3 = "Zero";
            }
        } else {
            $res3 = "Zero";
        }

        if (($number < 0) || ($number > 999999999)) {

            $length = strlen($number);
            $prefix = substr($number, 0, $length - 7);
            $postfix = substr($number, $length - 7);

// for prefix
            $Gn = floor($prefix / 100000);  /* lakh  */
            $prefix -= $Gn * 100000;
            $kn = floor($prefix / 1000);     /* Thousands (kilo) */
            $prefix -= $kn * 1000;
            $Hn = floor($prefix / 100);      /* Hundreds (hecto) */
            $prefix -= $Hn * 100;
            $Dn = floor($prefix / 10);       /* Tens (deca) */
            $n = $prefix % 10;
// for postfix
            $Gn2 = floor($postfix / 100000);  /* lakh  */
            $postfix -= $Gn2 * 100000;
            $kn2 = floor($postfix / 1000);     /* Thousands (kilo) */
            $postfix -= $kn2 * 1000;
            $Hn2 = floor($postfix / 100);      /* Hundreds (hecto) */
            $postfix -= $Hn2 * 100;
            $Dn2 = floor($postfix / 10);       /* Tens (deca) */
            $n2 = $postfix % 10;

// for prefix
            $res = "";

            if ($Gn) {
                $res .= convert_number($Gn) . " Lakh";
            }

            if ($kn) {
                $res .= (empty($res) ? "" : " ") .
                        convert_number($kn) . " Thousand";
            }

            if ($Hn) {
                $res .= (empty($res) ? "" : " ") .
                        convert_number($Hn) . " Hundred";
            }

            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
                "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                "Nineteen");
            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                "Seventy", "Eigthy", "Ninety");

            if ($Dn || $n) {
                if (!empty($res)) {
                    $res .= " And ";
                }

                if ($Dn < 2) {
                    $res .= $ones[$Dn * 10 + $n];
                } else {
                    $res .= $tens[$Dn];

                    if ($n) {
                        $res .= "-" . $ones[$n];
                    }
                }
            }

            if (empty($res)) {
                $res = "Zero";
            }


// for postfix
            $res2 = "";

            if ($Gn2) {
                $res2 .= convert_number($Gn2) . " Lakh";
            }

            if ($kn2) {
                $res2 .= (empty($res2) ? "" : " ") .
                        convert_number($kn2) . " Thousand";
            }

            if ($Hn2) {
                $res2 .= (empty($res2) ? "" : " ") .
                        convert_number($Hn2) . " Hundred";
            }

            $ones2 = array("", "One", "Two", "Three", "Four", "Five", "Six",
                "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                "Nineteen");
            $tens2 = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                "Seventy", "Eigthy", "Ninety");

            if ($Dn2 || $n2) {
                if (!empty($res2)) {
                    $res2 .= " And ";
                }

                if ($Dn2 < 2) {
                    $res2 .= $ones2[$Dn2 * 10 + $n2];
                } else {
                    $res2 .= $tens2[$Dn2];

                    if ($n2) {
                        $res2 .= "-" . $ones2[$n2];
                    }
                }
            }

            if (empty($res2)) {
                $res2 = "Zero";
            }


            return $res . " Crore " . $res2 . " Taka And " . $res3 . " Paisa";

//      return "Number is out of range";
        } else {


            $Kt = floor($number / 10000000); /* Crore */
            $number -= $Kt * 10000000;
            $Gn = floor($number / 100000);  /* lakh  */
            $number -= $Gn * 100000;
            $kn = floor($number / 1000);     /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100);      /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10);       /* Tens (deca) */
            $n = $number % 10;               /* Ones */

            $res4 = "";
            $a = "";
            if ($Kt) {
                $res4 .= convert_number($Kt) . " Crore ";
            }
            if ($Gn) {
                $res4 .= convert_number($Gn) . " Lakh";
            }

            if ($kn) {
                $res4 .= (empty($res4) ? "" : " ") .
                        convert_number($kn) . " Thousand";
            }

            if ($Hn) {
                $res4 .= (empty($res4) ? "" : " ") .
                        convert_number($Hn) . " Hundred";
                $a = "last";
            }

            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
                "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
                "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
                "Nineteen");
            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
                "Seventy", "Eigthy", "Ninety");

            if ($Dn || $n) {
                if (!empty($res4)) {
                    $res4 .= " And ";
                }

                if ($Dn < 2) {
                    $res4 .= $ones[$Dn * 10 + $n];
                } else {
                    $res4 .= $tens[$Dn];

                    if ($n) {
                        $res4 .= "-" . $ones[$n];
                    }
                }
                
            }

            if (empty($res4)) {
                $res4 = "Zero";
            }


     
            if ($a == "last") {
                return $res4 . " Taka And " . $res3 . " Paisa";
            }
            return $res4;
        }
    }

}
//end convert number to bangla format plugin 2
?>