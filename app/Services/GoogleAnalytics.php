<?php

namespace App\Services;

use Spatie\Analytics\Period;
use Analytics;

class GoogleAnalytics
{
    public function getReportStates()
    {
        $response = Analytics::performQuery(
            Period::years(1),
            'ga:pageviews',
            [
                //'metrics' => 'ga:pageTitle, ga:pageviews',
                'dimensions' => 'ga:city, ga:pagePath', //'ga:pagePath,ga:pageTitle', //'ga:yearMonth, ga:city',
                'sort' => '-ga:pageviews',
                'max-results' => '20',
            ]
        );

        return $response;
    }

    public function getReportMostVisited()
    {
        return Analytics::fetchMostVisitedPages(Period::months(6), 20);
    }

    public function getReportBrowsers()
    {
        return Analytics::fetchTopBrowsers(Period::months(6), 10);
    }
}
