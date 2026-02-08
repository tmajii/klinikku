<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pasien - <?= $pasien['norm'] ?></title>
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
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin: 20px 0;
        }
        .info-title {
            background-color: #007bff;
            color: white;
            padding: 8px 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table td:first-child {
            width: 30%;
            font-weight: bold;
            color: #555;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 11px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 5px;
            min-width: 200px;
            text-align: center;
        }
        .print-date {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RUMAH SAKIT UMUM</h1>
        <p>Jl. Contoh No. 123, Kota, Provinsi</p>
        <p>Telp: (021) 1234567 | Email: info@rumahsakit.com</p>
    </div>

    <div class="info-section">
        <div class="info-title">DETAIL DATA PASIEN</div>
        <table>
            <tr>
                <td>No. Rekam Medis</td>
                <td>: <?= $pasien['norm'] ?></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: <?= $pasien['nama'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= $pasien['alamat'] ?: '-' ?></td>
            </tr>
            <tr>
                <td>Tanggal Terdaftar</td>
                <td>: <?= date('d F Y', strtotime($pasien['created_at'])) ?></td>
            </tr>
        </table>
    </div>

    <div class="print-date">
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?></p>
    </div>

    <div class="signature">
        <p>Petugas,</p>
        <br><br><br>
        <div class="signature-line">
            (_________________)
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem</p>
    </div>
</body>
</html>
