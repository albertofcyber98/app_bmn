<?php

// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require 'vendor/autoload.php';
require './function/function_global.php';

use Twilio\Rest\Client;

date_default_timezone_set("Asia/Makassar");

$datas =
query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
data_peminjaman.id as id, 
data_pegawai.nama as nama, 
data_pegawai.nip as nip, 
data_pegawai.no_telpon as no_telpon, 
data_pegawai.username as username, 
data_peminjaman.jumlah as jumlah,
data_peminjaman.pesan as pesan,
data_peminjaman.status as status,
data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
ON data_peminjaman.id_barang=data_barang.id INNER JOIN data_pegawai 
ON data_peminjaman.username=data_pegawai.username WHERE data_peminjaman.permohonan_peminjaman ='Ya' AND data_peminjaman.pengembalian ='Pending'");
foreach($datas as $data){
  $kondisi_id = $data['id'];
  $tgl_besok = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
  mysqli_query($conn, "UPDATE data_peminjaman SET pesan='$tgl_besok' WHERE id='$kondisi_id'");
  $no_telpon = $data['no_telpon'];
  $nama = $data['nama'];
  $sid    = "AC0a63e9e975001bc5f3453ce83185254a";
  $token  = "07bee0829f465a021f1ceb3fe751e249";
  $twilio = new Client($sid, $token);

  $to = "whatsapp:+" . $no_telpon;
  $from = "whatsapp:+14155238886";
  $body = "Halo " . $nama . ",\nWaktu pengembalian barangmu sudah jatuh tempo. Diharapakan pengembalian barang pada hari ini. jika ingin melakukan perpanjangan bisa kunjungi link dibawah ini untuk mengupdate tanggal pengambilan.\nhttps://bpk-bmn-sulsel.my.id/";


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
