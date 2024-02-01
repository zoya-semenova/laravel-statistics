<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class FunctionHelper{

    public static function arrayValues($array) {
        foreach ($array as $k => $val) {
            if (is_array($val))
                $array[$k] = self::arrayValues($val);
        }
        return isset($k) && (is_numeric($k) || empty($k)) ? array_values($array) : $array;
    }

    public static function getLink($section, $param) {
        $link = !empty($param->url) ? $param->url : (!empty($param->id) ? $param->id : '');
        return '/'.$section.'/'.($link ? $link : '');
    }

    public static function curl($url, array $body, $httpMethods='GET', $headers=[], $useragent='cURL',  $follow_redirects=true, $debug=false){
                $ch = curl_init();

                $bobbyGet = http_build_query($body, '', '&');

                //dd($url.'?'.$bobbyGet);
                switch ($httpMethods) {
                  case 'GET':
                    curl_setopt($ch, CURLOPT_URL, $url.'?'.$bobbyGet);
                  break;

                  case 'POST':
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    if($headers && !empty($headers) && in_array("Content-Type: application/json", $headers)){
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                    }else{
                      $bobyGet = http_build_query($body, '', '&');
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $bobyGet);
                    }
                  break;

                  case 'DELETE':
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                  break;

                  default:;
                    curl_setopt($ch, CURLOPT_URL, $url.'?'.$bobbyGet);
                  break;
                }

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                if(!empty($headers) && is_array($headers)){
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                }

                if ($follow_redirects==true) {
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                }

                if ($debug==true) {
                    $result['contents']=curl_exec($ch);
                    $result['info']=curl_getinfo($ch);
                }else {
                    $result=curl_exec($ch);
                }

                curl_close($ch);
                return $result;
    }

    /**
     *
     * @param string $datetime   - date("Y-m-d H:i:s") // 2001-03-10 17:16:18 (формат MySQL DATETIME)
     * @param string $month_word - "y" или "n" или "short"
     * @param string $time_show  - "y" или "n"
     * @param string $year  - "y" или "n" - Убирает/Добавляет год вконце. По умолчания добавляет.
     * @return string
     */
    public static function datePrepareToList($datetime, $month_word='y', $time_show = 'n', $year ='y') {
        $months = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];
        $datetimeArray = explode(' ', $datetime);

        $dateArrayYMD = explode('-', $datetimeArray[0]);
        $day = $dateArrayYMD[2];

        if ($month_word === 'y' || $month_word === 'short') {
            if ($month_word === 'short' && mb_strlen($months[$dateArrayYMD[1]]) > 4) {
                $month = mb_substr($months[$dateArrayYMD[1]], 0, 3);
            } else {
                $month = $months[$dateArrayYMD[1]];
            }
        } else {
            $month = $dateArrayYMD[1];
        }

        if ($year == 'y') {
            $year = $dateArrayYMD[0];
        } else {
            $year = '';
        }

        if ($month_word === 'y'|| $month_word === 'short') {
            $dateword = $day.' '.$month.' '.$year;
        } else {
            $year = empty($year) ? $year : ".{$year}";
            $dateword = $day.'.'.$month.$year;
        }

        if ($time_show === 'y') {
            $timeArrayHIS = explode(':', $datetimeArray[1]);
            $dateword = trim($dateword);
            $dateword.= ' '.$timeArrayHIS[0].':'.$timeArrayHIS[1];
        }

        return $dateword;
    }

    public static function getFilePath($fileField){
        if(!empty($fileField)){
            if(is_string($fileField) && Storage::disk('public')->exists($fileField)){
                $image = env('APP_URL').Storage::url($fileField);
            }else{
                if($fileField->isNotEmpty()){
                    foreach($fileField AS $id=>$img){
                        if (Storage::disk('public')->exists($img)) {
                            $image[$id]['id'] = $id+1;
                            $image[$id]['image'] = env('APP_URL').Storage::url($img);
                        }
                    }
                }
            }
        }
        return $image ?? '';
    }

}
