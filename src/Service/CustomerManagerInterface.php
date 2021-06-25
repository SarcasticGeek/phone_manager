<?php

namespace App\Service;

interface CustomerManagerInterface
{
    public function list(int $page, int $limit);
}