<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://kinopitka.ru/</loc>
    </url>
    <url>
        <loc>https://kinopitka.ru/blu-ray</loc>
    </url>
    @foreach($films as $film)
        <url>
            <loc>https://kinopitka.ru/film/{{$film->id}}</loc>
        </url>
    @endforeach
</urlset>