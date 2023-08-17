<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEntitlements
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $validated = $request->validate([
            'id' => ['integer'],
        ]);
        // dd(array_search($validated['id'], array_column(Auth::user()->receivingEntitlements()->get(['id'])->toArray(), 'id')));

        if (!empty($validated)) {

            if (array_search($validated['id'], array_column(Auth::user()->receivingEntitlements()->get(['id'])->toArray(), 'id')) === false) {
                return redirect()->route('users.index');
            }else {
                session(['userEntitlementsId' => $validated['id']]);
            }

        }elseif($request->session()->has('userEntitlementsId')) {
            if (array_search(session('userEntitlementsId'), array_column(Auth::user()->receivingEntitlements()->get(['id'])->toArray(), 'id')) === false) {
                return redirect()->route('users.index');
            }
        }else {
            return redirect()->route('users.index');
        }

        return $next($request);
    }
}
