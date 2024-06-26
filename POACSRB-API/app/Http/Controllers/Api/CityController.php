<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('region')->get();

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
                'city' => $city->city,
                'region' => $city->region->region,
                'created_at' => $city->created_at,
                'updated_at' => $city->updated_at,
            ],
        ]);
    }
}
