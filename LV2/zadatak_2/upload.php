<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Provjera je li datoteka pdf, jpeg ili png
    if ($fileType != "pdf" && $fileType != "jpeg" && $fileType != "png") {
        echo "Greška, dozvoljene su samo PDF, JPEG, i PNG datoteke.";
        $uploadOk = 0;
    }

    // Provjera je li datoteka prevelika
    if ($_FILES["file"]["size"] > 500000) {
        echo "Greška, vaša datoteka je prevelika.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Greška, vaša datoteka nije prenesena.";
    } else {
        // Enkriptiranje datoteke
        $data = file_get_contents($_FILES["file"]["tmp_name"]);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $key = "7b4d3b3c118b1b3afb66144760fd13db";
        $ciphertext_raw = openssl_encrypt($data, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);

        // Spremanje enkriptirane datoteke
        file_put_contents($target_file, $ciphertext);
        echo "Datoteka " . basename($_FILES["file"]["name"]) . " je prenesena i enkriptirana.";
    }
}

