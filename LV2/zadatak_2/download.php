<?php
$target_dir = "uploads/";
$files = scandir($target_dir);

foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $file_path = $target_dir . $file;

        // Dekriptiranje datoteke
        $ciphertext = file_get_contents($file_path);
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $key = "7b4d3b3c118b1b3afb66144760fd13db";

        // Provjera HMAC integriteta
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (!hash_equals($hmac, $calcmac)) {
            echo "HMAC validacija neuspješna. Moguće je da je datoteka neovlašteno izmijenjena.";
        }

        // Dekripcija datoteke i spremanje dekriptiranje datoteke u privremenu datoteku
        $data = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $temp_file = tempnam(sys_get_temp_dir(), $file);
        file_put_contents($temp_file, $data);

        // Prikaz poveznice za preuzimanje dekriptirane datoteke
        echo "<a href=\"download.php?temp_file={$temp_file}&file={$file}\">Preuzimanje dekriptirane datoteke: {$file}</a><br>";

        //Preuzimanje dekriptirane datoteke
        if (isset($_GET['temp_file'], $_GET['file'])) {
            $temp_file = $_GET['temp_file'];
            $file = $_GET['file'];
            $data = file_get_contents($temp_file);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header('Content-Length: ' . strlen($data));
            echo $data;
        }
    }
}

