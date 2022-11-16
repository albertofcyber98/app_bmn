-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Agu 2022 pada 10.49
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app_bmn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_admin`
--

CREATE TABLE `data_admin` (
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_admin`
--

INSERT INTO `data_admin` (`username`, `nama`, `password`) VALUES
('leo', 'leo', '$2y$10$/mD.i6yv8zfeGrjIKneyL.Jnk7qY1PuL6knFEWsh1S.wf60x0imRy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_barang`
--

CREATE TABLE `data_barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah_barang` int(10) NOT NULL,
  `merk_barang` varchar(100) NOT NULL,
  `satuan_barang` varchar(50) NOT NULL,
  `ruangan` varchar(100) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_barang`
--

INSERT INTO `data_barang` (`id`, `nama_barang`, `jumlah_barang`, `merk_barang`, `satuan_barang`, `ruangan`, `foto`) VALUES
(2, 'Pompa Air', 2, 'DAB', 'Unit', '', '62f88f95a5f8f.png'),
(3, 'Laptop', 2, 'ASUS VIVOBOOK A416MAO-HD423', 'Unit', 'B201', '62f64502bf13c.png'),
(9, 'Meja besi', 1, 'olimpic', 'Buah', '607', '62fadeb4ac252.png'),
(10, 'camera', 5, 'canon', 'Buah', '103', '630028299ef78.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `nip` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `unit_kerja` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_pegawai`
--

INSERT INTO `data_pegawai` (`nip`, `nama`, `jenis_kelamin`, `no_telpon`, `jabatan`, `unit_kerja`, `username`, `password`, `status`) VALUES
('181076', 'leonardo', 'L', '6282290409080', 'seketaris', 'HUMAS', 'leo', '$2y$10$nlBLGP5.JRSeCXBdHz9Y6.6dRNQM0SSqCcH8Qv0VHhBgo7ip03ILC', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_peminjaman`
--

CREATE TABLE `data_peminjaman` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `permohonan_peminjaman` enum('Ya','Pending') NOT NULL,
  `pengembalian` enum('Ya','Pending') NOT NULL,
  `status` varchar(20) NOT NULL,
  `pesan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_peminjaman`
--

INSERT INTO `data_peminjaman` (`id`, `username`, `id_barang`, `jumlah`, `tanggal_peminjaman`, `tanggal_pengembalian`, `permohonan_peminjaman`, `pengembalian`, `status`, `pesan`) VALUES
(31, 'leo', 9, 2, '2022-08-20', '2022-08-21', 'Ya', 'Pending', 'Peminjaman', '2022-08-22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_peminjaman`
--
ALTER TABLE `data_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `data_peminjaman`
--
ALTER TABLE `data_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_peminjaman`
--
ALTER TABLE `data_peminjaman`
  ADD CONSTRAINT `data_peminjaman_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
