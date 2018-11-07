<?php
/**
 *          :::    ::: ::: ::::    :::  ::::::::  :::::::::   ::::::::   ::::   :::::
 *         :+:   :+:  :+: :+:+:   :+: :+:    :+: :+:    :+: :+:    :+:  :+:+: :+:+:+
 *        +:+  +:+   +:+ :+:+:+  +:+ +:+        +:+    +:+ +:+    +:+ +:+ +:+:+ +:+
 *       +#++:++    +#+ +#+ +:+ +#+ :#:        +#+    +:+ +#+    +:+ +#+  +:+  +#+
 *      +#+  +#+   +#+ +#+  +#+#+# +#+   +#+# +#+    +#+ +#+    +#+ +#+       +#+
 *     #+#   #+#  #+# #+#   #+#+# #+#    #+# #+#    #+# #+#    #+# #+#       #+#
 *    +++    +++ +++ +++    ++++  ++++++++  +++++++++   ++++++++  +++       +++
 * Vietisoguie - functions.php
 * Initial version by: kingdom
 * Email : mvi@vietiso.com
 * Initial version created on: 10/4/2018 - 10:03 AM
 */
function getTeaser($html)
{
    $html = removeHTML($html);
    $html = cut_string($html, 300);
    return $html;
}

function removeQuote($string)
{
    $sting = trim($string);
    $sting = str_replace("\'", "'", $sting);
    $sting = str_replace("'", "''", $sting);
    return $string;
}

function getValueArray($value, $array, $default = '')
{
    if (isset($array[$value])) return $array[$value];
    return $default;
}

function getUrlPage($array = array(), $removeKey = '')
{
    $url = '';
    foreach ($array as $key => $value) {
        $param = getValue($key, $value, "GET", "");
        if ($param != '' && $removeKey != $key) {
            $url .= '&' . $key . "=" . $param;
        }
    }
    return $url;
}


function callback($buffer)
{
    global $urlfile;
    global $check_cache;
    global $removeDau;
    // replace all the apples with oranges
    $str = array(chr(9), chr(10));
    $buffer = str_replace($str, "", $buffer);//bo dau tab
    $buffer = str_replace("        ", " ", $buffer);//bo dau tab
    if ($removeDau == 1) {
        $buffer = RemoveSign($buffer);
    }
    if ($check_cache == 1) {

        write_file($urlfile, str_replace(chr(13), "", $buffer));
    }
    return $buffer;
}

function randomkey($str, $keyword = 0)
{
    $return = '';
    $strreturn = explode(" ", trim($str));
    $i = 0;
    $listid = '';
    while ($i < count($strreturn)) {
        $id = rand(0, count($strreturn));
        if (strpos($listid, '[' . $id . ']') === false) {
            if (isset($strreturn[$id])) {
                $return .= $strreturn[$id] . ' ';
                $i++;
                if ($keyword == 1 && ($i % 2) == 0 && $i < count($strreturn)) $return .= ',';
                $listid .= '[' . $id . ']';
            }
        }
    }
    return $return;
}

function array_language()
{
    return array(1 => "vn"
    , 2 => "en");
}

function formatNumber($value, $type = "₫")
{
    global $con_currency;
    $str = number_format($value, 0, "", ".");
    return $str.' '.$type;
}
function beauty($temp){
    $temp = str_replace("\'", "'", $temp);
    $temp = str_replace("'", "''", $temp);
    return $temp;
}
function random()
{
    $rand_value = "";
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(65, 90));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    return $rand_value;
}

function str_encode($encodeStr = "")
{
    $returnStr = "";
    if ($encodeStr == '') return $encodeStr;
    if (!empty($encodeStr)) {
        $enc = base64_encode($encodeStr);
        $enc = str_replace('=', '', $enc);
        $enc = str_rot13($enc);
        $returnStr = $enc;
    }
    return $returnStr;
}

function str_decode($encodedStr = "", $type = 0)
{
    $returnStr = "";
    $encodedStr = str_replace(" ", "+", $encodedStr);
    if (!empty($encodedStr)) {
        $dec = str_rot13($encodedStr);
        $dec = base64_decode($dec);
        $returnStr = $dec;
    }
    return $returnStr;
}

function getURLR($mod_rewrite = 1, $serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    if ($mod_rewrite == 1) {
        return $_SERVER['REQUEST_URI'];
    } else {
        return getURL($serverName, $scriptName, $fileName, $queryString, $varDenied);
    }
}

function currentURL($remove = '')
{
    $url = '';
    $qString = $_SERVER['REQUEST_URI'];
    if (strpos($qString, '?') == FALSE) return $qString;
    $qString = explode('?', $qString);
    $url .= $qString[0];
    $get = explode('&', $qString[1]);
    $pre = '';
    foreach ($get as $value) {
        $val = explode('=', $value);
        if (!(in_array($val[0], $remove)) AND $val[1] != '') {
            if ($pre == '') {
                $pre = '?';
            } else {
                $pre = '&';
            }
            $url .= $pre . $val[0] . '=' . $val[1];
        }
    }
    return $url;
}

