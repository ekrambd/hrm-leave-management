<?php
use App\Models\Department;
use App\Models\Designation;

function user()
{
	$user = auth()->user();
	return $user;
}

function departments()
{
	$departments = Department::get();
	return $departments;
}

function designations()
{
	$designations = Designation::get();
	return $designations;
}