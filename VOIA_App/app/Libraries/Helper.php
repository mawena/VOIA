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
        // return "http://voia1.ghiyadaafrica.org";
        return "http://localhost:85";
    }

    /**
     * Vérifie si l'url est permit
     *
     * @param string $uri
     * @param array $validateURIArray
     * @return boolean
     */
    public static function isValidateURI($uri, $validateURIArray)
    {
        if ($validateURIArray == []) {
            return False;
        } else {
            $placeholders = [
                '(:any)'      => '.*',
                '(:segment)'  => '[^/]+',
                '(:alphanum)' => '[a-zA-Z0-9]+',
                '(:num)'      => '[0-9]+',
                '(:alpha)'    => '[a-zA-Z]+',
                '(:hash)'     => '[^/]+',
            ];
            foreach ($validateURIArray as $key => $validateURI) {
                foreach ($placeholders as $placeholder => $regexCode) {
                    if (strstr($validateURI, $placeholder)) {
                        $validateURIArray[$key] = str_replace($placeholder, $regexCode, $validateURI);
                    }
                }
            }
            foreach ($validateURIArray as $validateURI) {
                if (preg_match('#^' . $validateURI . '$#u', $uri, $matches)) {
                    return True;
                }
            }
            return False;
        }
    }
}