//hàm get URL
function getURL($serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    $url = '';
    $slash = '/';
    if ($scriptName != 0) $slash = "";
    if ($serverName != 0) {
        if (isset($_SERVER['SERVER_NAME'])) {
            $url .= 'http://' . $_SERVER['SERVER_NAME'];
            if (isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
            $url .= $slash;
        }
    }
    if ($scriptName != 0) {
        if (isset($_SERVER['SCRIPT_NAME'])) $url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($fileName != 0) {
        if (isset($_SERVER['SCRIPT_NAME'])) $url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($queryString != 0) {
        $dau = 0;
        $url .= '?';
        reset($_GET);
        if ($varDenied != '') {
            $arrVarDenied = explode('|', $varDenied);
            while (list($k, $v) = each($_GET)) {
                if (array_search($k, $arrVarDenied) === false) {
                    $url .= (($dau == 0) ? '' : '&') . $k . '=' . urlencode($v);
                    $dau = 1;
                }
            }
        } else {
            while (list($k, $v) = each($_GET)) $url .= '&' . $k . '=' . urlencode($v);
        }
    }
    $url = str_replace('"', '&quot;', strval($url));
    return $url;
}

function removethuoctinh($value)
{
    $value = str_replace("|", "", $value);
    $value = str_replace(";", "", $value);
    return $value;
}

function getKeyword($value)
{
    $value = str_replace("\'", "'", $value);
    $value = str_replace("'", "''", $value);
    $value = str_replace(" ", "%", $value);
    return $value;
}

//hàm getvalue : 1 tên biến; 2 kiểu; 3 phương thức; 4 giá trị mặc định; 5 remove quote
function getValue($value_name, $data_type = "int", $method = "GET", $default_value = 0, $advance = 0)
{
    $value = $default_value;
    switch ($method) {
        case "GET":
            if (isset($_GET[$value_name])) $value = $_GET[$value_name];
            break;
        case "POST":
            if (isset($_POST[$value_name])) $value = $_POST[$value_name];
            break;
        case "COOKIE":
            if (isset($_COOKIE[$value_name])) $value = $_COOKIE[$value_name];
            break;
        case "SESSION":
            if (isset($_SESSION[$value_name])) $value = $_SESSION[$value_name];
            break;
        case "POSTGET":
            if (isset($_POST[$value_name])) {
                $value = $_POST[$value_name];
            } elseif (isset($_GET[$value_name])) {
                $value = $_GET[$value_name];
            }
            break;
        default:
            if (isset($_GET[$value_name])) $value = $_GET[$value_name];
            break;
    }
    $valueArray = array("int" => intval($value), "str" => trim(strval($value)), "flo" => floatval($value), "dbl" => doubleval($value), "arr" => $value);
    foreach ($valueArray as $key => $returnValue) {
        if ($data_type == $key) {
            if ($advance != 0) {
                switch ($advance) {
                    case 1:
                        $returnValue = str_replace('"', '&quot;', $returnValue);
                        $returnValue = str_replace("\'", "'", $returnValue);
                        $returnValue = str_replace("'", "''", $returnValue);
                        break;
                    case 2:
                        $returnValue = htmlspecialbo($returnValue);
                        break;
                }
            }
            //Do số quá lớn nên phải kiểm tra trước khi trả về giá trị
            if ((strval($returnValue) == "INF") && ($data_type != "str")) return 0;
            return $returnValue;
            break;
        }
    }
    return (intval($value));
}

//loại bỏ hoạt động của các thẻ html, vô hiệu hóa
function htmlspecialbo($str)
{
    $arrDenied = array('<', '>', '"');
    $arrReplace = array('&lt;', '&gt;', '&quot;');
    $str = str_replace($arrDenied, $arrReplace, $str);
    return $str;
}

// loại bỏ các thẻ html, javascript
function removeHTML($str)
{
    $string = mb_convert_encoding($string, "UTF-8", "UTF-8");
    /*$string = preg_replace ('/<script.*?\>.*?<\/script>/si', ' ', $string);
	/$string = preg_replace ('/<style.*?\>.*?<\/style>/si', ' ', $string);
	$string = preg_replace ('/<.*?\>/si', ' ', $string);
	$string = str_replace ('&nbsp;', ' ', $string);
	//$string = html_entity_decode ($string);
	 */
    $AllowableHTML = array("b" => 1, "i" => 1, "strike" => 1, "div" => 2, "u" => 1, "a" => 2, "em" => 1, "br" => 1, "strong" => 1, "blockquote" => 1, "tt" => 1, "li" => 1, "ol" => 1, "ul" => 1);
    $AllowableHTML = array('');
    $str = strip_tags($str);
    $str = stripslashes($str);
    $str = preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/i", '<\\1>', $str);

    $str = preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>/i", '<a href="\\1">', $str);

    $str = preg_replace("/<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>/i", '', $str);

    $str = preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?javascript[[:punct:]]*\"?[^>]*>/i", '', $str);

    $tmp = "";
    while (@ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>", $str, $reg)) {
        $i = strpos($str, $reg[0]);
        $l = strlen($reg[0]);
        if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1], 1));
        else  $tag = strtolower($reg[1]);
        if ($a = $AllowableHTML[$tag])
            if ($reg[1][0] == "/") $tag = "</$tag>";
            elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
            else {

                $attrb_list = delQuotes($reg[2]);

                $attrb_list = str_replace("&", "&amp;", $attrb_list);
                $tag = "<$tag" . $attrb_list . ">";
            }

        else  $tag = "";
        $tmp .= substr($str, 0, $i) . $tag;
        $str = substr($str, $i + $l);
    }
    $str = $tmp . $str;
    return $str;
    exit;

    $str = ereg_replace("<\?", "", $str);
    return $str;
}

// hàm redirect : 1 url
function redirect($url, $http = 0)
{
    $url = str_replace("'", "\'", $url);
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $url . '";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    echo '</noscript>';
    exit;
    exit();
}

//hàm cắt chuổi
function cut_string($str, $length)
{
    if (mb_strlen($str, "UTF-8") > $length) return mb_substr($str, 0, $length, "UTF-8") . '...';
    else return $str;
}

function cutstring($str, $len, $more)
{
    if ($str == "" || $str == NULL) return $str;
    if (strlen($str) <= $len) return $str;
    $str = strip_tags($str);
    $str = trim($str);
    $str = substr($str, 0, $len);
    if ($str != "") {
        if (!substr_count($str, " ")) {
            if ($more) $str .= " ...";
            return $str;
        }
        while (strlen($str) && ($str[strlen($str) - 1] != " ")) {
            $str = substr($str, 0, -1);
        }
        $str = substr($str, 0, -1);
        if ($more) $str .= " ...";
    }
    return $str;
}

function length($str)
{
    return mb_strlen($str, "UTF-8");
}

//
function replaceMQ($text)
{
    $text = str_replace("\'", "'", $text);
    $text = str_replace("'", "''", $text);
    return $text;
}

function RemoveSign($str)
{
    $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
        "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
    , "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
    , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
    , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ", "ê", "ù", "à");

    $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
    , "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
    , "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
    , "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
    , "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D", "e", "u", "a");
    return str_replace($coDau, $khongDau, $str);
}

