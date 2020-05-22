<?php

namespace App\Repository;

interface CustomersRepositoryInterface extends RepositoryInterface
{
    public function import(string $fileName): bool;
}
