<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
//        if (!auth('patient')->check() && $request->segment(1) == 'patient') {
//            return route('patient.login');
//        }
//        if (!auth('doctor')->check() && $request->segment(1) == 'doctor') {
//            return route('doctor.login');
//        }
//        if (!auth('admin')->check() && $request->segment(1) == 'admin') {
//            return route('admin.login');
//        }

//        return $request->expectsJson() ? null : route('account_type');
    }
}