function removeKey($string)
{
    $string = trim(preg_replace("/[^A-Za-z0-9àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠÙÚỤỦŨƯỪỨỰỬỮỲÝỴỶỸ]/i", " ", $string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = mb_convert_encoding($string, "UTF-8", "UTF-8");
    return $string;
}

function removeTitle($string, $keyReplace)
{
    $string = RemoveSign($string);
    //neu muon de co dau
    //$string 	=  trim(preg_replace("/[^A-Za-z0-9àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠÙÚỤỦŨƯỪỨỰỬỮỲÝỴỶỸ]/i"," ",$string));

    $string = trim(preg_replace("/[^A-Za-z0-9]/i", " ", $string)); // khong dau
    $string = str_replace(" ", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace($keyReplace, "-", $string);
    return $string;
}

function generate_sort($type, $sort, $current_sort, $image_path)
{
    if ($type == "asc") {
        $title = "Tăng dần";
        if ($sort != $current_sort) $image_sort = "sortasc.gif";
        else $image_sort = "sortasc_selected.gif";
    } else {
        $title = "Giảm dần";
        if ($sort != $current_sort) $image_sort = "sortdesc.gif";
        else $image_sort = "sortdesc_selected.gif";
    }
    return '<a title="' . $title . '" href="' . getURL(0, 0, 1, 1, "sort") . '&sort=' . $sort . '"><img border="0" vspace="2" src="' . $image_path . $image_sort . '" /></a>';
}

function getKeyRef($query, $keyname = "q")
{
    $strreturn = '';
    preg_match("#" . $keyname . "=(.*)#si", $query, $match);
    if (isset($match[1])) $strreturn = preg_replace('#\&(.*)#si', "", $match[1]);
    return urldecode($strreturn);
}

//ham ma hoa
function fSencode($encodeStr = "")
{
    $returnStr = "";
    if (!empty($encodeStr)) {
        $enc = base64_encode($encodeStr);
        $enc = str_replace('=', '', $enc);
        $enc = str_rot13($enc);
        $returnStr = $enc;
    }

    return $returnStr;
}

//ham giai mai
function fSdecode($encodedStr = "", $type = 0)
{
    $returnStr = "";
    $encodedStr = str_replace(" ", "+", $encodedStr);
    if (!empty($encodedStr)) {
        $dec = str_rot13($encodedStr);
        $dec = base64_decode($dec);
        $returnStr = $dec;
    }
    switch ($type) {
        case 0:
            $returnStr = str_replace("\'", "'", $returnStr);
            $returnStr = str_replace("'", "''", $returnStr);
            return $returnStr;
            break;
        case 1:
            return intval($returnStr);
            break;
        case 3:
            return doubleval($returnStr);
            break;
    }
}

function int_to_words($x)
{
    $nwords = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy",
        "tám", "chín", "mười", "mười một", "mười hai", "mười ba",
        "mười bốn", "mười lăm", "mười sáu", "mười bảy", "mười tám",
        "mười chín", "hai mươi", 30 => "ba mươi", 40 => "bốn mươi",
        50 => "năm mươi", 60 => "sáu mươi", 70 => "bảy mươi", 80 => "tám mươi",
        90 => "chín mươi");
    if (!is_numeric($x)) {
        $w = '#';
    } else if (fmod($x, 1) != 0) {
        $w = '#';
    } else {
        if ($x < 0) {
            $w = 'minus ';
            $x = -$x;
        } else {
            $w = '';
        }
        if ($x < 21) {
            $w .= $nwords[$x];
        } else if ($x < 100) {
            $w .= $nwords[10 * floor($x / 10)];
            $r = fmod($x, 10);
            if ($r > 0) {
                $w .= ' ' . $nwords[$r];
            }
        } else if ($x < 1000) {
            $w .= $nwords[floor($x / 100)] . ' trăm';
            $r = fmod($x, 100);
            if ($r > 0) {
                $w .= '  ' . int_to_words($r);
            }
        } else if ($x < 1000000) {
            $w .= int_to_words(floor($x / 1000)) . ' ngàn';
            $r = fmod($x, 1000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $w .= ' ';
                }
                $w .= int_to_words($r);
            }
        } else {
            $w .= int_to_words(floor($x / 1000000)) . ' triệu';
            $r = fmod($x, 1000000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $word .= ' ';
                }
                $w .= int_to_words($r);
            }
        }
    }
    return $w . '';
}

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array())
{
    $first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
    #remember that mktime will automatically correct if invalid dates are entered
    # for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
    # this provides a built in "rounding" feature to generate_calendar()

    $day_names = array(); #generate all the day names according to the current locale
    for ($n = 0, $t = (3 + $first_day) * 86400; $n < 7; $n++, $t += 86400) #January 4, 1970 was a Sunday
        $day_names[$n] = ucfirst(gmstrftime('%A', $t)); #%A means full textual day name

    list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
    $title = htmlentities(ucfirst($month_name)) . '&nbsp;' . $year;  #note that some locales don't capitalize month and day names

    #Begin calendar. Uses a real <caption>. See http://exp.org/archives/2002/07/03
    @list($p, $pl) = each($pn);
    @list($n, $nl) = each($pn); #previous and next links, if applicable
    if ($p) $p = '<span class="calendar-prev">' . ($pl ? '<a href="' . htmlspecialchars($pl) . '">' . $p . '</a>' : $p) . '</span>&nbsp;';
    if ($n) $n = '&nbsp;<span class="calendar-next">' . ($nl ? '<a href="' . htmlspecialchars($nl) . '">' . $n . '</a>' : $n) . '</span>';
    $calendar = '<table class="calendar">' . "\n" .
        '<caption class="calendar-month">' . $p . ($month_href ? '<a href="' . htmlspecialchars($month_href) . '">' . $title . '</a>' : $title) . $n . "</caption>\n<tr>";

    if ($day_name_length) { #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach ($day_names as $d)
            $calendar .= '<th abbr="' . htmlentities($d) . '">' . htmlentities($day_name_length < 4 ? substr($d, 0, $day_name_length) : $d) . '</th>';
        $calendar .= "</tr>\n<tr>";
    }

    if ($weekday > 0) $calendar .= '<td colspan="' . $weekday . '">&nbsp;</td>'; #initial 'empty' days
    for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
        if ($weekday == 7) {
            $weekday = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if (isset($days[$day]) and is_array($days[$day])) {
            @list($link, $classes, $content) = $days[$day];
            if (is_null($content)) $content = $day;
            $calendar .= '<td' . ($classes ? ' class="' . htmlspecialchars($classes) . '">' : '>') .
                ($link ? '<a href="' . htmlspecialchars($link) . '">' . $content . '</a>' : $content) . '</td>';
        } else $calendar .= "<td>$day</td>";
    }
    if ($weekday != 7) $calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>'; #remaining "empty" days

    return $calendar . "</tr>\n</table>\n";
}

