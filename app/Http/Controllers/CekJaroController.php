<?php

namespace App\Http\Controllers;

use App\Models\Taghtml;
use App\Models\Stopword;
use Sastrawi\Stemmer\StemmerFactory;
use simplehtmldom\HtmlWeb;
use Illuminate\Http\Request;

class CekJaroController extends Controller
{

    public function input()
    {
        return view('cek-similarity', [
            "title" => "Cek Similarity"
        ]);
    }

    public function getHtml(Request $request)
    {

        // ini_set('max_execution_time', 380);

        // Membuat validasi bahwa input harus berupa URL dan Wajib Di isi
        $request->validate([
            'link_uji' => 'required|url',
        ]);

        $link_uji = $request->input('link_uji');

        /**
         * 
         * FUNGSI MENGAMBIL KATA KUNCI PECARIAN BERITA
         * 
         */
        function getKeySearch($string)
        {
            $meta = get_meta_tags($string);

            $data = strtolower($meta['keywords']);
            $daftar_kata = ['sampit', 'kecamatan', 'pemkab', 'bupati', ',', 'kepala', 'kifayah', 'fardu', 'mui', 'ketua', 'kotim'];
            $hapus = str_replace($daftar_kata, " ", $data);
            $space = preg_replace('/\s+/', ' ', $hapus);
            $space = trim($space);

            $data = str_replace(" ", "%20", $space);

            return $data;
        }


        /**
         * 
         * FUNGSI MENGAMBIL URL DATA BERITA INDEX KE 1
         * 
         */
        function GetUrlData1($string, $link_berita, $param)
        {
            $Query      = $string;
            $Num        = 2;
            $API_KEY    = 'AIzaSyA3J-1ZuKu8d7WoMyoFW12BmiCRQiCV-xE';
            $ID         = '907b295d015a55408';
            $timeout    = 0;

            $ch      = curl_init();

            echo 'https://www.googleapis.com/customsearch/v1/siterestrict?key=' . $API_KEY . '&cx=' . $ID . '&q=site:' . $link_berita . '%20intext:' . $Query . '&num=' . $Num . '&filter=1&gl=id';
            curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1/siterestrict?key=' . $API_KEY . '&cx=' . $ID . '&q=site:' . $link_berita . '%20intext:' . $Query . '&num=' . $Num . '&filter=1&gl=id');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            $data = curl_exec($ch);

            $data = json_decode($data, true);

            curl_close($ch);

            if (!empty($data['items'][$param])) {

                return $data['items'][$param];
            } else {

                echo ' Error Get Api ' . $link_berita . ' ';
            }
        }

        /**
         * 
         * FUNGSI MENGAMBIL URL DATA BERITA INDEX KE 2
         * 
         */

        function GetUrlData2($string, $link_berita, $param)
        {
            $Query      = $string;
            $Num        = 2;
            $API_KEY    = 'AIzaSyBiLGYE0VLm8A-vzBz71by6JNOK_IjcxBU';
            $ID         = 'd0d8d435cd904182f';

            $ch      = curl_init();
            $timeout = 0;

            echo 'https://www.googleapis.com/customsearch/v1/siterestrict?key=' . $API_KEY . '&cx=' . $ID . '&q=site:' . $link_berita . '%20intext:' . $Query . '&num=' . $Num . '&filter=1&gl=id';
            curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1/siterestrict?key=' . $API_KEY . '&cx=' . $ID . '&q=site:' . $link_berita . '%20intext:' . $Query . '&num=' . $Num . '&filter=1&gl=id');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            $data = curl_exec($ch);
            $data = json_decode($data, true);

            curl_close($ch);

            if (!empty($data['items'][$param])) {

                return $data['items'][$param];
            } else {

                echo ' Error Get Api ' . $link_berita . ' ';
            }
        }

        // Cek website online
        function isDomainAvailible($domain)
        {
            if (!filter_var($domain, FILTER_VALIDATE_URL)) {
                return false;
            }

            $curlInit = curl_init($domain);
            curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($curlInit, CURLOPT_HEADER, true);
            curl_setopt($curlInit, CURLOPT_NOBODY, true);
            curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curlInit);

            curl_close($curlInit);

            if ($response) return true;

            return false;
        }

