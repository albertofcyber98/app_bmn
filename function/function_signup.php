<?php
require './function/function_koneksi.php';
function signup($data)
{
    global $conn;
    $username = $data['username'];
    $nip = $data['nip'];
    $nama = $data['nama'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $no_telpon = $data['no_telpon'];
    $password = $data['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO data_pegawai VALUES('$nip','$nama','$jenis_kelamin',$no_telpon,'','','$username','$hash_password','tidak aktif')");
    return mysqli_affected_rows($conn);
}