function check_parent_cat($idCat)
{
    $strCat = "SELECT cat_id, cat_parent_id 
					FROM categories_multi 
					WHERE cat_id = " . $idCat . "";
    $db_cat = new db_query($strCat);
    if (mysqli_num_rows($db_cat->result)) {
        $cat = mysqli_fetch_assoc($db_cat->result);
        $list_cat = "";
        if ($cat['cat_parent_id'] == 0) {
            $db_sub_cat = new db_query("SELECT cat_id, cat_parent_id 
												FROM categories_multi 
												WHERE cat_parent_id = " . $idCat . "");

            $sub_cat_total = mysqli_num_rows($db_sub_cat->result);
            if ($sub_cat_total) {
                $i = 0;
                while ($sub_cat = mysqli_fetch_assoc($db_sub_cat->result)) {
                    $i++;
                    if ($i < $sub_cat_total) {
                        $list_cat .= $sub_cat['cat_id'] . ",";
                    } else {
                        $list_cat .= $sub_cat['cat_id'];
                    }
                }
            } else {
                return $idCat;
            }
        } else {
            return $idCat;
        }
    }

    return $list_cat;

}

function type_cat($iCat)
{

    $db_cat = new db_query("SELECT cat_type  FROM  categories_multi
									 WHERE cat_id = " . $iCat);
    $cat = mysqli_fetch_assoc($db_cat->result);
    return $cat['cat_type'];
}

function name_cat($iCat)
{

    $db_cat = new db_query("SELECT cat_name  FROM  categories_multi
									 WHERE cat_id = " . $iCat);
    $cat = mysqli_fetch_assoc($db_cat->result);
    return $cat['cat_name'];
}

function path_cat($iCat)
{
    $strCat = '	 SELECT cat_rewrite  
				 FROM  categories_multi
				 WHERE cat_id = ' . $iCat;
    $db_cat = new db_query($strCat);
    $cat = mysqli_fetch_assoc($db_cat->result);
    return $cat['cat_rewrite'];
}

function name_video($id)
{
    global $lang_id;
    $db_video = new db_query("	SELECT vid_title  FROM  video
								WHERE vid_id = '" . intval($id) . "' AND lang_id = '" . $lang_id . "'");
    $video = mysqli_fetch_assoc($db_video->result);
    return $video['vid_title'];
}

function name_contract($id)
{
    $db_contract = new db_query("SELECT con_name  FROM  contracts WHERE con_id = " . $id);
    $contract = mysqli_fetch_assoc($db_contract->result);
    return $contract['con_name'];
}

function name_city($idCity, $option = 0)
{
    $db_city = new db_query("SELECT cit_name FROM city WHERE cit_parent_id = " . $option . " AND cit_id = " . $idCity);
    $city = mysqli_fetch_assoc($db_city->result);
    return $city['cit_name'];
}

function getUsername($user_id)
{
    $db_ex = new db_query("SELECT use_name FROM users WHERE userid = " . $user_id);
    if ($row2 = mysqli_fetch_assoc($db_ex->result)) {
        return $row2["use_name"];
    } else {
        return 0;
    }
}


function check_html($str, $strip = "nohtml")
{
    global $datafold;

    $AllowableHTML = array("b" => 1, "i" => 1, "strike" => 1, "div" => 2, "u" => 1, "a" => 2, "em" => 1, "br" => 1, "strong" => 1, "blockquote" => 1, "tt" => 1, "li" => 1, "ol" => 1, "ul" => 1);
    if ($strip == "nohtml") {
        $AllowableHTML = array('');
        $str = strip_tags($str);
    }
    $str = stripslashes($str);
    $str = preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/i", '<\\1>', $str);

    $str = preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>/i", '<a href="\\1">', $str);

    $str = preg_replace("/<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>/i", '', $str);

    $str = preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?javascript[[:punct:]]*\"?[^>]*>/i", '', $str);

    $tmp = "";
    while (@ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>", $str, $reg)) {
        $i = strpos($str, $reg[0]);
        $l = strlen($reg[0]);
        if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1], 1));
        else  $tag = strtolower($reg[1]);
        if ($a = $AllowableHTML[$tag])
            if ($reg[1][0] == "/") $tag = "</$tag>";
            elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
            else {

                $attrb_list = delQuotes($reg[2]);

                $attrb_list = str_replace("&", "&amp;", $attrb_list);
                $tag = "<$tag" . $attrb_list . ">";
            }

        else  $tag = "";
        $tmp .= substr($str, 0, $i) . $tag;
        $str = substr($str, $i + $l);
    }
    $str = $tmp . $str;
    return $str;
    exit;

    $str = ereg_replace("<\?", "", $str);
    return $str;
}

// GET COST FOR WORD
function str_count($p_str)
{
    $m_str = trim($p_str);
    if (!$m_str) return '';
    $m_arr_filter = array(',', '.', ';', "'", '"', '-'); //lọc ký tự đặc biệt
    $m_str = str_replace($m_arr_filter, '', $m_str);
    $m_arr_word = array_count_values(array_values(explode(' ', $m_str)));
    arsort($m_arr_word);
    return $m_arr_word;
}

//SHOW TAG
function printTagCloud($tags, $link = "")
{
    // $tags is the array

    arsort($tags);

    // largest and smallest array values
    $max_qty = max(array_values($tags));
    $min_qty = min(array_values($tags));

    // find the range of values
    $spread = $max_qty - $min_qty;
    if ($spread == 0) { // we don't want to divide by zero
        $spread = 1;
    }

    // set the font-size increment
    $step = ($max_size - $min_size) / ($spread);

    // loop through the tag array
    $count = count($tags);
    $d = 0;
    $content_tag = "";
    foreach ($tags as $key => $value) {
        $d++;
        $size = round($min_size + (($value - $min_qty) * $step));
        $content_tag .= '<a href="' . $link . $key . '" title="' . $key . '">' . $key . '</a> ';
        if ($d < $count) {
            $content_tag .= " ,";
        }
    }
    return $content_tag;
}

