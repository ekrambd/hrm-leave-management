<?php

namespace App\Repositories\Interfaces;

interface DesignationRepositoryInterface
{
    public function getAll($request);

    public function create(array $data);

    public function update($designation, array $data);

    public function delete($designation);
}