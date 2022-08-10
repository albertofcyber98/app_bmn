<nav class="sidebar">
    <div class="d-flex justify-content-center py-5">
        <img src="../assets/images/logo.svg" alt="Logo" width="140px" height="40px" />
    </div>
    <div class="pt-2 d-flex flex-column gap-5">
        <div class="menu">
            <p>Dashboard Admin</p>
            <a href="index.php" class="item-menu
            <?= ($page === 1) ? 'active' : '' ?>
            ">
                <i class="icon ic-stats"></i>
                Dashboard
            </a>
            <a href="admin.php" class="item-menu
            <?= ($page === 2) ? 'active' : '' ?>
            ">
                <i class="icon ic-trans"></i>
                Akun Admin
            </a>
            <a href="pegawai.php" class="item-menu 
            <?= ($page === 3) ? 'active' : '' ?>
            ">
                <i class="icon ic-trans"></i>
                Akun Pegawai
            </a>
            <a href="barang.php" class="item-menu 
            <?= ($page === 4) ? 'active' : '' ?>
            ">
                <i class="icon ic-stats"></i>
                Data Barang
            </a>
            <a href="peminjaman.php" class="item-menu
            <?= ($page === 5) ? 'active' : '' ?>
            ">
                <i class="icon ic-msg"></i>
                Peminjaman
            </a>
            <a href="logout.php" class="item-menu">
                <i class="icon ic-logout"></i>
                Logout
            </a>
        </div>
    </div>
</nav>