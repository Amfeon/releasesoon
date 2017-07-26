<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://releasesoon.ru/</loc>
    </url>
    <url>
        <loc>https://releasesoon.ru/blu-ray</loc>
    </url>
    @foreach($films as $film)
        <url>
            <loc>https://releasesoon.ru/film/{{$film->id}}</loc>
        </url>
    @endforeach
</urlset>