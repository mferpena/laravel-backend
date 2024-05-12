<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Http\Controllers\Validators\RegisterEmployeeValidator;
use App\Http\Controllers\Validators\UpdateEmployeeValidator;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function employeeDeactivation(Request $request, $id)
    {
        try {
            $this->employeeService->deactivateEmployee($id);
    
            return response()->json([
                'statusCode' => 200,
                'message' => 'Empleado desactivado exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function employeeRegistration(Request $request)
    {
        try {
            $validator = RegisterEmployeeValidator::validate($request);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 500,
                    'errors' => $validator->errors(),
                    'message' => 'Error en la validacion de datos.',
                ], 500);
            }
    
            $data = $request->all();
            $this->employeeService->registerEmployee($data);
    
            return response()->json([
                'statusCode' => 200,
                'message' => 'Empleado registrado exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function employeeEdit(Request $request, $id)
    {
        try {
            $validator = UpdateEmployeeValidator::validate($request);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 500,
                    'errors' => $validator->errors(),
                    'message' => 'Error en la validacion de datos.',
                ], 500);
            }
    
            $data = $request->all();
            $this->employeeService->updateEmployee($id, $data);
    
            return response()->json([
                'statusCode' => 200,
                'message' => 'Empleado actualizado exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function employeeList(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);
            
            $filters = $request->only([
                'first_name',
                'other_names',
                'paternal_name',
                'maternal_name',
                'id_type',
                'id_number',
                'employment_country',
                'email',
                'status',
            ]);
    
            $result = $this->employeeService->getAllEmployees($perPage, $page, $filters);
    
            return response()->json([
                'statusCode' => 200,
                'data' => $result->items(),
                'pagination' => [
                    'current_page' => $result->currentPage(),
                    'per_page' => $result->perPage(),
                    'total' => $result->total(),
                    'total_pages' => $result->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
