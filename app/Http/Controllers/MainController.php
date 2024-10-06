<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Services\MainService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\View\View;
use Illuminate\Support\Collection;

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
     * @param Request $request
     * @param $city
     * @return View
     */
    public function city(Request $request, $city): View
    {
        $indexViewResult = $this->mainService->city($request, $city);
        return view('index', ['cities' => $indexViewResult['cities'], 'selectedCity' => $indexViewResult['selectedCity']]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View|RedirectResponse
    {
        $result = $this->mainService->index($request);


        if(is_string($result))
           return redirect()->route('city', ['city' => $result])->setStatusCode(301);

        return view('index', ['cities' => $result]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function about(Request $request): View
    {
        return view('about');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function news(Request $request): View
    {
        return view('news');
    }
}
