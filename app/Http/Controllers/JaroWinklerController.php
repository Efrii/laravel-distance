<?php

namespace App\Http\Controllers;

use App\Models\Stopword;
use Illuminate\Http\Request;
use Sastrawi\Stemmer\StemmerFactory;

class JaroWinklerController extends Controller
{

    public function prosesJaro(Request $request)
    {

        $validated = $request->validate([
            'string1' => 'required',
            'string2' => 'required'
        ]);

        // PROSES MEMANGGIL LIBRARY STEMMING SASTRAWI
        //  
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        /** 
         * FUNGSI UNTUK MENGETAHUI KECEPATAN EKSEKUSI ALGORITMA JARO WINKLER
         * DARI DATA YANG SUDAH DI MASUKKAN
         */
        function starttime()
        {
            $r = explode(' ', microtime());
            $r = $r[1] + $r[0];
            return $r;
        }

        /**
         * MENGINISIALISASIKAN FUNGSI STARTTIME KE VARIABEL START
         */
        $start = starttime();

        /** 
         * FUNGSI UNTUK MERUBAH HURUF BESAR KE HURUF KECIL DAN 
         * MENGHILANGKAN TANDA BACA YANG ADA DALAM STRING
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
         * FUNGSI UNTUK MENGHAPUS ANGKA YANG ADA DI DALAM STRING
         * 
         */
        function numberRemoval($string)
        {

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

        // FUNGSI UNTUK MENGHAPUS SPASI YANG ADA DI DALAM STRING
        // 
        function removeSpace($string)
        {

            $removeSpace = str_replace(' ', '', $string);

            return $removeSpace;
        }

        // FUNGSI UNTUK MENGHITUNG JUMLAH KARAKTER YANG ADA DI DALAM STRING
        // 
        function stringLenght($string)
        {

            $string_len = strlen($string);

            return  $string_len;
        }

        // FUNGSI MENGAMBIL NILAI STRING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
        // DALAM BENTUK TEXT STRING
        // 
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
            // 

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

        // FUNGSI MENGAMBIL NILAI STING YANG SAMA DARI PROSES PERBANDINGAN KEDUA STRING
        // DALAM BENTUK ANGKA SESUAI DENGAN JUMLAH STRING YANG SAMA
        // 
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

        // FUNGSI UNTUK MENGHITUNG TRANSPOSITIONS PADA KARAKTER YANG SAMA DARI STRING
        // YANG DI BANDINGKAN AKAN TETAPI TERTUKAR URUTANNYA ATAU POSISINYA
        // 
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

        // function tokenizing($string)
        // {
        //     // $words = preg_split($string);
        //     return explode(' ', $string);
        // }

        // FUNGSI UNTUK MENCARI NILAI JARO DISTANCE
        // 
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


            echo ' tranaa ';
            echo $transpositions;
            echo ' com1 ';
            echo $commons1_len;
            echo ' str1 ';
            echo $string1_len;
            echo ' com2 ';
            echo $commons1_len;
            echo ' str2 ';
            echo $string2_len;

            return (($commons1_len / ($string1_len) + $commons1_len / ($string2_len) + ($commons1_len - $transpositions) / ($commons1_len)) / 3.0);
        }

        // FUNGSI MENCARI PREFIX LENGTH DENGAN MAX PREFIX SEBESAR 4
        // 
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

        // FUNGSI MENCARI NILAI JARO WINKLER DISTANCE DENGAN PREFIX SCALE 0.1
        // 
        function JaroWinkler($string1, $string2, $PREFIXSCALE = 0.1)
        {
            $string1 = strtolower($string1);
            $string2 = strtolower($string2);
            // dd($string1);

            $jaroDistance = jaro($string1, $string2);
            $prefixLength = prefixLength($string1, $string2);
            $jaroWinkler = $jaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $jaroDistance);

            return $jaroWinkler;
        }

        // MENGINISIALISASIKAN SETIAP DATA YANG DI INPUT DI FORM UNTUK DI MASUKKAN KE 
        // VARIABEL STRING 1 DAN 2 
        // 
        $string1 = $request->input('string1');
        $string2 = $request->input('string2');

