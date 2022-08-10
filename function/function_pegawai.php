<?php
require './function/function_koneksi.php';
function update_profil($data)
{
    global $conn;
    $username = $data['username'];
    $nip = $data['nip'];
    $nama = $data['nama'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $no_telpon = $data['no_telpon'];
    $password = $data['password'];
    $jabatan = $data['jabatan'];
    $unit_kerja = $data['unit_kerja'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    if ($password) {
        mysqli_query($conn, "UPDATE data_pegawai SET
        password='$hash_password',
        no_telpon='$no_telpon',
        jenis_kelamin='$jenis_kelamin',
        nama='$nama',
        nip='$nip',
        jabatan='$jabatan',
        unit_kerja='$unit_kerja'
        WHERE username='$username'");
        return mysqli_affected_rows($conn);
    } else {
        mysqli_query($conn, "UPDATE data_pegawai SET
        no_telpon='$no_telpon',
        jenis_kelamin='$jenis_kelamin',
        nama='$nama',
        nip='$nip',
        jabatan='$jabatan',
        unit_kerja='$unit_kerja'
        WHERE username='$username'");
        return mysqli_affected_rows($conn);
    }
}