function strip_symbols($text)
{
    $plus = '\+\x{FE62}\x{FF0B}\x{208A}\x{207A}';
    $minus = '\x{2012}\x{208B}\x{207B}';

    $units = '\\x{00B0}\x{2103}\x{2109}\\x{23CD}';
    $units .= '\\x{32CC}-\\x{32CE}';
    $units .= '\\x{3300}-\\x{3357}';
    $units .= '\\x{3371}-\\x{33DF}';
    $units .= '\\x{33FF}';

    $ideo = '\\x{2E80}-\\x{2EF3}';
    $ideo .= '\\x{2F00}-\\x{2FD5}';
    $ideo .= '\\x{2FF0}-\\x{2FFB}';
    $ideo .= '\\x{3037}-\\x{303F}';
    $ideo .= '\\x{3190}-\\x{319F}';
    $ideo .= '\\x{31C0}-\\x{31CF}';
    $ideo .= '\\x{32C0}-\\x{32CB}';
    $ideo .= '\\x{3358}-\\x{3370}';
    $ideo .= '\\x{33E0}-\\x{33FE}';
    $ideo .= '\\x{A490}-\\x{A4C6}';

    return preg_replace(
        array(
            // Remove modifier and private use symbols.
            '/[\p{Sk}\p{Co}]/u',
            // Remove math symbols except + - = ~ and fraction slash
            '/\p{Sm}(?<![' . $plus . $minus . '=~\x{2044}])/u',
            // Remove + - if space before, no number or currency after
            '/((?<= )|^)[' . $plus . $minus . ']+((?![\p{N}\p{Sc}])|$)/u',
            // Remove = if space before
            '/((?<= )|^)=+/u',
            // Remove + - = ~ if space after
            '/[' . $plus . $minus . '=~]+((?= )|$)/u',
            // Remove other symbols except units and ideograph parts
            '/\p{So}(?<![' . $units . $ideo . '])/u',
            // Remove consecutive white space
            '/ +/',
        ),
        ' ',
        $text);
}

function convertDate($date)
{
    $day = date('d', $date);
    $month = date('m', $date);
    $year = date('Y', $date);
    return mktime(0, 0, 0, $month, $day, $year);
}

function name_project($id)
{
    global $lang_id;
    $strSql = ' SELECT pro_id, pro_name
				FROM project
				WHERE pro_id=' . intval($id) . ' AND lang_id = "' . $lang_id . '" 	
				  ';
    $dbProject = new db_query($strSql);
    if (mysqli_num_rows($dbProject->result)) {
        $Project = mysqli_fetch_assoc($dbProject->result);
        return $Project['pro_name'];
    } else {
        return '';
    }
}

/*function isMenu($url){
	global $db;
	global $dLink;
	$module 	 = getValue('module','str','GET','');
	$arrayQuery  = explode('/',$url);
	$Rcat	     = str_replace('.html','',$arrayQuery[2]);
	$Rtype 		 = '';
	foreach($dLink as $value){
		if($value[0]==$Rcat){
			$Rtype = $value[1];
		}
	}
	if($Rtype==''){
		$strType = ' SELECT cat_type
					 FROM categories_multi
					 WHERE cat_active = 1 AND cat_md5 = \''.md5($Rcat).'\'
					 LIMIT 1
				   ';
		$dbType = new db_query($strType);
		$Type = mysqli_fetch_assoc($dbType->result);
		$Rtype	=	$Type['cat_type'];
	}
	if($Rtype	==	$module) {
		return 1;
	}
	return 0;
}*/
function isMenu($url)
{
    global $mRewrite;
    global $module;
    global $lang_id;
    $dLink = array();
    switch ($lang_id) {
        case 1:
            $dLink[1] = 'vn';
            break;
        case 2:
            $dLink[1] = 'en';
            break;
        case 3:
            $dLink[1] = 'ja';
            break;
    }
    $dLink[2] = getValue("Rcat", "str", "GET", "");
    $dLink[3] = getValue("Rdata", "str", "GET", "");
    $url = str_replace('.html', '', $url);
    $arrayQuery = explode('/', $url);
    //echo $url;
    if ($dLink[1] == $arrayQuery[1]) {
        $Link = $dLink[2];
        $uRcat = $arrayQuery[2];
        $Rcat = $uRcat;
        //echo $Link.'--------'.$Rcat; die;
        if ($Link == $Rcat && $dLink[3] == $arrayQuery[3]) {
            return 1;
        }
        $linkID = catID($Link);
        $rcatID = catID($Rcat);
        $linkType = type_cat($rcatID);
        $linkChild = getAllChild($rcatID, $linkType);
        $arrayChild = explode(',', $linkChild);
        if (in_array($linkID, $arrayChild) and $linkID != 0) {
            return 1;
        }
        if (in_array($Rcat, $mRewrite)) {
            foreach ($mRewrite as $key => $val) {
                if ($Rcat == $val) {
                    $mod = $key;
                    break;
                }
            }
            if ($module == $mod) {
                return 1;
            }
        }
    }
    return 0;
}

function catID($Rcat)
{
    global $lang_id;
    $strSQL = ' SELECT cat_id
				FROM categories_multi
				WHERE cat_active = 1 AND lang_id = "' . $lang_id . '" AND cat_md5 = "' . md5($Rcat) . '"
				LIMIT 1
				';
    //echo $strSQL;
    $dbSQL = new db_query($strSQL);
    $dbSQL = new db_query($strSQL);
    $SQL = mysqli_fetch_assoc($dbSQL->result);
    return intval($SQL['cat_id']);
}

