<?php

namespace App\Libraries;

class Helper
{
    /**
     * Retourne l'url de base du site
     *
     * @return void
     */
    public static function getBaseUrl()
    {
        return "http://localhost:85";
        // return "http://voia1.ghiyadaafrica.org";
    }


    public static function remainDays($sub_date, $duration)
    {
        $secondes_total =  $duration - (time() - $sub_date);
        $days = 0;

        if ($secondes_total > 0) {
            $days = floor($secondes_total / (60 * 60 * 24));
        } else {
            return 0;
        }
        return $days;
    }

    public static function pourcentage($pack, $nbre_fileuls = 0)
    {
        $nbre_fileuls_total = 1;

        switch ($pack) {
            case 5000:
                $nbre_fileuls_total = 10;
                break;
            case 10000:
                $nbre_fileuls_total = 5;
                break;

            default:
                break;
        }

        return ($nbre_fileuls * 100) / $nbre_fileuls_total;
    }

    public static function pourcentage2($nbre_fileuls1 = 0, $nbre_fileuls2 = 0)
    {
        $percent = (($nbre_fileuls1 * 0.5 + $nbre_fileuls2) * 100) / 5;
        if ($percent > 100) {
            return 100;
        } else {
            return $percent;
        }
    }


    public static function pourcentage3($pack, $type, $nbre_fileuls1, $nbre_fileuls2)
    {
        $percentage = null;

        if ($type == "communicateur") {
            return [0 => Helper::pourcentage(5000, $nbre_fileuls1), 1 => Helper::pourcentage(10000, $nbre_fileuls2)];
        } else if ($type == "normal") {
            if ($pack == '5000') {
                return [0 => Helper::pourcentage('5000', $nbre_fileuls1 + $nbre_fileuls2)];
            } else if ($pack == '10000') {
                return [0 => Helper::pourcentage2($nbre_fileuls1, $nbre_fileuls2)];
            }
        }
    }
}
