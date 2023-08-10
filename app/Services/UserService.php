<?php namespace App\Services;

use App\Repositories\{UserRepository};
use Illuminate\Support\Facades\{Cache, DB};
use Illuminate\Support\{Collection, Str};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{Response};

class UserService extends UserRepository
{
    const SCORE_APPRPVED = 540;

    const MICRO_APPRPVED = 600;

    /**
     * Display a listing of the resource.
     *
     * @return array
     * @throws \Exception
     */
    public function getScoreValidated(Model $response): array
    {
        $token          = $this->getWsToken();
        $assessment     = $this->getWsAssessment($response?->rfc,$token);
        $assessmentArr  = str($assessment)->explode(" ");

        $score           = str($assessmentArr[1])->replace("SCORE","");
        $tagScore        = substr($score,0,2);
        $characterFirst  = substr($score,2,2);
        $codeScore       = substr($score,4,$characterFirst);
        $tag             = substr($score,(4 + $characterFirst),2);
        $characterSecond = substr($score,(2 + (4 + $characterFirst)) ,2);
        $scoreValue      = substr($score,(2 + 2 + (4 + $characterFirst) ) ,$characterSecond);
        $characterThree  = substr($score,(2 + 2 + (4 + $characterFirst) + $characterSecond) , 2);
        $tagSecond       = substr($score,(2 + 2 + 2 + (4 + $characterFirst) + $characterSecond ) , $characterThree);
        $codeReason      = substr($score,(2 + 2 + 2 + (4 + $characterFirst) + $characterSecond + $characterThree ) , 3);

        if($scoreValue < self::SCORE_APPRPVED )
            throw new \Exception("Su solicitud fue rechazada y no será posible continuar", Response::HTTP_UNPROCESSABLE_ENTITY);

        return $this->getWsOffers($response?->rfc,$token);
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
            $payload = [];
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