function nav_menu($parent = 0, $possition = 1, $ulFirst = '', $level = 0)
{
    global $lang_id;
    $strMenu = 'SELECT mnu_id, mnu_name, mnu_link, mnu_target 
				FROM menus_multi 
				WHERE mnu_parent_id = \'' . $parent . '\' AND mnu_position = ' . $possition . ' AND lang_id = ' . $lang_id . '
				ORDER BY mnu_order ASC';
    $dbMenu = new db_query($strMenu);
    $str = '';
    $numrow = mysqli_num_rows($dbMenu->result);
    if ($numrow) {
        $d = 0;
        if ($parent != 0) {
            $str .= '<ul>';
        } else {
            $str .= '<ul ' . $ulFirst . '>';
        }
        /*<li><a class="mt_it" href="#"><span>Tư vấn</span></a>
				<ul>
					<li class="sub_it"><a href="#"><span>Tư vấn đầu tư</span></a></li>
					<li class="sub_it"><a href="#"><span>Tư vấn mua</span></a></li>
					<li class="sub_it"><a href="#"><span>BĐS Cần thuê</span></a></li>
					<li class="sub_it"><a href="#"><span>BĐS Cho thuê</span></a></li>
				</ul>
			</li>*/
        while ($Menu = mysqli_fetch_assoc($dbMenu->result)) {
            $d++;
            $next_level = $level + 1;
            if ($level > 0) {
                $class_li_level = ' class="sub_it"';
                $class_a_level = ' ';
            } else {
                $class_li_level = ' ';
                $class_a_level = ' class="mt_it"';
            }
            $str .= '<li' . $class_li_level . '><a' . $class_a_level . '" href="' . $Menu['mnu_link'] . '" target="' . $Menu['mnu_target'] . '"><span>' . $Menu['mnu_name'] . '</span></a>';
            $str .= nav_menu($Menu['mnu_id'], $possition, '', $next_level);
            $str .= '</li>';
            if ($parent == 0 AND $d < $numrow AND $space != '' AND $level == 0) {
                $str .= $space;
            }
        }
        $str .= '</ul>';
    }
    return $str;
}

/*+---------------------------------------------------------------------------------+/*
/*|  																				|/*
/*+---------------------------------------------------------------------------------+*/
function getAllChild($idCat, $type = 'product')
{
    global $lang_id;
    $menu = new menu();
    $listAll = $menu->getAllChild('categories_multi', 'cat_id', 'cat_parent_id', $idCat, ' cat_type = "' . $type . '" AND cat_active = 1 AND lang_id = ' . $lang_id, 'cat_id', 'cat_type ASC,cat_order ASC, cat_name ASC', 'cat_has_child');
    if ($listAll == '') $listAll = array();
    $listCat = '';
    foreach ($listAll as $i => $cat) {
        $listCat .= $cat['cat_id'] . ',';
    }
    if ($listCat != '') return $listCat . $idCat;
    else return $idCat;
}

function format_bytes($bytes)
{
    if ($bytes < 1024) return $bytes . ' B';
    elseif ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
    elseif ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB';
    elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2) . ' GB';
    else return round($bytes / 1099511627776, 2) . ' TB';
}

//In danh sach anh vua BDS
//@id: 	Land ID
//@Type:	0:danh sach anh trong quan tri
//			1: Gallery anho
//
function landPicure($id, $type = 0, $vip = 1, $title = '', $description = '')
{
    global $lang_id;
    $limit = 3;
    if ($vip) {
        $limit = 6;
    }
    $strLandPicture = ' SELECT lpt_id, lpt_picture, lpt_lands
					  	FROM land_picture
						WHERE lang_id = ' . $lang_id . ' AND lpt_lands = ' . intval($id) . ' 
						ORDER BY lpt_order ASC, lpt_id ASC   
						LIMIT ' . $limit . '
					  ';
    //echo $strLandPicture;
    $dbLandPicture = new db_query($strLandPicture);
    if (mysqli_num_rows($dbLandPicture->result)) {
        $strHMTL = '';
        switch ($type) {
            case 1:
                $strHTML .= '<script type="text/javascript" src="/js/jquery.history.js"></script>';
                $strHTML .= '<script type="text/javascript" src="/js/jquery.galleriffic.js"></script>';
                $strHTML .= '<script type="text/javascript" src="/js/jquery.opacityrollover.js"></script>';
                $strHTML .= '<script type="text/javascript" src="/js/jquery.gallery.js"></script>';
                $strHTML .= '<div class="gallery">';
                $strHTML .= '	<div class="slideshow-container">';
                $strHTML .= '		<div id="controls" class="controls"></div>';
                $strHTML .= '		<div id="loading" class="loader"></div>';
                $strHTML .= '		<div id="slideshow" class="slideshow"></div>';
                $strHTML .= '	</div>';
                $strHTML .= '	<div class="navigation-container">';
                $strHTML .= '		<div id="thumbs" class="navigation">';
                $strHTML .= '			<div class="gallery_space">&nbsp;</div>';
                $strHTML .= '			<div class="ul_nav">';
                $strHTML .= '				<ul class="thumbs noscript">';
                $d = 0;
                $fs_filepath = '/data/lands/';
                while ($LandPicture = mysqli_fetch_assoc($dbLandPicture->result)) {
                    $strHTML .= '	<li>';
                    $strHTML .= '		<a class="thumb" name="leaf" href="' . $fs_filepath . $LandPicture['lpt_picture'] . '" title="' . $title . '">';
                    $strHTML .= '			<img src="' . $fs_filepath . 'small_' . $LandPicture['lpt_picture'] . '" alt="' . $title . '" />';
                    $strHTML .= '		</a>';
                    $strHTML .= '		<div class="caption">';
                    $strHTML .= '			<div class="image-title">' . $title . '</div>';
                    $strHTML .= '			<div class="image-desc">' . $description . '</div>';
                    $strHTML .= '		</div>';
                    $strHTML .= '	</li>';
                }
                $strHTML .= '				</ul>';
                $strHTML .= '			</div>';
                $strHTML .= '			<div class="gallery_space">&nbsp;</div>';
                $strHTML .= '			<div class="gallery_control">';
                $strHTML .= '				<div class="gallery_control_up">';
                $strHTML .= '					<a class="pageLink prev" rel="nofollow" href="#" title="Previous">&nbsp;</a>';
                $strHTML .= '				</div>';
                $strHTML .= '				<div class="clear"></div>';
                $strHTML .= '				<div class="gallery_control_bg">&nbsp;</div>';
                $strHTML .= '				<div class="clear"></div>';
                $strHTML .= '				<div class="gallery_control_down">';
                $strHTML .= '					<a class="pageLink next" rel="nofollow" href="#" title="Next">&nbsp;</a>';
                $strHTML .= '				</div>	';
                $strHTML .= '			</div>';
                $strHTML .= '		</div>';
                $strHTML .= '	</div>';
                $strHTML .= '</div>';
                break;
            default:
                $d = 0;
                $fs_filepath = '../../../data/lands/';
                $fs_imagepath = '../../resource/images/';
                while ($LandPicture = mysqli_fetch_assoc($dbLandPicture->result)) {
                    $d++;
                    $strHTML .= '<div class="listItem" id="listItem_' . $LandPicture['lpt_id'] . '">';
                    $strHTML .= '<span id="' . $LandPicture['lpt_id'] . '" style="height:50px;position:relative;">';
                    $strHTML .= '	<span style="position:absolute;z-index:100;bottom:3px;right:5px">';
                    $strHTML .= '		<a onclick="if (confirm(\'' . translate_text("Bạn có chắc xóa ảnh không ?") . '\')){delete_pic(\'' . $LandPicture['lpt_id'] . '\');}" href="javascript:void(0)">';
                    $strHTML .= '			<img align="bottom" src="' . $fs_imagepath . 'cancel.png" border="0" /></a></span>';
                    $strHTML .= '	<span style="display:inline-block;margin-right:5px;">';
                    $strHTML .= '	<img style="margin-right:2px;" height="50" width="50" src="' . $fs_filepath . 'small_' . $LandPicture['lpt_picture'] . '"/></span>';
                    $strHTML .= '</span>';
                    $strHTML .= '</div>';
                }
        }
    }
    return $strHTML;
}

