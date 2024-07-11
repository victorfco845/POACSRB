<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('region')->get()->map(function ($city) {
            return [
                'id' => $city->id,
                'city' => $city->city,
                'region' => $city->region->region,
            ];
        });
    
        return response()->json([
            'success' => true,
            'data' => $cities,
        ]);
    }
    

    public function show($id)
    {
        $city = City::with('region')->find($id);

        if (!$city) {
            return response()->json([
                'success' => false,
                'message' => 'City not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $city->id,
                'city' => $city->city,
                'region' => $city->region->region,
            ],
        ]);
    }
}