        /**
         * 
         * FUNGSI UNTUK MENGAMBIL ISI BERITA
         * 
         */
        function getDataContent($url_berita, $link_berita)
        {
            $radar = $url_berita;

            if (empty($radar)) {

                echo ' Error Get Isi ' . $link_berita . ' ';
            } else {

                $d          = $radar['link'];
                $client     = new HtmlWeb();
                $taghtml    = Taghtml::pluck('taghtml');
                $url        = $d;

                // Menampilkan status website
                if (isDomainAvailible($url)) {
                    //Mengambil data url format utuh / html
                    $html = $client->load($url);
                    // Set Session data tag html
                    session()->put('html', $html->outertext);
                    //get data dari database taghtml
                    foreach ($taghtml as $dat) {
                        //Menghapus tag beserta isinya yang tidak di perlukan
                        foreach ($html->find($dat) as $p) $p->remove();
                        foreach ($html->find('script') as $script) $script->remove();
                        foreach ($html->find('hr') as $hr) $hr->remove();
                        foreach ($html->find('style') as $style) $style->remove();
                        foreach ($html->find('small') as $small) $small->remove();
                        foreach ($html->find('h1,h2,h3,h4,h5') as $h1) $h1->remove();
                        foreach ($html->find('em') as $em) $em->remove();
                        foreach ($html->find('ul') as $ul) $ul->remove();
                        foreach ($html->find('footer') as $footer) $footer->remove();
                        foreach ($html->find('title') as $title) $title->remove();
                    }

                    $get_data = $html->plaintext;
                    //Menghapus tag html
                    $notag = strip_tags($get_data);
                    //Menghapus Spasi double
                    $nospace = trim($notag);
                    //Array kata yg ingin di hapus
                    $daftar_kata = ['Baca', 'Juga', 'Tags', 'tags', 'tag', 'tags', 'Us', 'Find', 'Sitemap', 'matakalteng', 'Klik.'];
                    //Menghapus kata yang tidak penting
                    $hapus = str_replace($daftar_kata, "", $nospace);
                    //Menghapus kata terakhit setelah . yang berisi informasi wartawan
                    $data = substr($hapus, 0, strrpos($hapus, "."));

                    // dd($data);
                    return $data;
                } else {

                    echo "Oops, website sedang ganguan.";
                }
            }
        }

        /**
         * 
         * FUNGSI MENGAMBIL URL DATA BERITA
         * 
         */
        function getContain($string1)
        {
            $client     = new HtmlWeb();
            $taghtml    = Taghtml::pluck('taghtml');
            $url        = $string1;

            //Mengambil data url format utuh / html
            $html = $client->load($url);
            //get data dari database taghtml
            foreach ($taghtml as $dat) {
                //Menghapus tag beserta isinya yang tidak di perlukan
                foreach ($html->find($dat) as $p) $p->remove();
                foreach ($html->find('script') as $script) $script->remove();
                foreach ($html->find('hr') as $hr) $hr->remove();
                foreach ($html->find('style') as $style) $style->remove();
                foreach ($html->find('small') as $small) $small->remove();
                foreach ($html->find('h1,h2,h3,h4,h5') as $h1) $h1->remove();
                foreach ($html->find('em') as $em) $em->remove();
                foreach ($html->find('ul') as $ul) $ul->remove();
                foreach ($html->find('footer') as $footer) $footer->remove();
                foreach ($html->find('title') as $title) $title->remove();
            }

            $get_data = $html->plaintext;
            //Menghapus tag html
            $notag = strip_tags($get_data);
            //Menghapus Spasi double
            $nospace = trim($notag);
            //Menghapus kata terakhit setelah . yang berisi informasi wartawan
            $data = substr($nospace, 0, strrpos($nospace, "."));

            return $data;
        }

