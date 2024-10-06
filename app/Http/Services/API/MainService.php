<?php

namespace App\Http\Services\API;

use App\Models\City;


class MainService
{
    /**
     * @param array $data
     * @return City
     */
    public function store(array $data): City
    {
        $city = City::create($data);
        return $city;
    }

    /**
     * @param int $id
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function destroy(int $id): array
    {
        $city = City::find($id);
        $city->delete();

        $result = [
            'deleted' => true,
            'selected_city_removed' => false,
        ];

        if(session()->get('selected_city') == $city['slug']){
            session()->forget(['selected_city', 'selected_city_name']);
            $result['selected_city_removed'] = true;
        }

        return $result;
    }
}
