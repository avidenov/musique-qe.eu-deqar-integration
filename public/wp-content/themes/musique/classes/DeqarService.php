<?php

namespace Musique;

class DeqarService
{

    private $deqarRestClient;

    public function __construct(DeqarRestClient $deqarRestClient)
    {
        $this->deqarRestClient = $deqarRestClient;
    }

    public function getReportsByAgency(?int $offset = 0)
    {
        $response = $this->deqarRestClient->request(
            'browse/reports/',
            [
                'agency' => get_field('deqar_agency_name', 'options'),
                'offset' => $offset,
                'limit' => 10,
                'ordering' => '-valid_from',
            ]
        );

        return $response;
    }

    public function getReportById(int $reportId)
    {
        $response = $this->deqarRestClient->request('browse/reports/' . $reportId . '/');

        return $response;
    }
}
