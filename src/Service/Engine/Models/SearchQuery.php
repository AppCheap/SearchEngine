<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

class SearchQuery
{
    private $q;
    private $query_by;
    // ... other parameters

    public function __construct(string $q, string $query_by)
    {
        $this->q = $q;
        $this->query_by = $query_by;
        // ... other defaults
    }

    // Getters
    public function getQ(): string
    {
        return $this->q;
    }

    public function getQueryBy(): string
    {
        return $this->query_by;
    }

    // ... getters for other parameters

    // Setters (with fluent interface for optional parameters)

    // ... setters for other parameters

    public function toArray(): array
    {
        $params = [
        'q' => $this->q,
        'query_by' => $this->query_by,
        ];
        return $params;
    }
}
