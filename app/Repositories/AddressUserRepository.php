<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\{AddressUser};
use Illuminate\Support\Facades\{Cache, DB, Http};

class AddressUserRepository extends BaseRepository
{

    /**
     * Construct AddressUserRepository class
     */
    public function __construct()
    {
        parent::__construct(new AddressUser);
    }

    /**
     * @return mixed
     */
    public function getAllQuery(): mixed
    {
        return $this->getRepository()
            ->query()
            ->when(\request("key"), function ($query){
                return $query->where("key",\request("key"));
            })
            ->when(\request("status"), function ($query){
                return $query->where("status",\request()->boolean("status"));
            })
            ->latest()
            ->when(\request("page"), function ($query){
                return $query->paginate(\request("to"));
            },function ($query){
                return $query->get();
            });
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    protected function saveRepository(array $attributes): ?Model
    {
        return $this->save([
            "user_id" => $attributes["user_id"]
        ],$attributes);
    }

    /**
     * @param array $attributes
     * @param string $id
     * @return Model|null
     */
    protected function updateRepository(array $attributes,string $id): ?Model
    {
        return $this->save([
            "id" => $id
        ],$attributes);
    }

     /**
     * Realiza la consulta del Codigo postal al web Service de Prestanomina
     *
     * @param string $nit
     * @return mixed
     */
    public function getWsZipCode(string $token): mixed
    {
        $zipcode = \request("cp");
        $response = Http::withToken($token)->get("https://sitiowebdesarrollo.centralus.cloudapp.azure.com/api/codigo_postal/{$zipcode}");

        return $response->collect()->toArray();
    }

}
