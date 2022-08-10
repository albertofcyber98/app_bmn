<?php
require './function/function_global.php';
function add_barang($data)
{
    global $conn;
    $nama_barang = $data['nama_barang'];
    $jumlah_barang = $data['jumlah_barang'];
    $merk_barang = $data['merk_barang'];
    $satuan_barang = $data['satuan_barang'];
    $ruangan = $data['ruangan'];
    $foto = upload_foto();
    mysqli_query($conn, "INSERT INTO data_barang 
    VALUES(NULL,'$nama_barang','$jumlah_barang',
    '$merk_barang','$satuan_barang','$ruangan','$foto')");
    return mysqli_affected_rows($conn);
}
function update_barang($data)
{
    global $conn;
    $id = $data['id'];
    $nama_barang = $data['nama_barang'];
    $jumlah_barang = $data['jumlah_barang'];
    $merk_barang = $data['merk_barang'];
    $satuan_barang = $data['satuan_barang'];
    $ruangan = $data['ruangan'];
    $foto_lama = $data['fileLama'];
    if ($_FILES['foto']['error'] === 4) {
        $foto = $foto_lama;
    } else {
        $foto = upload_foto();
        unlink("img/$foto_lama");
    }
    mysqli_query($conn, "UPDATE data_barang SET nama_barang='$nama_barang',
    jumlah_barang=$jumlah_barang,
    merk_barang='$merk_barang',
    satuan_barang='$satuan_barang',
    ruangan='$ruangan',
    foto='$foto' WHERE id='$id'");
    return mysqli_affected_rows($conn);
}
function delete_barang($data)
{
    global $conn;
    $id = $data['id'];
    $foto = $data['foto'];
    unlink("img/$foto");
    mysqli_query($conn, "DELETE FROM data_barang WHERE id='$id'");
    return mysqli_affected_rows($conn);
}
