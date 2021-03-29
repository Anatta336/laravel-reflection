<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;

class EmployeesOfCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $this->authorize('view', $company);
        $this->authorize('view', Employee::class);

        return view('employee.companyEmployees', [
            'company' => $company,
            'employees' => $company->employees()->orderBy('last_name')->paginate(10),
        ]);
    }
}
