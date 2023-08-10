<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User};
use Illuminate\Support\Facades\{Cache, DB, Http, Storage };
use Illuminate\Http\{Response};

class UserRepository extends BaseRepository
{

    /**
     * Construct UserRepository class
     */
    public function __construct()
    {
        parent::__construct(new User);
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
            ->get();
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    public function saveRepository(array $attributes): ?Model
    {
        return $this->save([
            "email" => $attributes["email"]
        ],$attributes);
    }

    /**
     * Realiza la inserccion de la informacion del Usuario
     *
     * @param array $attributes
     * @return Model|null
     */
    public function relationshipInfoRepository(array $attributes): ?Model
    {
        return auth()->user()->info()->updateOrCreate([
            "user_id" => auth()->user()->id
        ],$attributes);

    }

    /**
     * Realiza la inserccion de la evaluacion del Usuario
     *
     * @param array $attributes
     * @return Model|null
     */
    public function relationshipAssessmentRepository(array $attributes): ?Model
    {
        return auth()->user()->assessment()->updateOrCreate([
            "user_id" => auth()->user()->id
        ],$attributes);

    }

    /**
     * Realiza la inserccion de los comprobantes del Usuario
     *
     * @param array $attributes
     * @return Model|null
     */
    public function relationshipVouchersRepository(array $attributes): ?Model
    {
        $response = auth()->user()?->voucher;
        if($response?->path_address)
            Storage::disk("public")->delete($response?->path_address);
        if($response?->path_income)
            Storage::disk("public")->delete($response?->path_income);

        return auth()->user()->voucher()->updateOrCreate([
            "user_id" => auth()->user()->id
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
     * Realiza la peticion para obtener el token y establecer la conexion
     *
     * @throws \Exception
     */
    public function getWsToken(): string
    {
        /*if (Cache::has("ut_token"))
            return Cache::get("ut_token");*/

        $wsdlUser   = \request()->user?->email?? "jorge.martinez.developer@gmail.com";
        $wsdlApiKey = "Jorge.20232$";

        $formParams   = [
            "email"     => $wsdlUser,
            "password"  => $wsdlApiKey,
        ];
        $ws = Http::asForm()->post("https://sitiowebdesarrollo.centralus.cloudapp.azure.com/api/login", $formParams);
        $response = $ws->collect()->toArray();
        if (!$response["success"])
            throw new \Exception($response["error"],Response::HTTP_UNPROCESSABLE_ENTITY);

        #Cache::put("ut_token",$response["token"],\now()->addHours(2));

        return $response["token"];
    }

     /**
     * Realiza la conexion para evaluar al usuario mediante el RFC del Usuario
     *
     * @throws \Exception
     */
    public function getWsAssessment(string $rfc, string $token): string
    {

        $formParams   = [
            "rfc"     => $rfc,
        ];
        $ws = Http::withToken($token)->asForm()->post(
            "https://sitiowebdesarrollo.centralus.cloudapp.azure.com/api/evaluacion",
            $formParams
        );
        $response = $ws->collect()->toArray();

        if (!$response["success"])
            throw new \Exception($response["message"],Response::HTTP_UNPROCESSABLE_ENTITY);

        return $response["respuesta_evaluacion"];
    }

    /**
     * Realiza la conexion para evaluar al usuario mediante el RFC del Usuario
     *
     * @return  array
     * @throws \Exception
     */
    public function getWsOffers(string $rfc, string $token): array
    {

        $formParams   = [
            "rfc"     => $rfc,
        ];
        $ws = Http::withToken($token)->asForm()->post(
            "https://sitiowebdesarrollo.centralus.cloudapp.azure.com/api/ofertas",
            $formParams
        );
        $response = $ws->collect()->toArray();

        if (!$response["success"])
            throw new \Exception($response["message"],Response::HTTP_UNPROCESSABLE_ENTITY);

        return $response["datos_oferta"];
    }


}
