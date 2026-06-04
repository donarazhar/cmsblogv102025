<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    /**
     * Get all active sliders.
     */
    public function index(): JsonResponse
    {
        $sliders = Slider::active()
            ->ordered()
            ->get();
            
        $sliders->each(function ($slider) {
            $slider->setAppends([]); // Prevent serialization issues with local routes
        });

        return response()->json([
            'success' => true,
            'message' => 'Data slider berhasil diambil',
            'data'    => $sliders
        ]);
    }
}
