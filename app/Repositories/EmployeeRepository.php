<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Employee;

class EmployeeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function query(): Builder
    {
        return Employee::query();
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function find($id)
    {
        return Employee::find($id);
    }

    public function all()
    {
        return Employee::all();
    }

    public function findByEmail(string $email)
    {
        return Employee::where('email', $email)->first();
    }
}
