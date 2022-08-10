<?php

// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require '../vendor/autoload.php';
require './function/function_koneksi.php';

use Twilio\Rest\Client;

date_default_timezone_set("Asia/Makassar");

function send($data)
{
    global $conn;
    $id = $data['id'];
    $tgl_besok = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
    mysqli_query($conn, "UPDATE data_peminjaman SET pesan='$tgl_besok' WHERE id='$id'");
    $no_telpon = $data['no_telpon'];
    $nama = $data['nama'];
    $sid    = "AC9506361c6af943cb60881bd8739973ba";
    $token  = "8383df57d5715517aa94b3538a829d79";
    $twilio = new Client($sid, $token);

    $to = "whatsapp:" . $no_telpon;
    $from = "whatsapp:+14155238886";
    $body = "Halo " . $nama . ",\nWaktu pengembalian barangmu sudah jatuh tempo. Jika ingin melakukan perpanjang bisa kunjung link dibawah untuk mengupdate tanggal pengembalian.\nwww.google.com";


    $message = $twilio->messages
        ->create(
            $to, // to 
            array(
                "from" => $from,
                "body" => $body
            )
        );
    return true;
}
