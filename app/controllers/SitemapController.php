<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\MantraRepository;
use App\Repositories\NavadurgaRepository;
use App\Repositories\SevaRepository;

class SitemapController extends Controller
{
    public function index(Request $request): void
    {
        $scheme = ((($_SERVER['HTTPS'] ?? '') !== '' && ($_SERVER['HTTPS'] ?? '') !== 'off')) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = $scheme . '://' . $host . base_path();

        $urls = [
            ['loc' => '/', 'priority' => '1.0'],
            ['loc' => '/navadurga', 'priority' => '0.9'],
            ['loc' => '/navaratri', 'priority' => '0.9'],
            ['loc' => '/puja-planning', 'priority' => '0.7'],
            ['loc' => '/puja-items', 'priority' => '0.6'],
            ['loc' => '/seva', 'priority' => '0.8'],
            ['loc' => '/daily-guide', 'priority' => '0.6'],
            ['loc' => '/children', 'priority' => '0.5'],
            ['loc' => '/family', 'priority' => '0.5'],
            ['loc' => '/environment', 'priority' => '0.5'],
            ['loc' => '/learning', 'priority' => '0.6'],
            ['loc' => '/mantras', 'priority' => '0.6'],
            ['loc' => '/articles', 'priority' => '0.6'],
            ['loc' => '/calendar', 'priority' => '0.6'],
            ['loc' => '/faq', 'priority' => '0.4'],
            ['loc' => '/gallery', 'priority' => '0.4'],
            ['loc' => '/about', 'priority' => '0.3'],
            ['loc' => '/contact', 'priority' => '0.3'],
        ];

        foreach ((new NavadurgaRepository())->allOrdered() as $n) {
            $urls[] = ['loc' => '/navadurga/' . $n['slug'], 'priority' => '0.8'];
        }
        for ($d = 1; $d <= 9; $d++) {
            $urls[] = ['loc' => '/navaratri/day/' . $d, 'priority' => '0.7'];
        }
        foreach ((new SevaRepository())->all(['status' => 'active']) as $s) {
            $urls[] = ['loc' => '/seva/' . $s['slug'], 'priority' => '0.6'];
        }
        foreach ((new MantraRepository())->allActive() as $m) {
            $urls[] = ['loc' => '/mantras/' . $m['slug'], 'priority' => '0.5'];
        }
        foreach ((new ArticleRepository())->published(1, 500)['data'] as $a) {
            $urls[] = ['loc' => '/articles/' . $a['slug'], 'priority' => '0.6'];
        }

        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            echo '  <url><loc>' . htmlspecialchars($base . $u['loc'], ENT_QUOTES, 'UTF-8') . '</loc><priority>' . $u['priority'] . '</priority></url>' . "\n";
        }
        echo '</urlset>';
    }
}
