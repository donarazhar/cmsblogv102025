<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Program::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        $programs = $query->get();

        // Clear appends to prevent RouteNotFoundException
        $programs->transform(function($program) {
            $program->setAppends([]);
            return $program;
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Layanan Masjid',
            'data'    => $programs
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $program = Program::where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $program->setAppends([]);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Layanan Masjid',
            'data'    => $program
        ]);
    }
}
