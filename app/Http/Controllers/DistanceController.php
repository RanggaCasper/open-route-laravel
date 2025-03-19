<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\OpenRouteService;

class DistanceController extends Controller
{
    protected $openRouteService;

    public function __construct(OpenRouteService $openRouteService)
    {
        $this->openRouteService = $openRouteService;
    }

    public function index()
    {
        return view('distance.indexs');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location1' => 'required',
            'location2' => 'required',
        ]);

        try {
            $coordinates1 = $this->openRouteService->getGeocode($request->location1);
            if (isset($coordinates1['error'])) {
                return ResponseFormatter::error('Lokasi pertama tidak ditemukan.', $coordinates1);
            }

            $coordinates2 = $this->openRouteService->getGeocode($request->location2);
            if (isset($coordinates2['error'])) {
                return response()->json(['error' => 'Lokasi kedua tidak ditemukan.'], 400);
            }

            return ResponseFormatter::success(
                'Data retrived successfully.', [
                    'location1' => $coordinates1,
                    'location2' => $coordinates2,
                    'route' => $this->openRouteService->getRoute([$coordinates1['features'][0]['geometry']['coordinates'], $coordinates2['features'][0]['geometry']['coordinates']]),
                ]
            );
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
