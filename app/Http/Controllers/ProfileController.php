<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function createProfile(){

        $data = request()->validate([
            'vezeteknev' => 'required',
            'keresztnev' => 'required',
            'iranyitoszam' => 'required|min:4|max:4',
            'email' => 'required|email',
            'varos' => 'required',
            'address' => 'required',
            'emelet' => '',
            'telefonszam' => 'required|min:11|max:15',
        ]);
        auth()->user()->profile()->create([
            'vezeteknev' => $data['vezeteknev'],
            'keresztnev' => $data['keresztnev'],
            'iranyitoszam' => $data['iranyitoszam'],
            'email' => $data['email'],
            'varos' => $data['varos'],
            'address' => $data['address'],
            'emelet' => $data['emelet'],
            'telefonszam' => $data['telefonszam'],
        ]);
    }

    public function updateProfile(){

        $data = request()->validate([
            'vezeteknev' => 'required',
            'keresztnev' => 'required',
            'iranyitoszam' => 'required|min:4|max:4',
            'email' => 'required|email',
            'varos' => 'required',
            'address' => 'required',
            'emelet' => '',
            'telefonszam' => 'required|min:11|max:15',
        ]);

        auth()->user()->profile()->update(
            $data
        );
    }
}
