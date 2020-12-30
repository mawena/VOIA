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

    /**
     * Vérifie si une adresse mail est valide
     *
     * @param string $email
     * @return boolean
     */
    public static function isValidateEmail(string $email = null){
        if($email == null){
            return False;
        }else{
            $apiKey = "60a5232b7b0d2683db2a45f87d5723be";
            $currentApiUrl = "http://apilayer.net/api/check?access_key=". $apiKey ."&email=" . $email . "&smtp=1&format=1";
            $response = (get_object_vars(json_decode(file_get_contents($currentApiUrl))));
            return ($response["smtp_check"]);
        }
    }
}
