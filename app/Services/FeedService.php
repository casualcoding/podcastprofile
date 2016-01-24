<?php

namespace App\Services;

use SimplePie;

class FeedService
{
    /**
     * Get rss feeds from opml xml file.
     *
     * @param  file  $file
     * @return Array
     */
    public function parseOpml($file)
    {
        $feeds = [];
        $xml = simplexml_load_file($file);

        // The standard OPML structure is
        // <body> <outline ... /> <outline ... /> </body>
        $outlines = $xml->body->outline;

        // Pocket Casts and some other clients use the structure
        // <body> <outline> <outline ... /> <outline ... /> <outline> </body>
        if (isset($xml->body->outline->outline)) {
            $outlines = $xml->body->outline->outline;
        }

        foreach ($outlines as $outline) {
            $feeds[] = (string) $outline['xmlUrl'];
        }

        return $feeds;
    }

    /**
    * Get feed details from rss url.
    *
    * @param  string  $url
    * @return Array
    */
    public function loadDetailsFromRss($url)
    {
        $feed = new SimplePie();
        $feed->set_cache_location(__DIR__.'/../../cache');
        $feed->set_feed_url($url);
        $feed->init();

        $title = $feed->get_title();
        $link = $feed->get_link();
        $summary = $feed->get_channel_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'summary')[0]['data'];

        // <itunes:image href=...>
        $image = $feed->get_channel_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'image')[0]['attribs']['']['href'];
        if ($image == null) {
            // <image><url>...</url></image>
            $image = $feed->get_channel_tags('', 'image')[0]['child']['']['url'][0]['data'];
        }

        return [
            'title' => $title,
            'link' => $link,
            'summary' => $summary,
            'image' => $image,
        ];
    }
}
