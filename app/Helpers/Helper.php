<?php


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


function authUser()
{
    return auth()->user();
}


function authUserID()
{
    return auth()->user() ? auth()->user()->id : null;
}
function isAdmin()
{
    return auth()->check() && auth()->user()->role == 'admin';
}


function uploadImage(UploadedFile $file, string $path = 'images', string $slug = 'auctions'): string
{
    $slug = Str::slug($slug);
    $currentDate = Carbon::now()->toDateString();
    $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    if (!file_exists($path)) {
        mkdir($path);
    }
    $file->move($path, $imageName);
    return $imageName;
}
