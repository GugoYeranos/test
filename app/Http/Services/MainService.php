<?php

namespace App\Http\Services;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class MainService
{

    /**
     * @param Request $request
     * @param string $city
     * @return array
     */
    public function city(Request $request, string $city): array
    {
        $cities = $this->getCities();
        $selectedCity = $city;
        $selected_city_name = $this->getCity($city);

        $request->session()->put('selected_city', $selectedCity);
        $request->session()->put('selected_city_name', $selected_city_name->name);

        $result = [];
        $result['cities'] = $cities;
        $result['selectedCity'] = $selectedCity;

        return $result;
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $selectedCity = $request->session()->get('selected_city');

        if ($request->is('/') && $selectedCity) {
            return $selectedCity;
        }

        $cities = $this->getCities();
        return $cities;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getCities(): LengthAwarePaginator
    {
//        $cities = City::orderBy('name', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->paginate(200);
        return $cities;
    }

    /**
     * @param string $city
     * @return City
     */
    public function getCity(string $city): City
    {
        $selected_city = City::select('name')->where('slug', $city)->first();
        return $selected_city;
    }
}