        // MENGINISIALISASIKAN FUNGSI CASEFOLDING KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL CASEFOLDING 1 DAN 2
        // 
        $caseFolding1 = caseFolding($string1);
        $caseFolding2 = caseFolding($string2);

        // MENGINISIALISASIKAN FUNGSI NUMBERREMOVAL KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL NUMBERREMOVAL 1 DAN 2
        // 
        $numberRemoval1 = numberRemoval($caseFolding1);
        $numberRemoval2 = numberRemoval($caseFolding2);

        // MENGINISIALISASIKAN FUNGSI FILTERING KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL FILTERING 1 DAN 2 
        // 
        $filtering1 = filtering($numberRemoval1);
        $filtering2 = filtering($numberRemoval2);

        // MENGINISIALISASIKAN FUNGSI STEM KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL STEMING 1 DAN 2
        // 
        $steming1 = $stemmer->stem($filtering1);
        $steming2 = $stemmer->stem($filtering2);

        // MENGINISIALISASIKAN FUNGSI REMOVESPACE KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL REMOVESPACE 1 DAN 2
        // 
        $removeSpace1 = removeSpace($steming1);
        $removeSpace2 = removeSpace($steming2);

        // MENGINISIALISASIKAN FUNGSI STRINGLENGHT KE STRING 1 DAN 2
        // DAN DI INISIALISASKAN KE VARIABEL LENGTH 1 DAN 2
        // 
        $length1 = stringLenght($steming1);
        $length2 = stringLenght($removeSpace2);

        //Jumlah Karakter Sama
        $commonchar = commonCharacters($removeSpace1, $removeSpace2);

        $commonCar = commonChar($removeSpace1, $removeSpace2);

        //Transposisi
        $transposisi = transpositions($removeSpace1, $removeSpace2);

        //Jaro Distance
        $distance = Jaro($steming1, $removeSpace2);

        //string 1
        $stemming1 = caseFolding(numberRemoval(filtering($string1)));
        $output1 = $stemmer->stem($stemming1);
        $x1 = $output1;

        //string 2
        $stemming2 = caseFolding(numberRemoval(filtering($string2)));
        $output2 = $stemmer->stem($stemming2);
        $x2 = $output2;

        //hitung similarity
        $similirity = round(JaroWinkler($x1, $x2) * 100);
        $similirity_no = JaroWinkler($x1, $x2);

        //
        $prefix = prefixLength($string1, $string2);


        // dd($d);

        // print_r(array_unique($d));

        /** 
         * FUNGSI UNTUK MEINISIALISASIKAN BAHWA JIKA PROSES SAMPAI DI SINI MAKAI START TIME
         * BERHENTI DAN AKAN DIDAT SEBERAPA KECEPATAN ALGORITMA DALAM MEMPROSES
         */
        function endtime($starttime)
        {

            $r = explode(' ', microtime());
            $r = $r[1] + $r[0];
            $r = round($r - $starttime, 4);

            return $r;
        }

        return view('result-plagiarism', [
            "title" => "Hasil Plagiarism",
            "string1" => $string1,
            "string2" => $string2,
            "caseFolding1" => $caseFolding1,
            "caseFolding2" => $caseFolding2,
            "numberRemoval1" => $numberRemoval1,
            "numberRemoval2" => $numberRemoval2,
            "filtering1" => $filtering1,
            "filtering2" => $filtering2,
            "steming1" => $steming1,
            "steming2" => $steming2,
            "removeSpace1" => $removeSpace1,
            "removeSpace2" => $removeSpace2,
            "length1" => $length1,
            "length2" => $length2,
            "commonChar" => $commonchar,
            "commonCar" => $commonCar,
            "transposisi" => $transposisi,
            "distance" => $distance,
            "prefix" => $prefix,
            "similarity" => $similirity,
            "similirity_no" => $similirity_no,
            "waktu" => endtime($start) . 's'
        ]);
    }
}
