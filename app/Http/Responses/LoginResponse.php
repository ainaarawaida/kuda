<?php

namespace App\Http\Responses;
 
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Filament\Resources\OrderResource;
use Livewire\Features\SupportRedirects\Redirector;
 
class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {

        return redirect()->intended(Filament::getUrl());
        // dd(Auth::user()->roles->pluck('name'));
        // if(in_arrayAuth::user()->roles->pluck('name') == 'admin'){
        //     return redirect()->to(url('/admin'));
        // }else if(Auth::user()->roles->pluck('name') == 'coach'){
        //     return redirect()->to(url('/coach'));
        // }else{
        //     return redirect()->to(url('/rider'));
        // }
        // dd(Auth::user()->roles->pluck('name'),Filament::getUrl());
        // return redirect()->intended(Filament::getUrl());
        // Here, you can define which resource and which page you want to redirect to
        // return redirect()->to(OrderResource::getUrl('index'));
    }
}