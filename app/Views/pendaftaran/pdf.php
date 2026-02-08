<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran</title>
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
            border-left: 4px solid #007bff;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #007bff;
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
        .note {
            margin-top: 30px;
            padding: 10px;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
        }
        .note strong {
            color: #856404;
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
        <h2>BUKTI PENDAFTARAN PASIEN</h2>
        <p>Jl. Contoh No. 123, Kota, Provinsi | Telp: (021) 1234567</p>
    </div>

    <div class="info-box">
        <h3>Informasi Pendaftaran</h3>
        <table class="detail">
            <tr>
                <td>No. Registrasi</td>
                <td>: <strong style="font-size: 14px;"><?= $pendaftaran['noregistrasi'] ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal Registrasi</td>
                <td>: <?= date('d F Y', strtotime($pendaftaran['tglregistrasi'])) ?></td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <h3>Data Pasien</h3>
        <table class="detail">
            <tr>
                <td>No. Rekam Medis</td>
                <td>: <strong><?= $pendaftaran['norm'] ?></strong></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: <?= $pendaftaran['nama'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= $pendaftaran['alamat'] ?: '-' ?></td>
            </tr>
        </table>
    </div>

    <div class="note">
        <strong>Catatan:</strong><br>
        - Harap membawa bukti pendaftaran ini saat berkunjung<br>
        - Datang 15 menit sebelum jadwal pemeriksaan<br>
        - Untuk informasi lebih lanjut hubungi bagian pendaftaran
    </div>

    <div class="footer clearfix">
        <div style="float: left; width: 50%;">
            <p style="font-size: 10px; color: #666;">
                Dicetak pada: <?= date('d F Y H:i:s') ?><br>
                Dokumen ini sah tanpa tanda tangan
            </p>
        </div>
        <div class="signature">
            <p>Petugas Pendaftaran</p>
            <div class="signature-line">
                <?= session()->get('full_name') ?>
            </div>
        </div>
    </div>
</body>
</html>
