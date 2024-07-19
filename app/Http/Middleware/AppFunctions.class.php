<?php

namespace App\Http\Middleware\AppFunctions;

use App\Database\DB;
use LogModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . './../../Database/Database.class.php';

class AppFunctions
{
    public function generateToken()
    {
        $hex = random_bytes(24);
        $hex = bin2hex($hex);
        $hex = strtoupper($hex);
        $hex = wordwrap($hex, 8, '-', true);
        return $hex;
    }

    public function convertSlug($text)
    {
        return  preg_replace("/[^A-Za-z0-9\-\_ก-ฮเแ]/", '', $text);
    }

    public function debug($result)
    {
        return print("<pre>" . print_r($result, true) . "</pre>");
    }

    public function formatCard($id)
    {
        $one = substr($id, 0, 1);
        $onemore = $one . "-";
        $two = substr($id, 1, 4);
        $twomore = $two . "-";
        $three = substr($id, 5, 5);
        $threemore = $three . "-";
        $four = substr($id, 10, 2);
        $fourmore = $four . "-";
        $five = substr($id, 12, 1);
        $fivemore = $five;
        $oneid = str_replace($one, $onemore, $one);
        $twoid = str_replace($two, $twomore, $two);
        $threeid = str_replace($three, $threemore, $three);
        $fourid = str_replace($four, $fourmore, $four);
        $fiveid = str_replace($five, $fivemore, $five);

        $newid = $oneid . $twoid . $threeid . $fourid . $fiveid;;
        return $newid;
    }
}

class ConvertBaht
{

    public function convert($amount_number)
    {
        $amount_number = number_format($amount_number, 2, ".", "");
        $pt = strpos($amount_number, ".");
        $number = $fraction = "";
        if ($pt === false)
            $number = $amount_number;
        else {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = $this->readNumber($number);
        if ($baht != "")
            $ret .= $baht . "บาท";

        $satang = $this->readNumber($fraction);
        if ($satang != "")
            $ret .=  $satang . "สตางค์";
        else
            $ret .= "ถ้วน";
        return $ret;
    }

    public function readNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) return $ret;
        if ($number > 1000000) {
            $ret .= $this->readNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while ($number > 0) {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }
}

class DateThai
{
    public function timeDiff($strTime1, $strTime2)
    {
        return number_format((strtotime($strTime2) - strtotime($strTime1)) /  (60 * 60), 2); // 1 Hour =  60*60
    }

    public function datetimeFull($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay เดือน $strMonthThai  พ.ศ.$strYear เวลา $strHour:$strMinute";
    }

    public function dateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    public function timeThai($strTime)
    {
        $strHour = date("H", strtotime($strTime));
        $strMinute = date("i", strtotime($strTime));
        $strSeconds = date("s", strtotime($strTime));
        return "$strHour:$strMinute";
    }

    public function dateDiff($dateStart, $dateEnd, $return = 'full' || 'day' || 'time' || 'hour' || 'minute' || 'second')
    {
        $dateStart = strtotime($dateStart);
        $dateEnd = strtotime($dateEnd);
        $dateDiff = $dateEnd - $dateStart;
        $fullDays = floor($dateDiff / (60 * 60 * 24));
        $fullHours = floor(($dateDiff - ($fullDays * 60 * 60 * 24)) / (60 * 60));
        $fullMinutes = floor(($dateDiff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60)) / 60);
        $fullSeconds = floor(($dateDiff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60) - ($fullMinutes * 60)));
        switch ($return) {
            case 'full':
                return $fullDays . " วัน, " . $fullHours . " ชั่วโมง, " . $fullMinutes . " นาที, " . $fullSeconds . " วินาที";
                break;
            case 'days':
                return $fullDays;
                break;
            case 'hours':
                return $fullHours;
                break;
            case 'minutes':
                return $fullMinutes;
                break;
            case 'seconds':
                return $fullSeconds;
                break;
            case 'time':
                return $fullHours . ":" . $fullMinutes . ":" . $fullSeconds;
                break;
            default:
                return $fullDays . " วัน, " . $fullHours . " ชั่วโมง, " . $fullMinutes . " นาที, " . $fullSeconds . " วินาที";
                break;
        }
    }
}

class GetNotify
{
    public function lineNoti($fields = "", $token2 = "")
    {
        date_default_timezone_set("Asia/Bangkok");
        $url        = 'https://notify-api.line.me/api/notify';
        $token      = $token2;  //ใส่ token ที่นี่
        $headers    = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$fields");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);

        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        } else {
            $result = json_decode($res, TRUE);
            echo "status : " . $result['status'];
            echo "message : " . $result['message'];
        }
        curl_close($ch);
    }

    public function sentMail($subject1 = "", $sendmail = array(), $msg = array())
    {
        /**
         * $msg = [
         * ระบบแจ้งข้อความ อัตโนมัติ
         * ผู้ดูแลระบบ$subject ของ:
         * ท่านสามารถเข้าไปดูรายละเอียดเพิ่มเติมได้ที่
         * ]
         */
        require_once __DIR__ . './../../lib/autoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "...@gmail.com";
        $mail->Password = "...password";
        $mail->setFrom('...@gmail.com', 'ระบบ');
        foreach ($sendmail as $k => $v) {
            $mail->addAddress($v, '....system');
        }
        $mail->Subject = $subject1;
        $mail->CharSet = "utf-8";

        $mail->msgHTML($msg[0]);
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
