<?php

namespace App\Console\Commands;

use App\Http\Services\RussianToEnglishTransliterator;
use App\Models\City;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ParseCitiesRu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-cities-ru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';



    protected $transliterator;

    // Constructor
    public function __construct()
    {
        parent::__construct();
        $this->transliterator = app(RussianToEnglishTransliterator::class);
    }

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://api.hh.ru/areas');
            $data = json_decode($response->getBody(), true);

            foreach ($data as $country) {
                if ($country['name'] == 'Россия') {
                    $cities = $this->getCitiesFromCountries($country['areas']);

//                    dd($cities);
                    City::insert($cities);
                    $this->info('Cities loaded successfully!');
                }
            }

        } catch (\Exception $e) {
            $this->error('Error loading cities: ' . $e->getMessage());
        }
    }

    private function getCitiesFromCountries(array $countries)
    {
        $cities = [];

        foreach ($countries as $region) {
            if (isset($region['areas']) && count($region['areas']) > 0) {
                $cities = array_merge($cities, $this->getCitiesFromRegions($region['areas']));
            } else {
                $cities = array_merge($cities, $this->getCitiesFromAreas($region));
            }
        }

        return $cities;
    }

    private function getCitiesFromRegions(array $regions)
    {
        $cities = [];

        foreach ($regions as $region) {
            $cities = array_merge($cities, $this->getCitiesFromAreas($region));
        }

        return $cities;
    }

    private function getCitiesFromAreas(array $area)
    {
        $cities = [];

        if (isset($area['name']) && isset($area['id'])) {
            $cities[] = [
                'name' => $area['name'],
                'hh_id' => $area['id'],
                'slug' => $this->transliterator->transliterate($area['name']),
            ];
        }

        return $cities;
    }

    function transliterate($text)
    {
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        return strtr($text, $translit);
    }
}
