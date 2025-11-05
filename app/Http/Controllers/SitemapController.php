<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
   public function index()
    {
        // 1. Siapkan array untuk menampung semua URL
        $urls = [];

        // 2. Tambahkan HANYA URL statis (Halaman utama / default)
        $urls[] = [
            'loc' => url('/'),
            'lastmod' => now()->toDateString(), // Ambil tanggal hari ini
            'priority' => '1.0', // Prioritas tertinggi
            'changefreq' => 'daily' // Seberapa sering berubah
        ];

        // 3. Kembalikan view sitemap dengan data dan header XML
        return response()
            ->view('sitemap', compact('urls')) // 'sitemap' adalah nama file blade
            ->header('Content-Type', 'text/xml');
    }
}