        function getInfo($string)
        {
            $client = new HtmlWeb();
            $html = $client->load($string);

            if (!empty($html->find('.auther, span[itemprop=name]'))) {
                foreach ($html->find('.auther, span[itemprop=name], div[class=jeg_meta_author]') as $auther) $datWartawan = $auther;
                $wartawan = $datWartawan->plaintext;
            } else {
                $wartawan = null;
            }

            if (!empty($html->find('.data-upload'))) {
                foreach ($html->find('.data-upload') as $waktu_upload) $waktus = $waktu_upload;
                $waktu = $waktus->plaintext;
            } else {
                $waktu = null;
            }

            if (!empty($html->find('title'))) {
                foreach ($html->find('title') as $title) $datTitle = $title;
                $title1 = $datTitle->plaintext;
            } else {
                $title1 = null;
            }

            $data = array(
                "wartawan" => $wartawan,
                "waktu" => $waktu,
                "title" => $title1
            );

            return $data;
        }

        /**
         * 
         * 
         *  Text Pre-processing
         * 
         * 
         */

        /** 
         * 
         * FUNGSI UNTUK MERUBAH HURUF BESAR KE HURUF KECIL DAN 
         * MENGHILANGKAN TANDA BACA YANG ADA DALAM STRING
         * 
         */
        function caseFolding($string)
        {

            $string = strtolower($string);
            $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
            $string = preg_replace('!\s+!', ' ', $string);
            $string = str_replace('-', ' ', $string);

            return $string;
        }

        /** 
         * 
         * FUNGSI UNTUK MENGHAPUS ANGKA YANG ADA DI DALAM STRING
         * 
         */
        function numberRemoval($string)
        {

            $string = preg_replace('/[0-9]+/', '', $string);

            return $string;
        }

        /**
         * 
         * FUNGSI UNTUK MENGHAPUS KATA PENGHUBUNG ATAU STOPWORD REMOVAL
         * DENGAN KATA PENGHUBUNG YANG SUDAH DI TAMBAHKAN DI DATABASE
         * 
         */
        function filtering($str = "")
        {

            //MENGAMBIL STOPWORD DARI DATABASE
            $stopwords = Stopword::pluck('id', 'stopword')->toArray();

            $words = preg_split('/[^-\w\']+/', $str, -1, PREG_SPLIT_NO_EMPTY);

            if (count($words) > 1) {
                $words = array_filter($words, function ($w) use (&$stopwords) {
                    return !isset($stopwords[strtolower($w)]);
                    # if utf-8: mb_strtolower($w, "utf-8")
                });
            }

            if (!empty($words))
                return implode(" ", $words);

            return $str;
        }

        /*
         *
         * FUNGSI UNTUK MENGHITUNG JUMLAH KARAKTER YANG ADA DI DALAM STRING
         * 
         */
        function stringLenght($string)
        {

            $string_len = strlen($string);
            return  $string_len;
        }

        /**
         * 
         * FUNGSI MENGAMBIL NILAI STRING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
         * DALAM BENTUK TEXT STRING
         * 
         */
        function commonCharacters($string1, $string2)
        {
            $string1_len = strlen($string1);
            $string2_len = strlen($string2);

            $distance = (int) floor((max($string1_len, $string2_len)) / 2) - 1;

            // INISIALISASI VARIABEL DENGAN ISI KOSONG
            $commonCharacters = '';

            // MEMBUAT KE BENTUK ARRAY DENGAN ISI FALSE
            $m_s1 = array_fill(0, $string1_len, false);
            $m_s2 = array_fill(0, $string2_len, false);

            $matching = 0;

            for ($i = 0; $i < $string1_len; $i++) {
                //
                $start = max(0, $i - $distance);
                $end = min($i + $distance + 1, $string2_len);

                // 
                for ($j = $start; $j < $end; $j++) {
                    // 
                    if (!$m_s2[$j]) {
                        // 
                        if (substr($string1, $i, 1) == substr($string2, $j, 1)) {
                            $m_s1[$i] = true;
                            $m_s2[$j] = true;
                            $matching++;
                            $commonCharacters .= $string1[$i];
                            break;
                        }
                    }
                }
            }

            return $commonCharacters;
        }

        /**
         * 
         * FUNGSI MENGAMBIL NILAI STING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
         * DALAM BENTUK ANGKA SESUAI DENGAN JUMLAH STRING YANG SAMA
         * 
         */
        function commonChar($string1, $string2)
        {

            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $distance = (int) floor((max($string1_len, $string2_len)) / 2) - 1;
            $commonsChar = commonCharacters($string1, $string2, $distance);
            //jumlah char yg sama
            $commonsChar = strlen($commonsChar);

            return $commonsChar;
        }

