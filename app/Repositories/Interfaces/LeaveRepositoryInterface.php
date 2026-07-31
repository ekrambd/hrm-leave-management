<?php

namespace App\Repositories\Interfaces;

interface LeaveRepositoryInterface
{
    public function getAll($request);

    public function create(array $data);

    public function statusUpdate($leave, $employee, array $data);

    public function notificationRead($id);

    public function saveAiReview($data);

    public function delete($leave);
}