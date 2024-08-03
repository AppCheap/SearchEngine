<?php
namespace App\Services\Search\Engine;


interface SearchServiceInterface {
    public function createCollection(): void;
    public function indexDocument(): string;
    public function search(): array;
}