        /**
         * 
         * FUNGSI UNTUK MENGHITUNG TRANSPOSITIONS PADA KARAKTER YANG SAMA DARI STRING
         * YANG DI BANDINGKAN AKAN TETAPI TERTUKAR URUTANNYA ATAU POSISINYA
         * 
         */
        function transpositions($string1, $string2)
        {

            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $distance = (int) floor((max($string1_len, $string2_len)) / 2) - 1;

            $commons1 = commonCharacters($string1, $string2, $distance);
            $commons2 = commonCharacters($string2, $string1, $distance);

            if (($commons1_len = strlen($commons1)) == 0) return 0;
            if (($commons2_len = strlen($commons2)) == 0) return 0;

            $transpositions = 0;
            $upperBound = min($commons1_len, $commons2_len);

            for ($i = 0; $i < $upperBound; $i++) {
                if ($commons1[$i] != $commons2[$i])
                    $transpositions++;
            }

            return $transpositions /= 2.0;
        }

        /**
         * 
         * FUNGSI UNTUK MENCARI NILAI JARO DISTANCE
         * 
         */
        function Jaro($string1, $string2)
        {
            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $transpositions = transpositions($string1, $string2);

            $distance = (int) floor((max($string1_len, $string2_len)) / 2) - 1;

            $commons1 = commonCharacters($string1, $string2, $distance);
            $commons2 = commonCharacters($string2, $string1, $distance);

            if (($commons1_len = strlen($commons1)) == 0) return 0;
            if (($commons2_len = strlen($commons2)) == 0) return 0;

            $upperBound = min($commons1_len, $commons2_len);

            return (($upperBound / ($string1_len) + $upperBound / ($string2_len) + ($upperBound - $transpositions) / ($upperBound)) / 3.0);
        }

        /**
         * 
         * FUNGSI MENCARI PREFIX LENGTH DENGAN MAX PREFIX SEBESAR 4  
         * 
         */
        function prefixLength($string1, $string2, $MINPREFIXLENGTH = 4)
        {
            $n = min(array($MINPREFIXLENGTH, strlen($string1), strlen($string2)));

            for ($i = 0; $i < $n; $i++) {
                if ($string1[$i] != $string2[$i]) {
                    return $i;
                }
            }

            return $n;
        }

        /**
         * 
         * FUNGSI MENCARI NILAI JARO WINKLER DISTANCE DENGAN PREFIX SCALE 0.1
         * 
         */
        function JaroWinkler($string1, $string2, $PREFIXSCALE = 0.1)
        {
            $string1 = strtolower($string1);
            $string2 = strtolower($string2);

            $jaroDistance = jaro($string1, $string2);
            $prefixLength = prefixLength($string1, $string2);
            $jaroWinkler = $jaroDistance + ($prefixLength * $PREFIXSCALE * (1.0 - $jaroDistance));

            return $jaroWinkler;
        }


        /**
         * 
         *  Proses Untuk Uji
         * 
         */
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        $string1        = getContain($link_uji);
        $caseFolding1   = caseFolding($string1);
        $numberRemoval1 = numberRemoval($caseFolding1);
        $filtering1     = filtering($numberRemoval1);
        $steming1       = $stemmer->stem($filtering1);
        $length1        = stringLenght($steming1);
        /**
         * 
         * 
         */

