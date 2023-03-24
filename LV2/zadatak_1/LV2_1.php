<?php
// Podaci za spajanje na bazu podataka
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'LV2';

// Spajanje na bazu podataka
$conn = new mysqli($host, $username, $password, $dbname);

// Provjera uspješnosti spajanja na bazu podataka
if ($conn->connect_error) {
    die('Neuspješno spajanje na bazu podataka: ' . $conn->connect_error);
}

// Dohvaćanje svih tablica unutar baze podataka
$tables = array();
$result = $conn->query('SHOW TABLES');
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// Petlja kroz sve tablice unutar baze i sigurnosno kopiranje svake tablice u .txt.gz datoteku
foreach ($tables as $table) {
    $filename = 'backups/' . $table . '_' . date('Y-d-m_H-i-s') . '.txt.gz';
    $handle = gzopen($filename, 'w9');

    // Zapis SQL naredbi u datoteku sigurnosne kopije
    $result = $conn->query("SELECT * FROM $table");
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        $sql = "INSERT INTO $table VALUES (";
        for ($i = 0; $i < count($row); $i++) {
            $sql .= "'" . $conn->real_escape_string($row[$i]) . "',";
        }
        $sql = rtrim($sql, ',') . ");\n";
        gzwrite($handle, $sql);
    }

    gzclose($handle);
}

echo 'Sigurnosno kopiranje dovršeno!';
