<?php

//Sučelje iRadovi koje definira tri tražene metode: create koja prima parametar data, save i read
interface iRadovi
{
    public function create($data);

    public function save();

    public function read();
}

//Klasa DiplomskiRadovi koja implementira sučelje iRadovi i implementira metode create, save i read
class DiplomskiRadovi implements iRadovi
{
    //Inicijalizacija potrebnih varijabli
    private $id = NULL;
    private $naziv_rada = NULL;
    private $tekst_rada = NULL;
    private $link_rada = NULL;
    private $oib_tvrtke = NULL;


    //Konstruktor klase DiplomskiRadovi, prima parametar data i sprema podatke u odgovarajuće varijable
    function __construct($data)
    {
        $this->id = uniqid();
        $this->naziv_rada = $data['naziv_rada'];
        $this->tekst_rada = $data['tekst_rada'];
        $this->link_rada = $data['link_rada'];
        $this->oib_tvrtke = $data['oib_tvrtke'];
    }

//Implementacija funkcije create poziva konstruktor klase DiplomskiRadovi kojemu se predaje parametar data
    function create($data)
    {
        self::__construct($data);
    }

    //Funkcija readData koja vraća polje parametara
    function readData()
    {
        return array('id' => $this->id, 'naziv_rada' => $this->naziv_rada, 'tekst_rada' => $this->tekst_rada, 'link_rada' => $this->link_rada, 'oib_tvrtke' => $this->oib_tvrtke);
    }

    //Funkcija read, povezuje se na lokalnu MySQL bazu te čita i ispisuje podatke zapisane u njoj
    function read()
    {
        //Spajanje na lokalnu MySQL bazu imena radovi
        $connection = mysqli_connect('localhost', 'root', '', 'radovi');
        if (!$connection) {
            echo 'Connection error: ' . mysqli_connect_error();
        }

        //Čitanje svih podataka iz tablice diplomski_radovi
        $sql = "SELECT * FROM diplomski_radovi";

        //Query na bazu
        $result = mysqli_query($connection, $sql);

        //Dohvaćanje svih redova i spremanje u array
        $dipl_radovi = mysqli_fetch_all($result);

        //Prekid veze s bazom
        mysqli_close($connection);

        //Ispis dohvaćenih podataka
        print_r($dipl_radovi);
    }

    //Funkcija read, povezuje se na lokalnu MySQL bazu te sprema podatke u nju
    function save()
    {
        //Spajanje na lokalnu MySQL bazu imena radovi
        $connection = mysqli_connect('localhost', 'root', '', 'radovi');
        if (!$connection) {
            echo 'Connection error: ' . mysqli_connect_error();
        }

        //Čitanje podataka za spremanje iz klase
        $id = $this->id;
        $naziv = $this->naziv_rada;
        $tekst = $this->tekst_rada;
        $link = $this->link_rada;
        $oib = $this->oib_tvrtke;

        //Spremanje podataka u bazu
        $sql = "INSERT INTO diplomski_radovi (`id`, `naziv_rada`, `tekst_rada`, `link_rada`, `oib_tvrtke`) VALUES ('$id', '$naziv', '$tekst','$link', '$oib')";

        //Query na bazu
        mysqli_query($connection, $sql);

        //Prekid veze s bazom
        mysqli_close($connection);
    }
}


$redni_broj = 2;
//Inicijalizacija cURL sesije
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://stup.ferit.hr/index.php/zavrsni-radovi/page/$redni_broj");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Izvođenje cURL sesije
$response = curl_exec($ch);

//Provjera cURL sesije
if (curl_errno($ch)) {
    echo 'Greška: ' . curl_error($ch);
}

//Prekid cURL sesije
curl_close($ch);

//Uključivanje parsera
require_once('simple_html_dom.php');

//Učitavanje responsea u html DOM dokument
$dom = new DOMDocument();
@ $dom->loadHTML($response);

$xpath = new DOMXpath($dom);

//Pretraga i spremanje parametara
$headers = $xpath->query("//h2[contains(@class,'blog-shortcode-post-title')]");
$links = $xpath->query("//h2[contains(@class,'blog-shortcode-post-title')]/a");
$oibs = $xpath->query("//article[contains(@class,'fusion-post-medium')]//img");

//Broj headera
$count = $headers->length;

//Prazni arrayevi koji će biti popunjeni podacima
$title_array = array();
$tekst_array = array();
$links_array = array();
$oibs_array = array();

//Petlje koje prolaze kroz headere, linkove i oibe te pune arrayeve potrebnim podacima
foreach ($headers as $header) {
    $title_text = $header->textContent;
    $title_array[] = $title_text;
}

foreach ($links as $link) {
    $href = $link->getAttribute("href");
    $links_array[] = $href;

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $href);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

    $htmlTekst = curl_exec($ch2);

    $domTekst = new DOMDocument();
    @ $domTekst->loadHTML($htmlTekst);

    $tekst = NULL;

    $paragraphs = $domTekst->getElementsByTagName('p');
    foreach ($paragraphs as $paragraph) {
        $tekst .= $paragraph->textContent;
    }
    $tekst_array[] = $tekst;
}

foreach ($oibs as $oib) {
    $src = $oib->getAttribute("src");

    $filename = basename($src);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $oib_without_extension = pathinfo($filename, PATHINFO_FILENAME);

    $oibs_array[] = $oib_without_extension;
}

for ($i = 0; $i < $count; $i++) {
    $rad = array(
        'naziv_rada' => $title_array[$i],
        'tekst_rada' => $tekst_array[$i],
        'link_rada' => $links_array[$i],
        'oib_tvrtke' => $oibs_array[$i]
    );

    $novi_rad = new DiplomskiRadovi($rad);

    $info_rad = $novi_rad->readData();

    echo "<p>ID: {$info_rad['id']}.</p>";
    echo "<p>NAZIV RADA: {$info_rad['naziv_rada']}.</p>";
    echo "<p>TEKST RADA: {$info_rad['tekst_rada']}.</p>";
    echo "<p>LINK RADA: {$info_rad['link_rada']}.</p>";
    echo "<p>OIB TVRTKE: {$info_rad['oib_tvrtke']}.</p>";
    $novi_rad->save();
}

?>

<!--HTML dokument stranice koja ispisuje podatke spremljene u tablici diplomski_radovi-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Napredno Web Programiranje-LV1</title>
</head>
<body>
<p>
    <?php
    echo "Podaci spremljeni u tablicu diplomski_radovi:" . "<br>";
    $novi_rad->read();
    ?>
</p>
</body>
</html>