        function actionAll1($id, $steming1, $link, $url, $param)
        {

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();

            $URL_DATA       = GetUrlData1(getKeySearch($link), $url, $param);
            $STRING_DATA    = getDataContent($URL_DATA, $url);
            $CASEFOLDING    = caseFolding($STRING_DATA);
            $NUMBER_REMOVAL = numberRemoval($CASEFOLDING);
            $FILTERING      = filtering($NUMBER_REMOVAL);
            $STEMMING       = $stemmer->stem($FILTERING);
            /**
             * PROSES JARO WINKLER
             */
            $STRING_LENGHT      = stringLenght($STEMMING);
            $COMMON_CHARACTER   = commonCharacters($steming1, $STEMMING);
            $COMMON_LENGHT      = commonChar($steming1, $STEMMING);
            $TRANSPOSITION      = transpositions($steming1, $STEMMING);
            $JARO_DISTANCE      = Jaro($steming1, $STEMMING);
            $JARO_WIN_DISTANCE  = round(JaroWinkler($steming1, $STEMMING) * 100);
            $SIMILARITY         = JaroWinkler($steming1, $STEMMING);

            if (!empty($URL_DATA)) {
                $data = array(
                    "Id" => $id,
                    "Data" => $URL_DATA,

                    // Text Pre-processing
                    "RemoveHTML" => session()->get('html'),
                    "RemoveSpCh" => $STRING_DATA,
                    "CaseFolding" => $CASEFOLDING,
                    "NumberRemoval" => $NUMBER_REMOVAL,
                    "Filtering" => $FILTERING,
                    "Stemming" => $STEMMING,

                    // Implementasi Algoritma Jaro Winkler
                    "LenghtString" => $STRING_LENGHT,
                    "CommonChar" => $COMMON_CHARACTER,
                    "CommonLenght" => $COMMON_LENGHT,
                    "Transposition" => $TRANSPOSITION,
                    "Jaro_Distance" => $JARO_DISTANCE,
                    "Jaro_Win_Distance" => $JARO_WIN_DISTANCE,
                    "Similarity" => $SIMILARITY,

                );

                return $data;
            }
        }

        function actionAll2($id, $steming1, $link, $url, $param)
        {

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();

            $URL_DATA       = GetUrlData2(getKeySearch($link), $url, $param);
            $STRING_DATA    = getDataContent($URL_DATA, $url);
            $CASEFOLDING    = caseFolding($STRING_DATA);
            $NUMBER_REMOVAL = numberRemoval($CASEFOLDING);
            $FILTERING      = filtering($NUMBER_REMOVAL);
            $STEMMING       = $stemmer->stem($FILTERING);
            /**
             * PROSES JARO WINKLER
             */
            $STRING_LENGHT      = stringLenght($STEMMING);
            $COMMON_CHARACTER   = commonCharacters($steming1, $STEMMING);
            $COMMON_LENGHT      = commonChar($steming1, $STEMMING);
            $TRANSPOSITION      = transpositions($steming1, $STEMMING);
            $JARO_DISTANCE      = Jaro($steming1, $STEMMING);
            $JARO_WIN_DISTANCE  = round(JaroWinkler($steming1, $STEMMING) * 100);
            $SIMILARITY         = JaroWinkler($steming1, $STEMMING);

            if (!empty($URL_DATA)) {
                $data = array(
                    "Id" => $id,
                    "Data" => $URL_DATA,

                    // Text Pre-processing
                    "RemoveHTML" => session()->get('html'),
                    "RemoveSpCh" => $STRING_DATA,
                    "CaseFolding" => $CASEFOLDING,
                    "NumberRemoval" => $NUMBER_REMOVAL,
                    "Filtering" => $FILTERING,
                    "Stemming" => $STEMMING,

                    // Implementasi Algoritma Jaro Winkler
                    "LenghtString" => $STRING_LENGHT,
                    "CommonChar" => $COMMON_CHARACTER,
                    "CommonLenght" => $COMMON_LENGHT,
                    "Transposition" => $TRANSPOSITION,
                    "Jaro_Distance" => $JARO_DISTANCE,
                    "Jaro_Win_Distance" => $JARO_WIN_DISTANCE,
                    "Similarity" => $SIMILARITY,

                );

                return $data;
            }
        }

