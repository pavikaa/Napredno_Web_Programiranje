<?php
// Učitavanje XML datoteke
$xml = simplexml_load_file('LV2.xml');

// Petlja kroz svaki "record" XML datoteci koji predstavlja osobu
foreach ($xml->record as $osoba) {
    // Dohvaćanje podataka o osobi
    $id = (string)$osoba->id;
    $ime = (string)$osoba->ime;
    $prezime = (string)$osoba->prezime;
    $email = (string)$osoba->email;
    $spol = (string)$osoba->spol;
    $slika = (string)$osoba->slika;
    $zivotopis = (string)$osoba->zivotopis;

    // Prikaz profila osobe
    echo '<div>';
    echo '<img src="' . $slika . '" alt="' . $ime . ' ' . $prezime . '">';
    echo '<h2>' . $ime . ' ' . $prezime . '</h2>';
    echo '<p>Email: ' . $email . '</p>';
    echo '<p>CV: ' . $zivotopis . '</p>';
    echo '</div>';
}

