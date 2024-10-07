<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Services\API\MainService;
use App\Http\ServerResponse\ServerResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

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

    /**
     * @param StoreCityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCityRequest $request): JsonResponse
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

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface\
     */
    public function destroy(int $id): JsonResponse
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
