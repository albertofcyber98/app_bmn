<?php
require './function/function_koneksi.php';
function add_permohonan($data)
{
    global $conn;
    $username = $data['username'];
    $id_barang = $data['id_barang'];
    $jumlah = $data['jumlah'];
    $tanggal_peminjaman = $data['tanggal_peminjaman'];
    $tanggal_pengembalian = $data['tanggal_pengembalian'];
    $pesan = "0000-00-00";
    $queryCek = mysqli_query($conn, "SELECT*FROM data_barang WHERE id=$id_barang");
    $resultCek = mysqli_fetch_assoc($queryCek);
    if ($jumlah > $resultCek['jumlah_barang']) {
        return 0;
    } else {
        mysqli_query($conn, "INSERT INTO data_peminjaman 
        VALUES(NULL,'$username',$id_barang,$jumlah,'$tanggal_peminjaman','$tanggal_pengembalian','Pending','Pending','Permohonan','$tanggal_pengembalian')");
        return mysqli_affected_rows($conn);
    }
}
function update_permohonan($data)
{
    global $conn;
    $id = $data['id'];
    $tanggal_pengembalian = $data['tanggal_pengembalian'];
    mysqli_query($conn, "UPDATE data_peminjaman SET tanggal_pengembalian='$tanggal_pengembalian',pesan='$tanggal_pengembalian' WHERE id=$id");
    return mysqli_affected_rows($conn);
}
function delete_permohonan($data)
{
    global $conn;
    $id = $data['id'];
    mysqli_query($conn, "DELETE FROM data_peminjaman WHERE id='$id'");
    return mysqli_affected_rows($conn);
}
