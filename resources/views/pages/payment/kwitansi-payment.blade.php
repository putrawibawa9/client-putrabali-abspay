<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 0; padding: 10px; }
        .card { border: 1px solid #222; padding: 10px; border-radius: 6px; }
        .header { text-align: center; margin-bottom: 8px; }
        .title { font-size: 14px; font-weight: bold; letter-spacing: .5px; }
        .brand { font-size: 11px; }
        .line { border-top: 1px dashed #555; margin: 6px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; vertical-align: top; }
        .label { width: 34%; color: #333; }
        .value { width: 66%; font-weight: 600; }
        .footer { margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end; }
        .note { font-size: 10px; color: #444; }
        .sign { text-align: right; }
        .amount { font-size: 13px; font-weight: 700; }
    </style>
</head>
<body>

@php
use Carbon\Carbon;

$dt = (!empty($receipt['date']) && !empty($receipt['time']))
    ? Carbon::parse($receipt['date'].' '.$receipt['time'])->locale('id')
    : null;

$prettyDateTime = $dt ? $dt->isoFormat('dddd, D MMMM YYYY, HH:mm') : '-';

// payment_month (English) → Indonesia
$map = [
    'january'=>'Januari','february'=>'Februari','march'=>'Maret','april'=>'April','may'=>'Mei','june'=>'Juni',
    'july'=>'Juli','august'=>'Agustus','september'=>'September','october'=>'Oktober','november'=>'November','december'=>'Desember'
];
$key = isset($receipt['payment_month']) ? strtolower(trim($receipt['payment_month'])) : null;
$paymentMonthId = $key ? ($map[$key] ?? $receipt['payment_month']) : '-';
@endphp

<div class="card">
    <div class="header">
        <div class="title">KWITANSI PEMBAYARAN</div>
        <div class="brand">Putra Bali English Course</div>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td class="label">Waktu</td>
            <td class="value">: {{ $prettyDateTime }}</td>
        </tr>
        <tr>
            <td class="label">Admin</td>
            <td class="value">: {{ $receipt['admin'] }}</td>
        </tr>
        <tr>
            <td class="label">Nis</td>
            <td class="value">: {{ $receipt['student_nis'] }}</td>
        </tr>
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="value">: {{ $receipt['student_name'] }}</td>
        </tr>
        <tr>
            <td class="label">Kursus/Kelas</td>
            <td class="value">: {{ $receipt['course_name'] }}</td>
        </tr>
        <tr>
            <td class="label">Tipe</td>
            <td class="value amount">: {{ $receipt['type'] }}</td>
        </tr>
        <tr>
            <td class="label">Bulan</td>
            <td class="value amount">: {{ $paymentMonthId }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah</td>
            <td class="value amount">: Rp {{ number_format($receipt['amount'], 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <div class="note">
            Terima kasih. Simpan kwitansi ini sebagai bukti pembayaran yang sah.
        </div>
    </div>
</div>
</body>
</html>
