<?php

namespace App\Models;

class About 
{
    private static $about = [
        "nama" => "Teguh Efriyanto",
        "jurusan" => "S1 Informatika"
    ];

    public static function about()
    {
        return collect(self::$about);
    }
}
