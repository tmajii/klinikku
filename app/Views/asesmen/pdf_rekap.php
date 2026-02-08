<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Data Asesmen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 10px;
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
            border-left: 4px solid #6f42c1;
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
            background-color: #6f42c1;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #5a32a3;
        }
        table.data-table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        table.data-table tr:hover {
            background-color: #e9ecef;
        }
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
            background-color: #e7e3fc;
            border: 1px solid #6f42c1;
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
        <h2>REKAP DATA ASESMEN</h2>
        <p>Jl. Contoh No. 123, Kota, Provinsi | Telp: (021) 1234567</p>
    </div>

    <div class="info-bar">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: <?= $tanggal_cetak ?></td>
            </tr>
            <tr>
                <td>Total Asesmen</td>
                <td>: <?= $total ?> Asesmen</td>
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
                <th style="width: 3%; text-align: center;">No</th>
                <th style="width: 11%;">No. Reg</th>
                <th style="width: 9%;">No. RM</th>
                <th style="width: 15%;">Nama Pasien</th>
                <th style="width: 10%;">Jenis Kunjungan</th>
                <th style="width: 30%;">Keluhan Utama</th>
                <th style="width: 10%;">Tgl. Kunjungan</th>
                <th style="width: 12%;">Tgl. Asesmen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($asesmen)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Tidak ada data asesmen
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($asesmen as $key => $a): ?>
                    <tr>
                        <td style="text-align: center;"><?= $key + 1 ?></td>
                        <td><?= $a['noregistrasi'] ?></td>
                        <td><?= $a['norm'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['jeniskunjungan'] ?></td>
                        <td><?= strlen($a['keluhan_utama']) > 80 ? substr($a['keluhan_utama'], 0, 80) . '...' : $a['keluhan_utama'] ?></td>
                        <td><?= date('d/m/Y', strtotime($a['tglkunjungan'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($a['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        TOTAL: <?= $total ?> ASESMEN TERDAFTAR
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
                        Kepala Bagian Medis
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
