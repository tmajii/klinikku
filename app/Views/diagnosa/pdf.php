<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 11px;
        }
        .info-box {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #dc3545;
            font-size: 16px;
        }
        table.detail {
            width: 100%;
            border-collapse: collapse;
        }
        table.detail td {
            padding: 8px 5px;
            border-bottom: 1px solid #e9ecef;
        }
        table.detail td:first-child {
            width: 180px;
            font-weight: bold;
            color: #495057;
        }
        table.detail td:last-child {
            color: #212529;
        }
        .diagnosa-box {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8d7da;
            border: 2px solid #dc3545;
            border-radius: 4px;
        }
        .diagnosa-box h4 {
            margin: 0 0 10px 0;
            color: #721c24;
            font-size: 14px;
        }
        .diagnosa-box p {
            margin: 5px 0;
            line-height: 1.6;
            color: #212529;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 11px;
        }
        .badge-primer {
            background-color: #dc3545;
            color: white;
        }
        .badge-sekunder {
            background-color: #ffc107;
            color: #212529;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .signature {
            float: right;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 70px;
            border-top: 1px solid #000;
            padding-top: 5px;
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
        <h2>HASIL DIAGNOSA PASIEN</h2>
        <p>Jl. Contoh No. 123, Kota, Provinsi | Telp: (021) 1234567</p>
    </div>

    <div class="info-box">
        <h3>Data Pasien</h3>
        <table class="detail">
            <tr>
                <td>No. Rekam Medis</td>
                <td>: <strong><?= $diagnosa['norm'] ?></strong></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: <?= $diagnosa['nama'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= $diagnosa['alamat'] ?: '-' ?></td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <h3>Informasi Kunjungan & Asesmen</h3>
        <table class="detail">
            <tr>
                <td>No. Registrasi</td>
                <td>: <?= $diagnosa['noregistrasi'] ?></td>
            </tr>
            <tr>
                <td>Jenis Kunjungan</td>
                <td>: <?= $diagnosa['jeniskunjungan'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Kunjungan</td>
                <td>: <?= date('d F Y', strtotime($diagnosa['tglkunjungan'])) ?></td>
            </tr>
            <tr>
                <td>Keluhan Utama</td>
                <td>: <?= $diagnosa['keluhan_utama'] ?></td>
            </tr>
        </table>
    </div>

    <div class="diagnosa-box">
        <h4>DIAGNOSA:</h4>
        <table class="detail" style="background: transparent;">
            <tr>
                <td>Kode ICD</td>
                <td>: <strong><?= $diagnosa['kode_icd'] ?: '-' ?></strong></td>
            </tr>
            <tr>
                <td>Nama Diagnosa</td>
                <td>: <strong><?= $diagnosa['nama_diagnosa'] ?></strong></td>
            </tr>
            <tr>
                <td>Jenis Diagnosa</td>
                <td>: <span class="badge badge-<?= $diagnosa['jenis_diagnosa'] ?>"><?= strtoupper($diagnosa['jenis_diagnosa']) ?></span></td>
            </tr>
            <?php if (!empty($diagnosa['keterangan'])): ?>
            <tr>
                <td>Keterangan</td>
                <td>: <?= $diagnosa['keterangan'] ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>Tanggal Diagnosa</td>
                <td>: <?= date('d F Y H:i', strtotime($diagnosa['created_at'])) ?></td>
            </tr>
        </table>
    </div>

    <div class="footer clearfix">
        <div style="float: left; width: 50%;">
            <p style="font-size: 10px; color: #666;">
                Dicetak pada: <?= date('d F Y H:i:s') ?><br>
                Dokumen ini sah tanpa tanda tangan
            </p>
        </div>
        <div class="signature">
            <p>Dokter Pemeriksa</p>
            <div class="signature-line">
                <?= session()->get('full_name') ?>
            </div>
        </div>
    </div>
</body>
</html>
