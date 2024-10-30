<?php

namespace Nokaut\BuybloApiKit\Repository;


interface AsyncRepositoryInterface
{
    public function clearAllFetches();

    public function fetchAllAsync();
}