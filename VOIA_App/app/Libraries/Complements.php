<?php

namespace App\Libraries;

class Complements
{
    public function get_nav_li($content = "nav-link", $href = "#", $active = "active", $li_class = "nav-item", $a_class = "nav-link", $i_class = "fa")
    {
        $request = \Config\Services::request();
        $path = $request->uri->getPath();

        if ($path == $active) {
            return '<li class="' . $li_class . ' active" id="active"><a class="' . $a_class . '" href="' . $href . '"><i class="' . $i_class . '"> ' . $content . '</i></a></li>
            ';
        } else {
            return '<li class="' . $li_class . '"><a class="' . $a_class . '" href="' . $href . '"><i class="' . $i_class . '"> ' . $content . '</i></a></li>
            ';
        }
    }
}
