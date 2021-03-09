<?php

namespace Sfneal\Honeypot\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Sfneal\Caching\Traits\Cacheable;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Queries\Query;

// todo: add tests
class TrackSpamQuery extends Query
{
    use Cacheable;

    /**
     * @var int
     */
    private $limit;

    /**
     * TrackSpamQuery constructor.
     *
     * @param int $limit
     */
    public function __construct(int $limit = 200)
    {
        $this->limit = $limit;
    }

    /**
     * Retrieve a Query builder.
     *
     * @return Builder
     */
    protected function builder(): Builder
    {
        return TrackSpam::query();
    }

    /**
     * Execute a DB query.
     *
     * @return Collection
     */
    public function execute(): Collection
    {
        return $this->builder()
            ->limit($this->limit)
            ->get();
    }

    /**
     * Retrieve the Query cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return TrackSpam::getTableName().':recent#'.$this->limit;
    }
}
