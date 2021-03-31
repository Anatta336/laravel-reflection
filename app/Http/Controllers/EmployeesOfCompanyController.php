<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;

/**
 * Controller for employees of a company.
 *
 * @package Employee
 */
class EmployeesOfCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Company $company The company to list employees for.
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