        $data = array(
            "1" => actionAll1('klikkalteng1', $steming1, $link_uji, 'klikkalteng.id', '0'),
            "2" => actionAll1('klikkalteng2', $steming1, $link_uji, 'klikkalteng.id', '1'),
            "3" => actionAll1('borneonews1', $steming1, $link_uji, 'borneonews.co.id', '0'),
            "4" => actionAll1('borneonews2', $steming1, $link_uji, 'borneonews.co.id', '1'),
            "5" => actionAll1('radarsampit1', $steming1, $link_uji, 'radarsampit.com', '0'),
            "6" => actionAll1('radarsampit2', $steming1, $link_uji, 'radarsampit.com', '1'),
            "7" => actionAll1('matakalteng1', $steming1, $link_uji, 'matakalteng.com', '0'),
            "8" => actionAll1('matakalteng2', $steming1, $link_uji, 'matakalteng.com', '1'),
            "9" => actionAll1('beritakalteng1', $steming1, $link_uji, 'beritakalteng.com', '0'),
            "10" => actionAll1('beritakalteng2', $steming1, $link_uji, 'beritakalteng.com', '2'),
            "11" => actionAll1('antaranews1', $steming1, $link_uji, 'kalteng.antaranews.com', '0'),
            "12" => actionAll1('antaranews2', $steming1, $link_uji, 'kalteng.antaranews.com', '1'),
            "13" => actionAll1('kaltengnews1', $steming1, $link_uji, 'kaltengnews.co.id', '0'),
            "14" => actionAll1('kaltengnews2', $steming1, $link_uji, 'kaltengnews.co.id', '1'),
            "15" => actionAll1('sampit1', $steming1, $link_uji, 'sampit.prokal.co', '0'),
            "16" => actionAll1('sampit2', $steming1, $link_uji, 'sampit.prokal.co', '1'),
            "17" => actionAll1('kaltengtoday1', $steming1, $link_uji, 'kaltengtoday.com', '0'),
            "18" => actionAll1('kaltengtoday2', $steming1, $link_uji, 'kaltengtoday.com', '1'),
            "19" => actionAll1('humabetang1', $steming1, $link_uji, 'humabetang.com', '0'),
            "20" => actionAll1('humabetang2', $steming1, $link_uji, 'humabetang.com', '1'),
            "21" => actionAll2('kalteng1', $steming1, $link_uji, 'kalteng.co', '0'),
            "22" => actionAll2('kalteng2', $steming1, $link_uji, 'kalteng.co', '1'),
            "23" => actionAll2('kaltengoke1', $steming1, $link_uji, 'kaltengoke.com', '0'),
            "24" => actionAll2('kaltengoke2', $steming1, $link_uji, 'kaltengoke.com', '1'),
            "25" => actionAll2('inikalteng1', $steming1, $link_uji, 'inikalteng.com', '0'),
            "26" => actionAll2('inikalteng2', $steming1, $link_uji, 'inikalteng.com', '1'),
            "27" => actionAll2('kaltengonline1', $steming1, $link_uji, 'kaltengonline.com', '0'),
            "28" => actionAll2('kaltengonline2', $steming1, $link_uji, 'kaltengonline.com', '1'),
            "29" => actionAll2('borneo241', $steming1, $link_uji, 'borneo24.com', '0'),
            "30" => actionAll2('borneo242', $steming1, $link_uji, 'borneo24.com', '1'),
            "31" => actionAll2('kpfmpalangkaraya1', $steming1, $link_uji, 'kpfmpalangkaraya.com', '0'),
            "32" => actionAll2('kpfmpalangkaraya2', $steming1, $link_uji, 'kpfmpalangkaraya.com', '1'),
            "33" => actionAll2('beritasampit1', $steming1, $link_uji, 'beritasampit.co.id', '0'),
            "34" => actionAll2('beritasampit2', $steming1, $link_uji, 'beritasampit.co.id', '1'),
            "35" => actionAll2('baritaitah1', $steming1, $link_uji, 'baritaitah.co.id', '0'),
            "36" => actionAll2('baritaitah2', $steming1, $link_uji, 'baritaitah.co.id', '1'),
            "37" => actionAll2('kalteng.indeksnews1', $steming1, $link_uji, 'kalteng.indeksnews.com', '0'),
            "38" => actionAll2('kalteng.indeksnews2', $steming1, $link_uji, 'kalteng.indeksnews.com', '1'),
        );

        // dd($data);

        return view('hasil-similarity', [
            "title"         => "Hasil Similarity Berita Online",
            "string1"       => getContain($link_uji),
            "info"          => getInfo($link_uji),
            "allData"       => $data,
            "casefolding"   => $caseFolding1,
            "numberremoval" => $numberRemoval1,
            "filtering"     => $filtering1,
            "stemming"      => $steming1,
            "lenghtstring"  => $length1,
            "no"            => 1
        ]);
    }
}
