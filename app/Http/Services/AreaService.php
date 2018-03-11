<?php

namespace App\Http\Services;

use App\Http\Models\City;

class AreaService extends BaseService
{
    public static function getProvinceMapping()
    {
        $provinces = [];
        $province_list = City::where('city_id', 0)
            ->orderBy('id', 'asc')
            ->get();
        if ($province_list->isNotEmpty()) {
            foreach ($province_list as $item) {
                $provinces[$item['id']] = $item['province'];
            }
        }

        return $provinces;
    }

    public static function getProvinceCityTree($province_id, $use_cache = true)
    {
        $municipality_id_arr = [110000, 120000, 310000, 500000];

        $city_list = City::where('province_id', $province_id)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        $city_tree = [
            'city' => [],
            'district' => []
        ];

        if ($city_list) {
            foreach ($city_list as $city_item) {
                if (in_array($province_id, $municipality_id_arr)) {
                    if ($city_item['city_id'] == 0) {
                        $city_tree['city'][] = [
                            'id' => $city_item['id'],
                            'name' => $city_item['name']
                        ];
                    } else {
                        $city_tree['district'][$province_id][] = [
                            'id' => $city_item['id'],
                            'name' => $city_item['name']
                        ];
                    }
                } else {
                    if ($city_item['city_id'] == 0) {
                        continue;
                    }
                    if ($city_item['area_id'] == 0) {
                        $city_tree['city'][] = [
                            'id' => $city_item['id'],
                            'name' => $city_item['name']
                        ];
                    } else {
                        $tmp_prefix_key = $city_item['city_id'];
                        if(!isset($city_tree['district'][$tmp_prefix_key])){
                            $city_tree['district'][$tmp_prefix_key] = [];
                        }
                        $city_tree['district'][$tmp_prefix_key][] = [
                            'id' => $city_item['id'],
                            'name' => $city_item['name']
                        ];
                    }
                }
            }
        }

        return $city_tree;
    }
}