<?php
session_start();

if (!isset($_SESSION['npm'])) {
    header('Location: index.php');
    exit;
}

$nama = $_SESSION['nama'];
$npm = $_SESSION['npm'];

date_default_timezone_set('Asia/Jakarta');

$namaBulan = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

$bulanHariIni = (int) date('n');
$tahunHariIni = (int) date('Y');
$tanggalHariIni = (int) date('j');

$bulanSekarang = (int) ($_GET['bulan'] ?? $bulanHariIni);
$tahunSekarang = (int) ($_GET['tahun'] ?? $tahunHariIni);

if ($bulanSekarang < 1 || $bulanSekarang > 12) {
    $bulanSekarang = $bulanHariIni;
}

if ($tahunSekarang < 1970 || $tahunSekarang > 2100) {
    $tahunSekarang = $tahunHariIni;
}

$tanggalKalender = sprintf('%04d-%02d-01', $tahunSekarang, $bulanSekarang);
$jumlahHari = (int) date('t', strtotime($tanggalKalender));
$hariPertama = (int) date('N', strtotime($tanggalKalender));

$tanggalSebelumnya = strtotime('-1 month', strtotime($tanggalKalender));
$tanggalBerikutnya = strtotime('+1 month', strtotime($tanggalKalender));
$bulanSebelumnya = (int) date('n', $tanggalSebelumnya);
$tahunSebelumnya = (int) date('Y', $tanggalSebelumnya);
$bulanBerikutnya = (int) date('n', $tanggalBerikutnya);
$tahunBerikutnya = (int) date('Y', $tanggalBerikutnya);
$sedangBulanIni = $bulanSekarang === $bulanHariIni && $tahunSekarang === $tahunHariIni;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Universitas Teknokrat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-frame">
        <section class="dashboard-main">
            <header class="dashboard-topbar">
                <a class="dashboard-logo" href="beranda.php">
                    <img src="UNIVERSITASTEKNOKRAT.png" alt="Logo Universitas Teknokrat">
                    <span>
                        <strong>Universitas Teknokrat Indonesia</strong>
                        <small>Sistem Pembelajaran Daring</small>
                    </span>
                </a>

                <nav class="dashboard-nav">
                    <a href="beranda.php">Home</a>
                    <a class="active" href="beranda.php">Dashboard</a>
                    <a href="beranda.php">My courses</a>
                </nav>

                <div class="dashboard-actions">
                    <span class="action-icon" title="Notifications" aria-label="Notifications">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </span>
                    <span class="action-icon" title="Messages" aria-label="Messages">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </span>

                    <div class="profile-menu" id="profileMenu">
                        <button type="button" id="profileButton" aria-expanded="false" aria-controls="profileDropdown">
                            <span class="avatar dummy-profile" aria-label="Profile"></span>
                            <span class="chevron">v</span>
                        </button>
                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="#">Accessibility</a>
                            <a href="#">Profile</a>
                            <a href="#">Grades</a>
                            <a href="#">Calendar</a>
                            <a href="#">Private files</a>
                            <a href="#">Reports</a>
                            <a href="#">Preferences</a>
                            <a href="logout.php">Log out</a>
                        </div>
                    </div>

                    <div class="edit-mode">
                        <span>Edit mode</span>
                        <span class="toggle"></span>
                    </div>
                </div>
            </header>

            <main class="dashboard-content">
                <h1 class="dashboard-title">Dashboard</h1>

                <section class="timeline-card">
                    <h2>Timeline</h2>
                    <div class="timeline-tools">
                        <div class="timeline-filters">
                            <button type="button">Next 7 days v</button>
                            <button type="button">Sort by dates v</button>
                        </div>
                        <input type="text" placeholder="Search by activity type or name">
                    </div>

                    <div class="activity-empty">
                        <div class="activity-icon">List</div>
                        <p>No activities require action</p>
                    </div>
                </section>

                <section class="calendar-section">
                    <h2>Calendar</h2>
                    <div class="calendar-toolbar">
                        <select aria-label="Pilih kursus">
                            <option>All courses</option>
                        </select>
                        <button type="button">New event</button>
                    </div>

                    <div class="calendar-monthbar">
                        <a href="beranda.php?bulan=<?php echo $bulanSebelumnya; ?>&tahun=<?php echo $tahunSebelumnya; ?>">&lt; <?php echo $namaBulan[$bulanSebelumnya]; ?></a>
                        <h3><?php echo $namaBulan[$bulanSekarang] . ' ' . $tahunSekarang; ?></h3>
                        <a href="beranda.php?bulan=<?php echo $bulanBerikutnya; ?>&tahun=<?php echo $tahunBerikutnya; ?>"><?php echo $namaBulan[$bulanBerikutnya]; ?> &gt;</a>
                    </div>

                    <div class="calendar-grid">
                        <div class="weekday">Mon</div>
                        <div class="weekday">Tue</div>
                        <div class="weekday">Wed</div>
                        <div class="weekday">Thu</div>
                        <div class="weekday">Fri</div>
                        <div class="weekday">Sat</div>
                        <div class="weekday">Sun</div>

                        <?php for ($kosong = 1; $kosong < $hariPertama; $kosong++) : ?>
                            <div class="day empty"></div>
                        <?php endfor; ?>
                        <?php for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) : ?>
                            <div class="day <?php echo $sedangBulanIni && $tanggal === $tanggalHariIni ? 'today' : ''; ?>">
                                <span><?php echo $tanggal; ?></span>
                            </div>
                        <?php endfor; ?>
                        <?php
                        $totalKotak = ($hariPertama - 1) + $jumlahHari;
                        $sisaKotak = (7 - ($totalKotak % 7)) % 7;
                        for ($kosong = 1; $kosong <= $sisaKotak; $kosong++) :
                        ?>
                            <div class="day empty"></div>
                        <?php endfor; ?>
                    </div>
                </section>
            </main>
        </section>
    </div>
    <script>
        const profileMenu = document.getElementById('profileMenu');
        const profileButton = document.getElementById('profileButton');

        profileButton.addEventListener('click', function () {
            const isOpen = profileMenu.classList.toggle('open');
            profileButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', function (event) {
            if (!profileMenu.contains(event.target)) {
                profileMenu.classList.remove('open');
                profileButton.setAttribute('aria-expanded', 'false');
            }
        });
    </script>
</body>
</html>
