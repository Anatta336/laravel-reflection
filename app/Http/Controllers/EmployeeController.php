<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $validated = $request->validated();
        $employee = new Employee($validated);
        $employee->save();

        return redirect()
            ->route('employee.show', ['employee' => $employee])
            ->with('message', [
                'alert-type' => 'success',
                'content' => 'Employee created.',
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
        $validated = $request->validated();
        $employee->update($validated);

        return redirect()
            ->route('employee.show', ['employee' => $employee])
            ->with('message', [
                'alert-type' => 'success',
                'content' => 'Employee updated.',
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
