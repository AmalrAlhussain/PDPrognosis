<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Company;
use App\Models\JobSeeker;
use App\Rules\PasswordValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ForgetPasswordController extends Controller
{
    public function forget(Request $request)
    {
        $user = $request->type;
        return view('reset_password.forget', compact('user'));
    }

    public function resetForm()
    {
        return view('reset_password.reset');
    }

    public function reset(Request $request)
    {
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($request->type == 'admin') {
            $user = Admin::where($loginType, $request->username)->first();
            if (!$user) {
                return back()->with('error', 'email or username not correct');
            }
            $code = $this->generateUniqueCode($user);
            if (!$user->password_reset_code) {
                $user->update(['password_reset_code' => $code]);
                session()->flash('success', 'code send successful');
            }

            return view('reset_password.reset', compact('user'));
        }
        if ($request->type == 'company') {
            $user = Company::where($loginType, $request->username)->first();
            if (!$user) {
                return back()->with('error', 'email or username not correct');
            }
            $code = $this->generateUniqueCode($user);
            if (!$user->password_reset_code) {
                $user->update(['password_reset_code' => $code]);
                session()->flash('success', 'code send successful');
            }

            return view('reset_password.reset', compact('user'));
        }
        if ($request->type == 'student') {
            $user = JobSeeker::where($loginType, $request->username)->first();
            if (!$user) {
                return back()->with('error', 'email or username not correct');
            }
            $code = $this->generateUniqueCode($user);
            if (!$user->password_reset_code) {
                $user->update(['password_reset_code' => $code]);
                session()->flash('success', 'code send successful');
            }

            return view('reset_password.reset', compact('user'));
        }
        return back()->with('error', 'something went wrong, please try again');
    }

    public function confirmResetPassword(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required',
            'password' => ['required', 'confirmed', new PasswordValidation()],
        ]);

        if ($request->type == 'admin') {
            $user = Admin::where('email', $request->email)->where('password_reset_code', $request->code)->first();
            if (!$user) {
                return back()->with('error', 'code not correct');
            }
            $user->update([
               'password' => Hash::make($request->password),
               'password_reset_code' => null,
            ]);
            session()->flash('success', 'password updated successfully');
            return redirect()->route('admin.login');
        }
        if ($request->type == 'company') {
            $user = Company::where('email', $request->email)->where('password_reset_code', $request->code)->first();
            if (!$user) {
                return back()->with('error', 'code not correct');
            }
            $user->update([
                'password' => Hash::make($request->password),
                'password_reset_code' => null,
            ]);
            session()->flash('success', 'password updated successfully');
            return redirect()->route('company.login');
        }
        if ($request->type == 'student') {
            $user = JobSeeker::where('email', $request->email)->where('password_reset_code', $request->code)->first();
            if (!$user) {
                return back()->with('error', 'code not correct');
            }
            $user->update([
                'password' => Hash::make($request->password),
                'password_reset_code' => null,
            ]);
            session()->flash('success', 'password updated successfully');
            return redirect()->route('student.login');
        }
        return back()->with('error', 'something went wrong, please try again');
    }

    public function generateUniqueCode(Model $model): int
    {
        do {
            $code = mt_rand(1000, 9999);
        } while ($model::where('password_reset_code', $code)->exists());
        return $code;
    }
}
