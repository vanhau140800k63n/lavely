<?php

namespace App\Utils;

class PaymentUtils
{
    public static function getTreeData()
    {
        return json_decode(file_get_contents(public_path('source/json/tree.json')), true);
    }

    public static function getDistrictData($provinceId)
    {
        $data = json_decode(file_get_contents(public_path('source/json/district.json')), true);
        return array_filter($data, function ($item) use ($provinceId) {
            return isset($item['parent_code']) && $item['parent_code'] == $provinceId;
        });
    }

    public static function getProvinceData()
    {
        return json_decode(file_get_contents(public_path('source/json/province.json')), true);
    }

    public static function getCommuneData($districtId)
    {
        $data = json_decode(file_get_contents(public_path('source/json/commune.json')), true);
        return array_filter($data, function ($item) use ($districtId) {
            return isset($item['parent_code']) && $item['parent_code'] == $districtId;
        });
    }

    public static function getAllCommuneData()
    {
        return json_decode(file_get_contents(public_path('source/json/commune.json')), true);
    }

    public static function getProvinceNameByCode($code)
    {
        $data = json_decode(file_get_contents(public_path('source/json/province.json')), true);
        if (isset($data[$code])) {
            return $data[$code]['name'];
        }

        return '';
    }

    public static function getDistrictNameByCode($code)
    {
        $data = json_decode(file_get_contents(public_path('source/json/district.json')), true);
        if (isset($data[$code])) {
            return $data[$code]['name'];
        }

        return '';
    }

    public static function getCommuneNameByCode($code)
    {
        $data = json_decode(file_get_contents(public_path('source/json/commune.json')), true);
        if (isset($data[$code])) {
            return $data[$code]['name'];
        }

        return '';
    }
}
