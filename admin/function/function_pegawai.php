<?php
require './function/function_koneksi.php';
function active($data)
{
    global $conn;
    $username = $data['username'];
    mysqli_query($conn, "UPDATE data_pegawai SET status='aktif' WHERE username='$username'");
    return mysqli_affected_rows($conn);
}
function delete($data)
{
    global $conn;
    $username = $data['username'];
    mysqli_query($conn, "DELETE FROM data_pegawai WHERE username='$username'");
    return mysqli_affected_rows($conn);
}
