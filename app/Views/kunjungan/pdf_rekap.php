<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Data Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 10px;
        }
        .info-bar {
            margin: 15px 0;
            padding: 8px;
            background-color: #f8f9fa;
            border-left: 4px solid #17a2b8;
        }
        .info-bar table {
            width: 100%;
        }
        .info-bar td {
            padding: 3px 0;
        }
        .info-bar td:first-child {
            width: 150px;
            font-weight: bold;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th {
            background-color: #17a2b8;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 11px;
            border: 1px solid #117a8b;
        }
        table.data-table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        table.data-table tr:hover {
            background-color: #e9ecef;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
            display: inline-block;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-info { background-color: #17a2b8; color: white; }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .footer-left {
            float: left;
            width: 50%;
        }
        .footer-right {
            float: right;
            width: 45%;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 150px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #d1ecf1;
            border: 1px solid #17a2b8;
            text-align: center;
            font-weight: bold;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RUMAH SAKIT UMUM</h1>
        <h2>REKAP DATA KUNJUNGAN</h2>
        <p>Jl. Contoh No. 123, Kota, Provinsi | Telp: (021) 1234567</p>
    </div>

    <div class="info-bar">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: <?= $tanggal_cetak ?></td>
            </tr>
            <tr>
                <td>Total Kunjungan</td>
                <td>: <?= $total ?> Kunjungan</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>: <?= session()->get('full_name') ?> (<?= ucfirst(session()->get('role_name')) ?>)</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 13%;">No. Registrasi</th>
                <th style="width: 10%;">No. RM</th>
                <th style="width: 22%;">Nama Pasien</th>
                <th style="width: 15%;">Jenis Kunjungan</th>
                <th style="width: 12%;">Tgl. Kunjungan</th>
                <th style="width: 12%;">Tgl. Input</th>
                <th style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($kunjungan)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Tidak ada data kunjungan
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($kunjungan as $key => $k): ?>
                    <tr>
                        <td style="text-align: center;"><?= $key + 1 ?></td>
                        <td><?= $k['noregistrasi'] ?></td>
                        <td><?= $k['norm'] ?></td>
                        <td><?= $k['nama'] ?></td>
                        <td>
                            <?php
                            $badgeClass = 'badge-info';
                            switch($k['jeniskunjungan']) {
                                case 'Rawat Jalan': $badgeClass = 'badge-success'; break;
                                case 'Rawat Inap': $badgeClass = 'badge-primary'; break;
                                case 'IGD': $badgeClass = 'badge-danger'; break;
                                case 'Kontrol': $badgeClass = 'badge-warning'; break;
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $k['jeniskunjungan'] ?></span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($k['tglkunjungan'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($k['created_at'])) ?></td>
                        <td style="text-align: center;">
                            <?php
                            $today = date('Y-m-d');
                            $tglKunjungan = date('Y-m-d', strtotime($k['tglkunjungan']));
                            if ($tglKunjungan == $today) {
                                echo '<span style="color: #28a745; font-weight: bold;">Hari Ini</span>';
                            } elseif ($tglKunjungan > $today) {
                                echo '<span style="color: #007bff;">Akan Datang</span>';
                            } else {
                                echo '<span style="color: #6c757d;">Selesai</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        TOTAL: <?= $total ?> KUNJUNGAN TERDAFTAR
    </div>

    <div class="footer clearfix">
        <div class="footer-left">
            <p style="font-size: 9px; color: #666;">
                Dokumen ini dicetak secara otomatis oleh sistem<br>
                Tanggal: <?= date('d F Y H:i:s') ?>
            </p>
        </div>
        <div class="footer-right">
            <div class="signature">
                <p>Mengetahui,</p>
                <div class="signature-box">
                    <div class="signature-line">
                        Kepala Bagian Pelayanan
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