function numPictureLand($id)
{
    global $lang_id;
    $strLandPicture = ' SELECT lpt_id
					  	FROM land_picture
						WHERE lang_id = ' . $lang_id . ' AND lpt_lands = ' . intval($id) . ' 
					  ';
    $dbLandPicture = new db_query($strLandPicture);
    return intval(mysqli_num_rows($dbLandPicture->result));
}

function landVideo($id, $active = 0)
{
    global $lang_id;
    global $con_static_video;
    if ($active) {
        $strVideo = ' SELECT vid_title,vid_picture,vid_source, vid_teaser
					  FROM video 
					  WHERE vid_id = "' . intval($id) . '" AND lang_id = "' . $lang_id . '" AND vid_active = 1 
					  LIMIT 1 	
					';
        $strHTML = '';
        $dbVideo = new db_query($strVideo);
        $Video = mysqli_fetch_assoc($dbVideo->result);
        $strHTML .= '<div class="clear"></div>';
        $strHTML .= '<script type="text/javascript" src="/js/swfobject.js"></script>';
        $strHTML .= '<div id="mediaspace">Video</div>';
        $strHTML .= '<script type="text/javascript">';
        $strHTML .= '  var so = new SWFObject("/player/player.swf","mpl","605","340","9");';
        $strHTML .= '  so.addParam("allowfullscreen","true");';
        $strHTML .= '  so.addParam("allowscriptaccess","always");';
        $strHTML .= '  so.addParam("wmode","opaque");';
        $strHTML .= '  so.addVariable("author","VK Housing");';
        $strHTML .= '  so.addVariable("description","' . removeHTML($Video['vid_teaser']) . '");';
        $strHTML .= '  so.addVariable("file","/data/video/' . $Video['vid_source'] . '");';
        $strHTML .= '  so.addVariable("title","' . $Video['vid_title'] . '");';
        $strHTML .= '  so.addVariable("image","/data/video/' . $Video['vid_picture'] . '");';
        $strHTML .= '  so.addVariable("skin","/player/skin/stijl.zip");';
        $strHTML .= '  so.addVariable("autostart","false");';
        $strHTML .= '  so.write("mediaspace");';
        $strHTML .= '</script>';
        $strHTML .= '<div class="clear"></div>';
        $strHTML .= '<div class="video_title"><span><h1>' . $Video['vid_title'] . '</h1></span></div>	';
        return $strHTML;
    } else {
        return getStatic($con_static_video);
    }
}

function landMap($arrayInfo)
{
    if ($arrayInfo['lan_latitude'] != '' AND $arrayInfo['lan_longitude'] != '' AND $arrayInfo['lan_map']) {
        $strHTML .= '<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAtjLSAIL6CkVLFJsTfkd3RBSNSn5tfkTukT7dxs_xvKkRHkDu-xThHF7c2DCNovV5wTywMvNCCNNgUQ&amp;language=vn"></script>';
        $strHTML .= '	<script type="text/javascript">';
        $strHTML .= '		google.load("maps", "2.x");';
        $strHTML .= '		function initialize() {';
        $strHTML .= '		  if (GBrowserIsCompatible()) {';
        $strHTML .= '			var map = new GMap2(document.getElementById("lan_map"));';
        $strHTML .= '			map.addControl(new GMapTypeControl());';
        $strHTML .= '			map.addControl(new GLargeMapControl3D());';
        $strHTML .= '			var focusPlace = new GLatLng(' . $arrayInfo['lan_latitude'] . ',' . $arrayInfo['lan_longitude'] . ');';
        $strHTML .= '			marker = new GMarker(focusPlace);';
        $strHTML .= '			map.addOverlay(marker);';
        $strHTML .= '			map.setCenter(focusPlace, 13);';
        $strHTML .= '			var strHTML = $(\'#map_info\').html();';
        $strHTML .= '			var xHTML	= strHTML;';
        $strHTML .= '			var latlng  = new GLatLng(' . $arrayInfo['lan_latitude'] . ',' . $arrayInfo['lan_longitude'] . ');';
        $strHTML .= '			GEvent.addListener(marker,"click", function() {';
        $strHTML .= '				map.openInfoWindowHtml(latlng, xHTML);';
        $strHTML .= '			  });';
        $strHTML .= '			map.openInfoWindow(latlng ,xHTML);';
        $strHTML .= '		  }';
        $strHTML .= '		}';
        $strHTML .= '	</script>';
        $strHTML .= '	<div id="lan_map"></div>';
        $strHTML .= '	<div class="hide" id="map_info">';
        $strHTML .= '		' . $arrayInfo['lan_title'] . '';
        $strHTML .= '		<div class="clear"><img src="/images/spacer.gif" border="0" width="1" height="10" /></div>';
        $strHTML .= '		' . translate('Địa chỉ') . ':  ' . $arrayInfo['lan_address'] . ', ' . name_city($arrayInfo['lan_district'], $arrayInfo['lan_province']) . ', ' . name_city($arrayInfo['lan_province']);
        $strHTML .= '	</div>';
    } else {
        $strHTML .= '	<script type="text/javascript">';
        $strHTML .= '		function initialize() {}';
        $strHTML .= '	</script>';
        $strHTML .= '	<div align="center">';
        $strHTML .= translate('Chức năng bản đồ chưa được kích hoạt. Bạn hãy liên hệ với ban quản trị.');
        $strHTML .= '	</div>';
    }
    return $strHTML;
}

