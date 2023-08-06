<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInfoUserRequest;
use App\Http\Requests\UpdateInfoUserRequest;
use App\Models\InfoUser;

class InfoUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewExpenses()
    {
        return view("expenses",[
           "rfc"                => \old("rfc"),
           "birthdate"          => \old("birthdate") ,
           "monthly_salary"     => \old("monthly_salary") ,
           "monthly_expenses"   => \old("monthly_expenses")     ,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInfoUserRequest $request)
    {
        \request()->dd();
    }

    /**
     * Display the specified resource.
     */
    public function show(InfoUser $infoUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfoUser $infoUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInfoUserRequest $request, InfoUser $infoUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfoUser $infoUser)
    {
        //
    }
}
