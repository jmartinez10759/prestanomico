<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreInfoUserRequest, StoreAssessmentRequest, StoreVoucherRequest };
use App\Services\{UserService};
use Illuminate\Support\Facades\{Session};

class InfoUserController extends Controller
{
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
     * Show the form for creating a new resource.
     */
    public function viewVoucher()
    {
        return view("voucher");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewAssessment()
    {
        return view("assessment");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     */
    public function store(StoreInfoUserRequest $request): array
    {
        $response = (new UserService)->relationshipInfoRepository(
            \request()->merge(["status" => true])->except("_token")
        );

        return (new UserService())->getScoreValidated($response);

    }

    /**
     * Agrega la informacion en la tabla de assesment por usuario
     *
     */
    public function storeAssessment(StoreAssessmentRequest $request)
    {
        $response = (new UserService)->relationshipAssessmentRepository(\request()->except("_token"));

        return view("voucher");

    }

    /**
     * Agrega la informacion en la tabla de assesment por usuario
     *
     */
    public function storeVoucher(StoreVoucherRequest $request)
    {
        $file = "vouchers";
        $pathIncome  = \request()->file("voucher_income")->store($file,"public");
        $pathAddress = \request()->file("voucher_address")->store($file,"public");
        $data = [
            "path_income"  => $pathIncome,
            "path_address" => $pathAddress,
        ];
        (new UserService)->relationshipVouchersRepository($data);
        Session::flash('status', "Se cargaron con exito los comprobantes");
        return view("voucher");

    }


}
