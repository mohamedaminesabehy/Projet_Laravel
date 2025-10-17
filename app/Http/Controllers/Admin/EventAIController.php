<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EventCopyAI;

class EventAIController extends Controller
{
    public function generate(Request $request, EventCopyAI $ai)
    {
        // stays inside your admin middlewares via routes group
        $data = $request->validate([
            'keywords'   => 'array|min:0|max:6',
            'keywords.*' => 'string|max:60',
            'audience'   => 'nullable|string',
            'tone'       => 'nullable|string',
            'lang'       => 'nullable|in:en,fr',
            'length'     => 'nullable|in:short,medium,long',
            'start_date' => 'nullable|string', // we only format, no DB write here
            'end_date'   => 'nullable|string',
            'location'   => 'nullable|string|max:255',
        ]);

        $out = $ai->generate($data);
        return response()->json($out);
    }
}
