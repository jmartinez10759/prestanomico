<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressUserRequest;
use App\Http\Requests\UpdateAddressUserRequest;
use App\Models\AddressUser;
use App\Services\{AddressUserService};

class AddressUserController extends Controller
{

    /**
     * @property AddressUserService $_addressUserService;
     */
    private AddressUserService $_addressUserService;

    /**
     * AddressUserController Constructor
     *
     * @param AddressUserService $businessService
     */
    public function __construct(AddressUserService $addressUserService)
    {
        $this->_addressUserService = $addressUserService;
    }
    /**
     * Display a listing of the resource.
     */
    public function zipcode()
    {
        return response()->json(
            $this->_addressUserService->getZipCode()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewAddress()
    {
        return view("home",[
           "address"    => \request()->user()?->address?->address,
           "no_int"     => \request()->user()?->address?->no_int ,
           "no_ext"     => \request()->user()?->address?->no_ext ,
           "cp"         => \request()->user()?->address?->cp     ,
           "state"      => \request()->user()?->address?->state  ,
           "city"       => \request()->user()?->address?->city   ,
           "colony"     => \request()->user()?->address?->colony,
           "status"     => \request()->user()?->address?->status,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressUserRequest $request)
    {
        $response = $this->_addressUserService->store();

        return view("expenses");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddressUser $addressUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressUserRequest $request, AddressUser $addressUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddressUser $addressUser)
    {
        //
    }
}
