<?php

namespace App\Libraries;

class Complements
{
    public function get_nav_li($content = "nav-link", $href = "#", $active = "active", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fa")
    {
        $session = \Config\Services::session();
        helper('url');
        $url_uri = uri_string();

        if (uri_string() == $active) {
            return '<li class="' . $li_class . ' active" id="active"><a class="' . $a_class . '" href="' . $href . '"><i class="' . $i_class . '"> ' . $content . '</i></a></li>
            ';
        } else {
            return '<li class="' . $li_class . '"><a class="' . $a_class . '" href="' . $href . '"><i class="' . $i_class . '"> ' . $content . '</i></a></li>
            ';
        }
    }
}
