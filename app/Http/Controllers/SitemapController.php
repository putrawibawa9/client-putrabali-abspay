<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // 1. Ambil URL dinamis kamu dari database
        // $posts = Post::where('is_published', true)->get(); // Contoh ambil data
        
        // 2. Siapkan array untuk menampung semua URL
        $urls = [];

        // 3. Tambahkan URL statis (Halaman utama)
        $urls[] = [
            'loc' => url('/'),
            'lastmod' => now()->toDateString(), // Ambil tanggal hari ini
            'priority' => '1.0', // (Opsional)
            'changefreq' => 'daily' // (Opsional)
        ];
        
        // 4. Tambahkan URL statis lainnya (jika ada)
        $urls[] = [
            'loc' => url('/tentang-kami'), // Ganti dengan URL kamu
            'lastmod' => '2025-11-01', // Tanggal update terakhir halaman ini
            'priority' => '0.8',
            'changefreq' => 'monthly'
        ];

        // 5. Tambahkan URL dinamis dari database (Contoh dari $posts)
        // foreach ($posts as $post) {
        //     $urls[] = [
        //         'loc' => route('nama.route.post', $post->slug), // Ganti dgn route kamu
        //         'lastmod' => $post->updated_at->toDateString(),
        //         'priority' => '0.9',
        //         'changefreq' => 'weekly'
        //     ];
        // }

        // 6. Kembalikan view sitemap dengan data dan header XML
        return response()
            ->view('sitemap', compact('urls')) // 'sitemap' adalah nama file blade
            ->header('Content-Type', 'text/xml');
    }
}
