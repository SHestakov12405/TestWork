<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionSaveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return redirect()->route('edits.index');
    }
}
