{{-- @dd($student) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pembayaran - Putra Bali English Course</title>
    <style>
        @page {
            size: 112mm 190mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 8px;
            font-family: Arial, sans-serif;
            width: 112mm;
            height: 190mm;
            box-sizing: border-box;
        }
        .card {
            width: 100%;
            height: 60%;
            position: relative;
            border: 1px solid #000;
            padding: 5px;
        }
        .border-pattern {
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            border: 1px solid navy;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            display: inline-block;
            font-weight: bold;
            margin-right: 5px;
            font-size: 14px;
        }
        .logo img {
            width: 30px;
            height: 30px;
        }
        .title {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
        }
        .address {
            font-size: 8px;
            margin: 2px 0;
        }
        .form-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
        .info-section {
            margin-bottom: 10px;
            font-size: 10px;
        }
        .info-row {
            margin: 3px 0;
        }
        .info-label {
            display: inline-block;
            width: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }
        .footer {
            font-size: 8px;
            text-align: center;
            margin-top: 10px;
        }
        .contact {
            text-align: center;
            margin-top: 5px;
            font-size: 9px;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="border-pattern"></div>
        <div class="header">
            <div class="logo">Pb</div>
            <div class="title">LEMBAGA KURSUS DAN PELATIHAN</div>
            <div class="title">PUTRA BALI ENGLISH COURSE</div>
            <div class="address">
                - Br. Pekuwudan, Sukawati - Br. Apuan - Singapadu<br>
                Telp.0361-946171-8 - Email: Putrabali45@gmail.com
            </div>
        </div>
        
        <div class="form-title">KARTU PEMBAYARAN</div>
        
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Nama</span>: {{ $student['name'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Nis</span>:    {{ $student['nis'] }}
            </div>
     @php
    $classNames = implode(', ', array_column($student['courses'], 'alias'));
    $subjects = implode(', ', array_column($student['courses'], 'subject'));
@endphp

<div class="info-row">
    <span class="info-label">Kelas</span>: {{ $classNames }}
</div>
<div class="info-row">
    <span class="info-label">Subject</span>: {{ $subjects }}
</div>


        </div>
        
        <table>
            <tr>
                <th>BULAN</th>
                <th>Jumlah</th>
                <th>Paraf</th>
                <th>Tanggal</th>
            </tr>
            <tr>
                <td>Pendaftaran</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Modul Semester 1</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Juni 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Juli 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Agustus 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>September 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Oktober 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>November 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Desember 23</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        
        <div class="footer">
            Pembayaran setelah tanggal 5 (lima) bunga1 1%<br>
            Apabila ada perhatian pembayaran, disk yang dipergunakan adalah disk di LKP Putra Bali English Course
        </div>
        
        <div class="contact">
            ☎0857 3810 8556 / 089 792 23519
        </div>
    </div>
</body>
</html>