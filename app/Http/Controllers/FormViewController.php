<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FormViewController extends Controller
{
    //
    public function models($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/form/access/byUserAccess/' . $personId . '?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $models = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/own/form/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $request = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/access/form/' . $personId)->json();
            $access = $request['data'];
            if ($request['message'] == "Access denied") {
                return view('errors.401');
            }elseif($request['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return view('forms.models', compact('models', 'numbers', 'access', 'current', 'totalPages', 'numberOfElements'));
    }

    public function search (Request $request){


        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $formName = $request->search;


        if ($formName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }
        //dd($request->search);
    try{
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get("http://{$ip_adress}/odsmartflow/manages-forms/form/byName/{$formName}/access/byUserAccess/{$personId}")
        ->json();


        // dd($name);
        if ($response['message'] == "Access denied") {
            return view('errors.401');
        }elseif($response['message'] == "Authentication failed"){
            return view("auth.login");
        }
        $models = $response['data']['content'];
        $current = $response['data']['number'];
        $totalPages = $response['data']['totalPages'];
        $numberOfElements = $response['data']['numberOfElements'];
        $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/own/form/' . $personId)->json();


        //dd($data);
        $numbers = $data['data'];
        if ($data['message'] == "Access denied") {
            return view('errors.401');
        }elseif($data['message'] == "Authentication failed"){
            return view("auth.login");
        }
        $request = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/access/form/' . $personId)->json();
        $access = $request['data'];
        if ($request['message'] == "Access denied") {
            return view('errors.401');
        }elseif($request['message'] == "Authentication failed"){
            return view("auth.login");
        }
    } catch (Exception $e) {
        return new Response(500);
    }


    return view('forms.models', compact('models', 'numbers', 'access', 'current', 'totalPages', 'numberOfElements'));
}
}
