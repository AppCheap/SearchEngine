<?php
namespace Appcheap\SearchEngine\Service\Engine\Models;

class SearchQuery {
    /**
     * @var string The search query string.
     */
    private $query;

    /**
     * @var array The filters to apply to the search query.
     */
    private $filters;

    /**
     * @var int The maximum number of results to return.
     */
    private $limit;

    /**
     * @var int The page number of the search results.
     */
    private $page;

    /**
     * SearchQuery constructor.
     *
     * @param string $query The search query string.
     * @param array $filters The filters to apply to the search query.
     * @param int $limit The maximum number of results to return.
     * @param int $page The page number of the search results.
     */
    public function __construct(string $query, array $filters = [], int $limit = 10, int $page = 1) {
        $this->query = $query;
        $this->filters = $filters;
        $this->limit = $limit;
        $this->page = $page;
    }

    /**
     * Get the search query string.
     *
     * @return string The search query string.
     */
    public function getQuery(): string {
        return $this->query;
    }

    /**
     * Get the filters to apply to the search query.
     *
     * @return array The filters to apply to the search query.
     */
    public function getFilters(): array {
        return $this->filters;
    }

    /**
     * Get the maximum number of results to return.
     *
     * @return int The maximum number of results to return.
     */
    public function getLimit(): int {
        return $this->limit;
    }

    /**
     * Get the page number of the search results.
     *
     * @return int The page number of the search results.
     */
    public function getPage(): int {
        return $this->page;
    }

    /**
     * Convert the search query to an array.
     *
     * @return array The search query as an array.
     */
    public function toArray(): array {
        return [
            'query' => $this->query,
            'filters' => $this->filters,
            'limit' => $this->limit,
            'page' => $this->page,
        ];
    }
}
