<?php
require './function/function_koneksi.php';
function setujui_permohonan($data)
{
    global $conn;
    $id = $data['id'];
    $query = mysqli_query($conn, "SELECT*FROM data_peminjaman WHERE id='$id'");
    $result = mysqli_fetch_assoc($query);
    $id_barang = $result['id_barang'];
    $jumlah = $result['jumlah'];
    mysqli_query($conn, "UPDATE data_barang SET jumlah_barang=jumlah_barang-$jumlah WHERE id=$id_barang");
    mysqli_query($conn, "UPDATE data_peminjaman SET status='Peminjaman', permohonan_peminjaman='Ya' WHERE id=$id");
    return mysqli_affected_rows($conn);
}
function setujui_pengembalian($data)
{
    global $conn;
    $id = $data['id'];
    $query = mysqli_query($conn, "SELECT*FROM data_peminjaman WHERE id='$id'");
    $result = mysqli_fetch_assoc($query);
    $id_barang = $result['id_barang'];
    $jumlah = $result['jumlah'];
    mysqli_query($conn, "UPDATE data_barang SET jumlah_barang=jumlah_barang+$jumlah WHERE id=$id_barang");
    mysqli_query($conn, "UPDATE data_peminjaman SET status='Kembali', pengembalian='Ya' WHERE id=$id");
    return mysqli_affected_rows($conn);
}
function delete_permohonan($data)
{
    global $conn;
    $id = $data['id'];
    mysqli_query($conn, "DELETE FROM data_peminjaman WHERE id=$id");
    return mysqli_affected_rows($conn);
}
