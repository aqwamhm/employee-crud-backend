<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('position')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => EmployeeResource::collection($employees),
        ], 200);
    }

    public function sortedBySalary()
    {
        $employees = Employee::with('position')->orderBy('salary', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $employees
        ], 200);
    }

    public function create(EmployeeCreateRequest $request)
    {
        $employee = Employee::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new EmployeeResource($employee),
        ], 201);
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->update($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => $employee,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new EmployeeResource($employee),
        ], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully',
        ], 200);
    }
}

