<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Services\API\MainService;
use App\Http\ServerResponse\ServerResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MainController extends Controller
{
    private $mainService;

    /**
     * @param MainService $mainService
     */
    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function store(StoreCityRequest $request)
    {
        $result = ServerResponse::RESPONSE_200;

        try {
            $result['data'] = $city = $this->mainService->store($request->validationData());;
        } catch (ModelNotFoundException $e) {
            $result = ServerResponse::RESPONSE_404;
        } catch (\Exception $e) {
            $result = ServerResponse::RESPONSE_500;
        }
        return response()->json($result);
    }

    public function destroy(int $id)
    {
        $result = ServerResponse::RESPONSE_200;

        try {
            $result['data'] = $this->mainService->destroy($id);
        } catch (ModelNotFoundException $e) {
            $result = ServerResponse::RESPONSE_404;
        } catch (\Exception $e) {
            $result = ServerResponse::RESPONSE_500;
        }
        return response()->json($result);

    }
}
