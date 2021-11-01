<?php

namespace App\Models;

class Home
{

    private static $home = [
        "cek" => "Cek",
        "plagiat" => "Plariarisme",
        "wartawan" => "Wartawan Online",
        "instagram" => "https://www.instagram.com/efrii__/?hl=en",
        "facebook" => "https://www.facebook.com/efrii.xrmblx/",
        "linkind" => "https://id.linkedin.com/in/teguh-efriyanto-164940140",
        "content" => "Demeter is a fantastic responsive web design template. With a clean and minimalist design, it's perfect as one-page portfolio concept for creative agencies and freelancers. This HTML website template includes 12 variants, such as"
    ];

    public static function home()
    {
        return collect(self::$home);
    }

}
