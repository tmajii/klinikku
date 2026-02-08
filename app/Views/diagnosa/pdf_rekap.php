<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Data Diagnosa</title>
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
            font-size: 9px;
        }
        .info-bar {
            margin: 15px 0;
            padding: 8px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .info-bar table {
            width: 100%;
        }
        .info-bar td {
            padding: 3px 0;
            font-size: 10px;
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
            background-color: #007bff;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #0056b3;
        }
        table.data-table td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-primary {
            background-color: #007bff;
            color: white;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
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
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 150px;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #e7f3ff;
            border: 1px solid #007bff;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
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
        <h2>REKAP DATA DIAGNOSA</h2>
        <p>Jl. Contoh No. 123, Kota, Provinsi | Telp: (021) 1234567</p>
    </div>

    <div class="info-bar">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: <?= $tanggal_cetak ?></td>
            </tr>
            <tr>
                <td>Total Data Diagnosa</td>
                <td>: <?= $total ?> Diagnosa</td>
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
                <th style="width: 10%;">No. RM</th>
                <th style="width: 18%;">Nama Pasien</th>
                <th style="width: 10%;">Kode ICD</th>
                <th style="width: 23%;">Nama Diagnosa</th>
                <th style="width: 10%; text-align: center;">Jenis</th>
                <th style="width: 15%;">Keluhan Utama</th>
                <th style="width: 10%;">Tgl. Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($diagnosa)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Tidak ada data diagnosa
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($diagnosa as $key => $d): ?>
                    <tr>
                        <td style="text-align: center;"><?= $key + 1 ?></td>
                        <td><?= $d['norm'] ?></td>
                        <td><?= $d['nama'] ?></td>
                        <td><?= $d['kode_icd'] ?: '-' ?></td>
                        <td><?= $d['nama_diagnosa'] ?></td>
                        <td style="text-align: center;">
                            <?php if ($d['jenis_diagnosa'] == 'primer'): ?>
                                <span class="badge badge-primary">PRIMER</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">SEKUNDER</span>
                            <?php endif; ?>
                        </td>
                        <td><?= substr($d['keluhan_utama'], 0, 30) ?><?= strlen($d['keluhan_utama']) > 30 ? '...' : '' ?></td>
                        <td><?= date('d/m/Y', strtotime($d['tglkunjungan'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        TOTAL: <?= $total ?> DIAGNOSA TERCATAT
    </div>

    <div class="footer clearfix">
        <div class="footer-left">
            <p style="font-size: 8px; color: #666;">
                Dokumen ini dicetak secara otomatis oleh sistem<br>
                Tanggal: <?= date('d F Y H:i:s') ?>
            </p>
        </div>
        <div class="footer-right">
            <div class="signature">
                <p style="font-size: 10px;">Mengetahui,</p>
                <div class="signature-box">
                    <div class="signature-line">
                        Kepala Bagian
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
