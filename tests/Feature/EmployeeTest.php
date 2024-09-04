<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $admin;
    private $superadmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_superadmin' => false]); 
        $this->superadmin = User::factory()->create(['is_superadmin' => true]); 
    }

    private function actingAsAdmin()
    {
        return $this->actingAs($this->admin, 'api');
    }

    private function actingAsSuperadmin()
    {
        return $this->actingAs($this->superadmin, 'api');
    }

    public function test_sorted_by_salary_for_superadmin()
    {
        $position = Position::factory()->create();

        Employee::factory()->create(['position_id' => $position->id, 'salary' => 50000]);
        Employee::factory()->create(['position_id' => $position->id, 'salary' => 60000]);
        Employee::factory()->create(['position_id' => $position->id, 'salary' => 40000]);

        $response = $this->actingAs($this->superadmin, 'api')->getJson('/api/employees/sortedBySalary');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'position' => [
                        'id',
                        'name',
                    ],
                    'salary',
                ],
            ],
        ]);

        $responseData = $response->json('data');
        $salaries = array_column($responseData, 'salary');

        $this->assertEquals([60000, 50000, 40000], $salaries);
    }

    public function test_sorted_by_salary_for_non_superadmin()
    {
        $response = $this->actingAs($this->admin, 'api')->getJson('/api/employees/sortedBySalary');

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'fail',
            'message' => 'Unauthorized access',
        ]);
    }

    public function test_index_employees_for_admin()
    {
        $position = Position::factory()->create();
        Employee::factory()->create(['position_id' => $position->id]);

        $response = $this->actingAsAdmin()->getJson('/api/employees');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'position' => [
                        'id',
                        'name',
                    ],
                    'salary',
                ],
            ],
        ]);
    }

    public function test_create_employee_for_admin_with_valid_payload()
    {
        $position = Position::factory()->create();
        $employeeData = Employee::factory()->make(['position_id' => $position->id])->toArray();

        $response = $this->actingAsAdmin()->postJson('/api/employees', $employeeData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'email',
                'position' => [
                    'id',
                    'name',
                ],
                'salary',
            ],
        ]);
    }

    public function test_create_employee_for_admin_with_invalid_payload()
    {
        $position = Position::factory()->create();
        $invalidEmployeeData = [
            'position_id' => $position->id,
            'salary' => 50000,
        ];

        $response = $this->actingAsAdmin()->postJson('/api/employees', $invalidEmployeeData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email']);
    }

    public function test_update_employee_for_admin_with_valid_id_and_payload()
    {
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();
        $employee = Employee::factory()->create(['position_id' => $position1->id]);
        $updatedData = ['name' => 'Updated Name', 'email' => 'update@example.com', 'position_id' => $position2->id, 'salary' => 70000];

        $response = $this->actingAsAdmin()->putJson("/api/employees/{$employee->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $employee->id,
                'name' => 'Updated Name',
                'email' => 'update@example.com',
                'salary' => 70000,
            ],
        ]);
    }

    public function test_update_employee_for_admin_with_invalid_id()
    {
        $position = Position::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'update@example.com',
            'position_id' => $position->id,
            'salary' => 70000,
        ];

        $response = $this->actingAsAdmin()->putJson("/api/employees/99999", $updatedData);

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'fail',
            'message' => 'Employee not found',
        ]);
    }

    public function test_destroy_employee_for_admin()
    {
        $position = Position::factory()->create();
        $employee = Employee::factory()->create(['position_id' => $position->id]);

        $response = $this->actingAsAdmin()->deleteJson("/api/employees/{$employee->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Employee deleted successfully',
        ]);

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

}