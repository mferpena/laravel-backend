<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use Carbon\Carbon;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function registerEmployee(array $data)
    {
        $email = $this->generateEmail($data['first_name'], $data['paternal_name'], $data['employment_country']);
        $entryDate = Carbon::now()->format('Y-m-d H:i:s');
    
        return $this->employeeRepository->create([
            'first_name' => $data['first_name'],
            'paternal_name' => $data['paternal_name'],
            'maternal_name' => $data['maternal_name'],
            'other_names' => $data['other_names'] ?? null,
            'employment_country' => $data['employment_country'],
            'id_type' => $data['id_type'],
            'id_number' => $data['id_number'],
            'email' => $email,
            'entry_date' => $entryDate,
            'area' => $data['area'],
            'status' => 'Active',
            'registration_date' => Carbon::now(),
        ]);
    }

    public function updateEmployee(int $id, array $data)
    {
        $employee = $this->employeeRepository->find($id);

        if (!$employee) {
            return null;
        }

        if (isset($data['first_name']) || isset($data['paternal_name']) || isset($data['maternal_name'])) {
            $email = $this->generateEmail(
                $data['first_name'] ?? $employee->first_name,
                $data['paternal_name'] ?? $employee->paternal_name,
                $employee->employment_country
            );

            $data['email'] = $email;
        }

        $employee->update($data);

        return $employee;
    }

    public function getAllEmployees($perPage, $page, $filters)
    {
        $page = max(1, $page);

        $query = $this->employeeRepository->query();

        foreach ($filters as $key => $value) {
            if (!is_null($value)) {
                if ($key === 'status') {
                    $query->where($key, '=', $value);
                } else {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function deactivateEmployee(int $id)
    {
        $employee = $this->employeeRepository->find($id);
    
        if (!$employee) {
            return null;
        }
    
        $employee->update(['status' => 'Inactive']);
    
        return $employee;
    }

    protected function generateEmail(string $firstName, string $lastName, string $employment_country)
    {
        $lastName = str_replace(' ', '', $lastName);
    
        $domain = $this->getDomain($employment_country);
        $baseEmail = strtolower($firstName . '.' . $lastName);
        
        $email = $baseEmail . '@' . $domain;

        $email = $this->checkAndAdjustEmail($email);

        return $email;
    }

    protected function getDomain(string $employment_country)
    {
        return ($employment_country === 'Colombia') ? 'global.com.co' : 'global.com.us';
    }

    protected function checkAndAdjustEmail(string $email)
    {
        $existingEmployee = $this->employeeRepository->findByEmail($email);

        if ($existingEmployee) {
            $count = 1;
            $baseEmail = substr($email, 0, strpos($email, '@'));

            while ($existingEmployee) {
                $count++;
                $email = $baseEmail . '.' . $count . strstr($email, '@');
                $existingEmployee = $this->employeeRepository->findByEmail($email);
            }
        }

        return $email;
    }

    protected function validateEntryDate(string $entryDate)
    {
        $entryDate = Carbon::parse($entryDate);

        if ($entryDate->isFuture()) {
            $entryDate = Carbon::now();
        }

        $maxEntryDate = Carbon::now()->subMonth();
        if ($entryDate->lt($maxEntryDate)) {
            $entryDate = $maxEntryDate;
        }

        return $entryDate;
    }
}
