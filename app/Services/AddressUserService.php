<?php namespace App\Services;

use App\Repositories\{AddressUserRepository};
use Illuminate\Support\Facades\{Cache, DB, Http};
use Illuminate\Support\{Collection, Str};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{Response};

class AddressUserService extends AddressUserRepository
{

     /**
     * Method for get types resources Customers
     *
     * @throws \Exception
     */
    public function getZipCode()
    {
        try {

            $token = (new UserService)->getWsToken();
            return $this->getWsZipCode($token);

        } catch ( \Throwable $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            \Log::error($error);

            throw new \Exception($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Model|null
     * @throws \Exception
     */
    public function store(): ?Model
    {
        DB::beginTransaction();
        try {
            $payload  = \request()->merge([
                "user_id" => \request()->user()->getKey(),
                "status"  => true
            ])->except("_token");
            $response = $this->saveRepository($payload);

            DB::commit();

            return $response;

        } catch (\Throwable $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();

            throw new \Exception($e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @return Model|null
     * @throws \Exception
     */
    public function update(string $id): ?Model
    {
        DB::beginTransaction();
        try {
            $payload = [];
             $response = $this->updateRepository(
                $payload,
                $id
            );

            DB::commit();

            return $response;

        } catch (\Throwable $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();

            throw new \Exception($e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

}
