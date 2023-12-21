<?php

namespace App\Services;

use App\DTO\SeriesCreateFormInput;
use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Series;

class SeriesBuilder
{
    public static function buildSeries(SeriesCreateFormInput $seriesDTO) : Series
    {
        $series = new Series();
        $series->setName($seriesDTO->seriesName);
        $seasons = array_map(function($seasonNumber) use ($seriesDTO) {
            $season = new Season();
            $season->setNumber($seasonNumber);

            $episodes = array_map(function($episodeNumber) use ($season) {
                $episode = new Episode();
                $episode->setNumber($episodeNumber);
                $episode->setSeason($season);
                $season->addEpisode($episode);
                return $episode;
            }, range(1, $seriesDTO->episodesPerSeason));

            return $season;
        }, range(1, $seriesDTO->seasonsQuantity));

        foreach ($seasons as $season) {
            $series->addSeason($season);
        }
        return $series;
    }
}