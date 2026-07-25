<?php

namespace App\Repositories\Interfaces;

interface LeaveRepositoryInterface
{
    public function getAll($request);

    public function create(array $data);

    public function statusUpdate($leave, array $data);

    public function notificationRead($id);

    public function delete($leave);
}