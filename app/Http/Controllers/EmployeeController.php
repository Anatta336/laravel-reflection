<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Employee::class);

        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateEmployee  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployee $request)
    {
        $this->authorize('create', Employee::class);

        $validated = $request->validated();
        $employee = new Employee($validated);
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
     * @param  \App\Employee  $employee
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
     * @param  \App\Employee  $employee
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
     * @param  \App\Http\Requests\UpdateEmployee  $request
     * @param  \App\Employee  $employee
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
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        if (!$employee) {
            return back()->with('message', [
                'alert-type' => 'danger',
                'content' => "Failed to delete. Unable to find employee.",
            ]);
        }

        $name = "{$employee->first_name} {$employee->last_name}";
        $employee->delete();

        return redirect()
            ->route('employee.index')
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Deleted employee: $name",
        ]);
    }
}
