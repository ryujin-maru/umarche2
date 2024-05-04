<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTestController extends Controller
{
    public function showServiceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');
        dd($sample,$password,$encrypt->decrypt($password));
    }

    public function showComponent1()
    {
        return view('tests.test1');
    }

    public function showComponent2()
    {
        return view('tests.test2');
    }
}
