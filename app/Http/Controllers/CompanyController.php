<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateCompany;
use App\Http\Requests\UpdateCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(10);
        return view('company.list', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateCompany  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompany $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo-file')) {
            $file = $request->file('logo-file');
            $validated['logo'] = $file->storePublicly('logos', 'public');
        }

        unset($validated['logo-file']);
        $company = new Company($validated);
        $company->save();

        return view('company.show', ['company' => $company])
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Created new company: {$company->name}", 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('company.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('company.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompany  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompany $request, Company $company)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo-file')) {
            $file = $request->file('logo-file');
            $validated['logo'] = $file->storePublicly('logos', 'public');
        }

        unset($validated['logo-file']);
        $company->update($validated);

        return view('company.show', ['company' => $company])->with('message', [
            'alert-type' => 'success',
            'content' => "Updated company: {$company->name}", 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if (!$company) {
            return back()->with('message', [
                'alert-type' => 'danger',
                'content' => "Failed to delete. Unable to find company.",
            ]);
        }

        $name = $company->name;
        $company->delete();

        return redirect()
            ->route('company.index')
            ->with('message', [
                'alert-type' => 'success',
                'content' => "Deleted company: $name",
        ]);
    }
}