function replaceFCK($string, $type = 0)
{
    $array_fck = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Igrave;", "&Iacute;", "&Icirc;",
        "&Iuml;", "&ETH;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ugrave;", "&Uacute;", "&Yacute;", "&agrave;",
        "&aacute;", "&acirc;", "&atilde;", "&egrave;", "&eacute;", "&ecirc;", "&igrave;", "&iacute;", "&ograve;", "&oacute;",
        "&ocirc;", "&otilde;", "&ugrave;", "&uacute;", "&ucirc;", "&yacute;",
    );
    $array_text = array("À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Î",
        "Ï", "Ð", "Ò", "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à",
        "á", "â", "ã", "è", "é", "ê", "ì", "í", "ò", "ó",
        "ô", "õ", "ù", "ú", "û", "ý",
    );
    if ($type == 1) $string = str_replace($array_fck, $array_text, $string);
    else $string = str_replace($array_text, $array_fck, $string);
    return $string;
}

function fwrite_stream($filename, $somecontent = '')
{
    if (is_writable($filename)) {
        if (!$handle = fopen($filename, 'w+')) {
            echo "Cannot open file ($filename) <br />";
            exit;
        }
        if (fwrite($handle, $somecontent) === FALSE) {
            echo "Cannot write to file ($filename) <br />";
            exit;
        }

        echo "Success, wrote  to file ($filename) <br />";

        fclose($handle);

    } else {
        echo "The file $filename is not writable <br />";
    }
}

function currentURL_Mobishop($getCanonical = '')
{
    global $module;
    global $iCat;
    global $iData;
    $url = $_SERVER['REQUEST_URI'];
    $extension = explode('?', $_SERVER['REQUEST_URI']);
    $extensionPage = '';
    if (isset($extension[1])) {
        $extensionPage = '?' . $extension[1];
        $url = $extension[0];
    }
    if ($iData > 0) {
        switch ($module) {
            case "static":
                $sqlSelect = " SELECT sta_id AS it_id,sta_rewrite AS it_rewrite,'" . $module . "' AS cat_type
									FROM statics 
									WHERE sta_id = " . $iData;
                break;
            case "tintuc":
                $sqlSelect = " SELECT new_id AS it_id,new_rewrite AS it_rewrite,'" . $module . "' AS cat_type
									FROM news 
									WHERE new_id = " . $iData;
                break;
            case "dienthoai":
            case "maytinhbang":
            case "phukien":
            case "sanphamkhac":
                $sqlSelect = " SELECT pro_id AS it_id,pro_rewrite AS it_rewrite,'" . $module . "' AS cat_type
									FROM products 
									WHERE pro_id = " . $iData;
                break;
            case "dichvu":
                $sqlSelect = " SELECT dvu_id AS it_id,dvu_rewrite AS it_rewrite,'" . $module . "' AS cat_type
									FROM dichvu 
									WHERE dvu_id = " . $iData;
                break;
        }
        $db_sql = new db_query($sqlSelect);
        if ($row = mysqli_fetch_assoc($db_sql->result)) {
            $url = createLink('detail', $row);
        }
    } elseif ($iCat > 0) {
        $sqlSelect = 'SELECT cat_type,cat_id,cat_rewrite FROM categories_multi WHERE cat_id = ' . $iCat;
        $db_sql = new db_query($sqlSelect);
        if ($cat = mysqli_fetch_assoc($db_sql->result)) {
            $url = createLink('cat', $cat);
        }
    }
    $url_new = $url . $extensionPage;
    if ($getCanonical == 'canonical') {
        $val = explode('?', $url);
        $url_new = $val[0];
    }
    return $url_new;
}
function createLink($arrayUrl=array(),$langpah='lang=en'){
    /*
    $menuReturn='';
    foreach($arrayUrl as $key=>$value){
            $menuReturn .= $key . '=' . $value . '&';
    }
    $linkUrl= 'index.php?'.$menuReturn.$langpah;

    $rule=array(
        '/'=> 'index.php?mod=home&act=default&lang=en',
        '/user/info/([0-9]*)'=> 'index.php?mod=user&act=profile&user_id=$1&lang=en',
    );

    $key = array_search ($linkUrl, $rule);
    return $menuReturn;
    */
}

function getCategoryParent($id, $listCat = array())
{
    $db_cat = new db_query("SELECT cat_id, cat_parent_id FROM categories_multi WHERE cat_parent_id = " . $id);
    $listCat = array_merge($listCat, array($id));
    while ($cat = mysqli_fetch_assoc($db_cat->result)) {
        $listCat = array_merge($listCat, array($cat['cat_id']));
        $listCat = getCategoryParent($cat['cat_id'], $listCat);
    }
    return array_unique($listCat);
}
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}
function unparse_url($parsed_url) {
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
}
function youtube($url, $width=560, $height=315, $fullscreen=true)
{
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    $youtube= '<iframe allowtransparency="true" scrolling="no" width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$my_array_of_vars['v'].'" frameborder="0"'.($fullscreen?' allowfullscreen':NULL).'></iframe>';
    return $youtube;
}
function getAllDirs($directory, $directory_seperator)
{
    $dirs = array_map(function ($item) use ($directory_seperator) {
        return $item . $directory_seperator;
    }, array_filter(glob($directory . '*'), 'is_dir'));
    foreach ($dirs AS $dir) {
        $dirs = array_merge($dirs, getAllDirs($dir, $directory_seperator));
    }
    return $dirs;
}



function getAllImgs($directory)
{
    $resizedFilePath = array();
    foreach ($directory AS $dir) {
        foreach (glob($dir . '*.jpg') as $filename) {
            array_push($resizedFilePath, $filename);
        }
    }
    return $resizedFilePath;
}
?>