<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Http\Request;

/**
 * Controller for the Employee model.
 *
 * @package Employee
 */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Employee::class);

        $employees = Employee::orderBy('last_name')->paginate(10);
        return view('employee.list', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Employee::class);

        if ($request->has('defaultCompany')) {
            return view('employee.create', ['defaultCompany' => $request->input('defaultCompany')]);
        }
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateEmployee $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployee $request)
    {
        $this->authorize('create', Employee::class);

        $employee = new Employee($request->validated());
        $employee->save();

        return redirect()
            ->route('employee.show', ['employee' => $employee])
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Added new employee: {$employee->first_name} {$employee->last_name}.",
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Employee $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        return view('employee.show', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Employee $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);

        return view('employee.edit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateEmployee $request
     * @param \App\Employee                     $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployee $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validated();
        $employee->update($validated);

        return redirect()
            ->route('employee.show', ['employee' => $employee])
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Updated employee: {$employee->first_name} {$employee->last_name}.",
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Employee            $employee
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, Request $request)
    {
        $this->authorize('delete', $employee);

        if (!$employee) {
            return back()->with('message', [
                'alert-type' => 'danger',
                'content' => "Failed to delete. Unable to find employee.",
            ]);
        }

        $company = $employee->company;

        $name = "{$employee->first_name} {$employee->last_name}";
        $employee->delete();

        if ($request->input('is-from-company-employees', '0') && $company) {
            return redirect()
                ->route('employeesOfCompany.index', ['company' => $company])
                ->with('message', [
                    'alert-type' => 'success',
                    'content' => "Deleted employee: $name",
                ]);
        }

        return redirect()
            ->route('employee.index')
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Deleted employee: $name",
            ]);
    }
}
