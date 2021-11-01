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
        return view('cek-plagiarism',[
            "title" => "Cek Plagiarism"
        ]);
    }

    public function getHtml(Request $request)
    {
    
        $validated = $request->validate([
            'link1' => 'required|url',
        ]);

        $link1 = $request->input('link1');

        $start     = microtime(true); 

        /**
         * FUNGSI MENGAMBIL UNTUK KEY PECARIAN BERITA
         */
        function getKeySearch($string)
        {
            $dom = new HtmlWeb();
            $key = $string;
            $tags = get_meta_tags($key);

            $data = strtolower($tags['keywords']); 
            $daftar_kata = ['sampit','kecamatan','pemkab','bupati',',','kifayah','fardu','mui','ketua','kotim'];  
            $hapus = str_replace($daftar_kata," ", $data);
            $space = preg_replace('/\s+/', ' ',$hapus);
            $space = trim($space);
            $data = str_replace(" ", "%20", $space);    // php documentation
            // dd($tags);
            return $data;
        }
        
        
        /**
         * FUNGSI MENGAMBIL URL DATA BERITA
         * 
         */
        function GetUrlData1($string, $link_berita)
        {   
            $Query      = $string;
            $Num        = 1;
            $API_KEY    = 'AIzaSyCsCDG9UKXBMwl4Jgx0zDjgpgmn99qge8Q';
            $ID         = '907b295d015a55408';
            $link       = $link_berita;
            $timeout = 0;

            $ch      = curl_init();
 
            echo 'https://www.googleapis.com/customsearch/v1/siterestrict?key='.$API_KEY.'&cx='.$ID.'&q=site:'.$link.'%20intext:'.$Query.'&num='.$Num.'&filter=1&gl=id';
            curl_setopt( $ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1/siterestrict?key='.$API_KEY.'&cx='.$ID.'&q=site:'.$link.'%20intext:'.$Query.'&num='.$Num.'&filter=1&gl=id' );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );

            $data = curl_exec( $ch );
            
            $data = json_decode( $data, true );

            curl_close( $ch );
            
            if (!empty($data['items'])) {

                return $data['items'];

            } else {

                echo ' Error Get Api '.$link.' ';

            }
            
        }

        function GetUrlData2($string, $link_berita)
        {   
            $Query      = $string;
            $Num        = 1;
            $API_KEY    = 'AIzaSyCsCDG9UKXBMwl4Jgx0zDjgpgmn99qge8Q';
            $ID         = 'd0d8d435cd904182f';
            $link       = $link_berita;

            $ch      = curl_init();
            $timeout = 0; 

            echo 'https://www.googleapis.com/customsearch/v1/siterestrict?key='.$API_KEY.'&cx='.$ID.'&q=site:'.$link.'%20intext:'.$Query.'&num='.$Num.'&filter=1&gl=id';
            curl_setopt( $ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1/siterestrict?key='.$API_KEY.'&cx='.$ID.'&q=site:'.$link.'%20intext:'.$Query.'&num='.$Num.'&filter=1&gl=id');
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_HEADER, 0 );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );

            $data = curl_exec( $ch );
            $data = json_decode( $data, true );

            curl_close( $ch );
            
            if (!empty($data['items'])) {

                return $data['items'];

            } else {

                echo ' Error Get Api '.$link.' ';

            }
            
        }
        
        /**
         * 
         * FUNGSI UNTUK MENGAMBIL ISI BERITA
         * 
         */
        function getDataContent($rad, $url, $link_berita)
        {
            $radar = $rad;
            if (empty($radar)) {

                echo ' Error Get Isi '.$link_berita.' ';

            } else {

                $d          = $radar[0]['link'];
                $client     = new HtmlWeb();
                $taghtml    = Taghtml::pluck('taghtml');
                $url        = $d;
            
                //Mengambil data url format utuh / html
                $html= $client->load($url);
                //get data dari database taghtml
                foreach ($taghtml as $dat) {
                    //Menghapus tag beserta isinya yang tidak di perlukan
                    foreach($html->find($dat) as $p) {
                        foreach ($p->getAllAttributes() as $attr => $val) {
                            $p->remove();
                            foreach($html->find('script') as $script) $script->remove();
                            foreach($html->find('hr') as $hr) $hr->remove();
                            foreach($html->find('style') as $style) $style->remove();
                            foreach($html->find('small') as $small) $small->remove();
                            foreach($html->find('h1,h2,h3,h4,h5') as $h1) $h1->remove();
                            foreach($html->find('em') as $em) $em->remove();
                            foreach($html->find('ul') as $ul) $ul->remove();
                            foreach($html->find('footer') as $footer) $footer->remove();
                            foreach($html->find('title') as $title) $title->remove();
                        }    
                    }
                }

                $get_data = $html->plaintext;
                //Menghapus tag html
                $notag = strip_tags($get_data);
                //Menghapus Spasi double
                $nospace = trim($notag);
                //Array kata yg ingin di hapus
                $daftar_kata = ['Baca','Juga','Tags','tags','tag','tags','Us','Find','Sitemap','matakalteng'];  
                //Menghapus kata yang tidak penting
                $hapus = str_replace($daftar_kata, "", $nospace);
                //Menghapus kata terakhit setelah . yang berisi informasi wartawan
                $data = substr($hapus, 0, strrpos($hapus, "."));
                
                // dd($data);
                // echo $data;
                
                return $data;
            }
        }

        // dd(getisi($link1, 'klikkalteng.id'));

        function getContain($string1)
        {
            $client     = new HtmlWeb();
            $taghtml    = Taghtml::pluck('taghtml');
            $url        = $string1;
            
            //Mengambil data url format utuh / html
            $html= $client->load($url);
            //get data dari database taghtml
            foreach ($taghtml as $dat) {
                //Menghapus tag beserta isinya yang tidak di perlukan
                foreach($html->find($dat) as $p) {
                    foreach ($p->getAllAttributes() as $attr => $val) {
                        $p->remove();
                        foreach($html->find('script') as $script) $script->remove();
                        foreach($html->find('hr') as $hr) $hr->remove();
                        foreach($html->find('style') as $style) $style->remove();
                        foreach($html->find('small') as $small) $small->remove();
                        foreach($html->find('h1,h2,h3,h4,h5') as $h1) $h1->remove();
                        foreach($html->find('em') as $em) $em->remove();
                        foreach($html->find('ul') as $ul) $ul->remove();
                        foreach($html->find('footer') as $footer) $footer->remove();
                        foreach($html->find('title') as $title) $title->remove();
                    }    
                }
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
        
        function getWartawanLink1($string)
        {
            $client = new HtmlWeb();
            $url = $string;
                $html= $client->load($url);
                if (!empty($html->find('.auther, span[itemprop=name]'))){
                    foreach($html->find('.auther, span[itemprop=name], div[class=jeg_meta_author]') as $auther) $datWartawan = $auther;
                    $data = $datWartawan->plaintext;
                    session(['wartawanlink1' => $data]);
                    $wartawan = session('wartawanlink1');
                } else {
                    $wartawan = null;
                    session()->forget('wartawanlink1');
                }
            return $wartawan;
        }

        function getTitleLink1($string)
        {
            $client = new HtmlWeb();
            $url = $string;
                $html= $client->load($url);
                if (!empty($html->find('title'))){
                    foreach($html->find('title') as $title) $datTitle = $title;
                    $data = $datTitle->plaintext;
                    session(['titlelink1' => $data]);
                    $title1 = session('titlelink1');
                } else {
                    $title1 = null;
                    session()->forget('titlelink1');
                }
            return $title1;
        }        

        /**
         * 
         * 
         * 
         * 
         * 
         */

        /** 
         * FUNGSI UNTUK MERUBAH HURUF BESAR KE HURUF KECIL DAN 
         * MENGHILANGKAN TANDA BACA YANG ADA DALAM STRING
         */ 
        function caseFolding($string) {
           
            $string = strtolower($string);
            $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
            $string = preg_replace('!\s+!', ' ', $string);
            $string = str_replace('-',' ',$string);
            
            return $string;
        
        }
        
        /** 
         * FUNGSI UNTUK MENGHAPUS ANGKA YANG ADA DI DALAM STRING
         */ 
        function numberRemoval($string) {

            $string = preg_replace('/[0-9]+/', '', $string);
            
            return $string;

        }   
        
        /**
         * FUNGSI UNTUK MENGHAPUS KATA PENGHUBUNG ATAU STOPWORD REMOVAL
         * DENGAN KATA PENGHUBUNG YANG SUDAH DI TAMBAHKAN DI DATABASE
         */  
        function filtering($str = "")
        {
            global $stopwords;

            //MENGAMBIL STOPWORD DARI DATABASE
            $stopwords = Stopword::pluck('id','stopword')->toArray();

            $words = preg_split('/[^-\w\']+/', $str, -1, PREG_SPLIT_NO_EMPTY);
        
            if(count($words) > 1)
            {
                $words = array_filter($words, function ($w) use (&$stopwords) {
                    return !isset($stopwords[strtolower($w)]);
                    # if utf-8: mb_strtolower($w, "utf-8")
                });

            }

            if(!empty($words))
            return implode(" ", $words);
            return $str;

        }

        /* 
         * FUNGSI UNTUK MENGHAPUS SPASI YANG ADA DI DALAM STRING
         */ 
        function removeSpace($string){

            $removeSpace = str_replace(' ','',$string);

            return $removeSpace;

        }

        /*
         * FUNGSI UNTUK MENGHITUNG JUMLAH KARAKTER YANG ADA DI DALAM STRING
         */ 
        function stringLenght($string){

            $string_len = strlen($string);
            return  $string_len;
        
        }

        /**
         * FUNGSI MENGAMBIL NILAI STRING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
         * DALAM BENTUK TEXT STRING
         */ 
        function commonCharacters( $string1, $string2 )
        {
            $string1_len = strlen($string1);
            $string2_len = strlen($string2);

            $distance = (int) floor ((max($string1_len,$string2_len)) / 2) -1;

            // INISIALISASI VARIABEL DENGAN ISI KOSONG
            $commonCharacters = '';

            // MEMBUAT KE BENTUK ARRAY DENGAN ISI FALSE
            $m_s1 = array_fill(0, $string1_len, false);
            $m_s2 = array_fill(0, $string2_len, false);

            $matching = 0;
        
            for($i=0; $i<$string1_len; $i++)
            {
                //
                $start = max(0, $i - $distance);
                $end = min($i + $distance + 1, $string2_len);
                
                // 
                for( $j= $start ; $j < $end; $j++)
                {
                    // 
                    if(!$m_s2[$j])
                    {
                        // 
                        if (substr($string1, $i, 1) == substr($string2, $j, 1))
                        {
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
         * FUNGSI MENGAMBIL NILAI STING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
         * DALAM BENTUK ANGKA SESUAI DENGAN JUMLAH STRING YANG SAMA
         */
        function commonChar($string1,$string2){

            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $distance = (int) floor ((max($string1_len,$string2_len)) / 2) -1;
            $commonsChar = commonCharacters( $string1, $string2, $distance );
            //jumlah char yg sama
            $commonsChar = strlen($commonsChar);

            return $commonsChar;

        }

        /**
         * FUNGSI UNTUK MENGHITUNG TRANSPOSITIONS PADA KARAKTER YANG SAMA DARI STRING
         * YANG DI BANDINGKAN AKAN TETAPI TERTUKAR URUTANNYA ATAU POSISINYA
         */
        function transpositions($string1,$string2){
            
            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $distance = (int) floor ((max($string1_len,$string2_len)) / 2) -1;
                
            $commons1 = commonCharacters( $string1, $string2, $distance );
            $commons2 = commonCharacters( $string2, $string1, $distance );
            
            if( ($commons1_len = strlen( $commons1 )) == 0) return 0;
            if( ($commons2_len = strlen( $commons2 )) == 0) return 0;

            $transpositions = 0;
            $upperBound = min( $commons1_len, $commons2_len );

            for( $i = 0; $i < $upperBound; $i++)
            {
                if( $commons1[$i] != $commons2[$i] ) 
                $transpositions++;
            }    
                
            return $transpositions /= 2.0;

        }

        /**
         * FUNGSI UNTUK MENCARI NILAI JARO DISTANCE
         */
        function Jaro( $string1, $string2)
        {
            $string1_len = strlen($string1);
            $string2_len = strlen($string2);
            $transpositions = transpositions($string1, $string2);

            $distance = (int) floor ((max($string1_len,$string2_len)) / 2) -1;
            
            $commons1 = commonCharacters( $string1, $string2, $distance );
            $commons2 = commonCharacters( $string2, $string1, $distance );
            
            if( ($commons1_len = strlen( $commons1 )) == 0) return 0;
            if( ($commons2_len = strlen( $commons2 )) == 0) return 0;

            return (($commons1_len/($string1_len) + $commons1_len/($string2_len) + ($commons1_len - $transpositions) / ($commons1_len)) / 3.0);
        }

        /**
         * FUNGSI MENCARI PREFIX LENGTH DENGAN MAX PREFIX SEBESAR 4  
         * 
         */ 
        function prefixLength( $string1, $string2, $MINPREFIXLENGTH = 4 )
        {
            $n = min( array( $MINPREFIXLENGTH, strlen($string1), strlen($string2) ) );

                for($i = 0; $i < $n; $i++)
                {
                    if( $string1[$i] != $string2[$i] )
                    {
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

            $jaroDistance = jaro( $string1, $string2 );
            $prefixLength = prefixLength( $string1, $string2 );
            $jaroWinkler = $jaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $jaroDistance);
            
            return $jaroWinkler;
        }

        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();
        /**
         * 
         * 
         *  
         */ 
        $string1        = getContain($link1);
        $caseFolding1   = caseFolding($string1);
        $numberRemoval1 = numberRemoval($caseFolding1);
        $filtering1     = filtering($numberRemoval1);
        $steming1       = $stemmer->stem($filtering1);
        $removeSpace1   = removeSpace($steming1);
        $length1        = stringLenght($steming1);
        
        // $stemming1      = caseFolding(numberRemoval(filtering($string1)));
        // $output1        = $stemmer->stem($stemming1);
        // $x1             = $output1;


        function actionAll1($steming1, $removeSpace1, $link, $url)
        {

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
        
            $URL_DATA       = GetUrlData1(getKeySearch($link), $url);
            $STRING_DATA    = getDataContent($URL_DATA, $link, $url);
            $TIME_START     = microtime(true); 
            $CASEFOLDING    = caseFolding($STRING_DATA);  
            $NUMBER_REMOVAL = numberRemoval($CASEFOLDING);
            $FILTERING      = filtering($NUMBER_REMOVAL);   
            $STEMMING       = $stemmer->stem($FILTERING);
            $REMOVE_SPACE   = removeSpace($STEMMING);
            // 
            $STRING_LENGHT      = stringLenght($REMOVE_SPACE);
            $COMMON_CHARACTER   = commonCharacters($removeSpace1, $REMOVE_SPACE);
            $COMMON_LENGHT      = commonChar($removeSpace1, $REMOVE_SPACE);
            $TRANSPOSITION      = transpositions($removeSpace1, $REMOVE_SPACE);
            /**
             * PROSES JARO WINKLER
             */
            $JARO_DISTANCE      = Jaro($removeSpace1, $REMOVE_SPACE);
            $JARO_WIN_DISTANCE  = round(JaroWinkler($removeSpace1, $REMOVE_SPACE)*100);
            $SIMILARITY         = JaroWinkler($steming1, $STEMMING);
            // 
            $TIME_END       = microtime(true);
            $EXCUT_TIME     = ($TIME_END - $TIME_START);
            $TIME_DATA      = round($EXCUT_TIME, 3);

            $data = array(
                "1" => $URL_DATA,
                "2" => $JARO_DISTANCE,
                "3" => $JARO_WIN_DISTANCE,
                "4" => $TIME_DATA,
                "5" => $SIMILARITY,
                "6" => $STEMMING,
                "7" => $steming1,
                "8" => $CASEFOLDING,
                "9" => $NUMBER_REMOVAL,
                "10" => $FILTERING,
            );

            return $data;

        }

        function actionAll2($steming1, $removeSpace1, $link, $url)
        {

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
        
            $URL_DATA       = GetUrlData1(getKeySearch($link), $url);
            $STRING_DATA    = getDataContent($URL_DATA, $link, $url);
            $TIME_START     = microtime(true); 
            $CASEFOLDING    = caseFolding($STRING_DATA);  
            $NUMBER_REMOVAL = numberRemoval($CASEFOLDING);
            $FILTERING      = filtering($NUMBER_REMOVAL);   
            $STEMMING       = $stemmer->stem($FILTERING);
            $REMOVE_SPACE   = removeSpace($STEMMING);
            // 
            $STRING_LENGHT      = stringLenght($REMOVE_SPACE);
            $COMMON_CHARACTER   = commonCharacters($removeSpace1, $REMOVE_SPACE);
            $COMMON_LENGHT      = commonChar($removeSpace1, $REMOVE_SPACE);
            $TRANSPOSITION      = transpositions($removeSpace1, $REMOVE_SPACE);
            /**
             * PROSES JARO WINKLER
             */
            $JARO_DISTANCE      = Jaro($removeSpace1, $REMOVE_SPACE);
            $JARO_WIN_DISTANCE  = round(JaroWinkler($removeSpace1, $REMOVE_SPACE)*100);
            $SIMILARITY         = JaroWinkler($steming1, $STEMMING);
            // 
            $TIME_END       = microtime(true);
            $EXCUT_TIME     = ($TIME_END - $TIME_START);
            $TIME_DATA      = round($EXCUT_TIME, 3);

            $data = array(
                "1" => $URL_DATA,
                "2" => $JARO_DISTANCE,
                "3" => $JARO_WIN_DISTANCE,
                "4" => $TIME_DATA,
                "5" => $SIMILARITY,
                "6" => $STEMMING,
                "7" => $steming1
            );

            return $data;

        }

        $data = array(
                "1" => actionAll1($steming1,$removeSpace1,$link1,'klikkalteng.id'),
                "2" => actionAll1($steming1,$removeSpace1,$link1,'borneonews.co.id'),
                "3" => actionAll1($steming1,$removeSpace1,$link1,'radarsampit.com'),
                "4" => actionAll1($steming1,$removeSpace1,$link1,'matakalteng.com'),
                "5" => actionAll1($steming1,$removeSpace1,$link1,'prokalteng.co'),
                "6" => actionAll1($steming1,$removeSpace1,$link1,'kalteng.antaranews.com'),
                "7" => actionAll1($steming1,$removeSpace1,$link1,'dayaknews.com'),
                "8" => actionAll1($steming1,$removeSpace1,$link1,'sampit.prokal.co'),
                "9" => actionAll1($steming1,$removeSpace1,$link1,'kaltengtoday.com'),
                "10" => actionAll1($steming1,$removeSpace1,$link1,'kaltengekspres.com'),
                "11" => actionAll2($steming1,$removeSpace1,$link1,'kalteng.co'),
                "12" => actionAll2($steming1,$removeSpace1,$link1,'kaltengoke.com'),
                "13" => actionAll2($steming1,$removeSpace1,$link1,'kalteng.tribunnews.com'),
                "14" => actionAll2($steming1,$removeSpace1,$link1,'jurnalkalteng.com'),
                "15" => actionAll2($steming1,$removeSpace1,$link1,'borneo24.com'),
                "16" => actionAll2($steming1,$removeSpace1,$link1,'kalteng.pikiran-rakyat.com'),
                "17" => actionAll2($steming1,$removeSpace1,$link1,'beritasampit.co.id')
            
        );

        dd($data);

        $end       = microtime(true);
        $exct     = ($end - $start);
        $timeAll      = round($exct, 3);

        return view('cek-from-url', [
            "title"         => "Hasil Similarity Berita Online",
            "string1"       => getContain($link1),
            "wartawanlink1" => getWartawanLink1($link1),
            "titlelink1"    => getTitleLink1($link1),
            "allData"       => $data,
            "waktuLoad"     => $timeAll.' s',
        ]);

    }
}
