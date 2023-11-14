<?php

namespace App\Http\Controllers;

use App\Models\SmartflowForm;
use App\Models\SmartflowFormAgreement;
use App\Models\SmartflowFormView;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class FormController extends Controller
{
    //
    public function myforms($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/form/byUser/' . $personId . '/withAction/CREATED?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $myforms = $response['data']['content'];
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

        return view('forms.myforms', compact('myforms', 'numbers', 'access', 'current', 'totalPages', 'numberOfElements'));
    }

    public function create()
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/list/byEnterprise/' . $enterpriseId)->json();
            $viewers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        $viewersJson = json_encode($viewers);
        return view('forms.create', compact('viewers'));
        // return response()->json(['viewers' => $viewers]);

    }

    public function ignacio()
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/list/byEnterprise/' . $enterpriseId)->json();
            //dd($response);
            $viewers = $response['data'];

            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return response()->json(['viewers' => $viewers]);

    }

    public function handlecreate(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $create = $request->all();
        //dd($create);
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $content = $create['content'];
        $title = $create['title'];
        $agreeLevelNumber = $create['agreeLevelNumber'];
        $form = new SmartflowForm();
        $form['name'] = $title;
        $form['content'] = $content;
        $form['agreeLevelNumber'] = $agreeLevelNumber;

        $form_response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://' . $ip_adress . '/odsmartflow/manages-forms/create/form', $form);
        if ($form_response['message'] == "Access denied") {
            return view('errors.401');
        }elseif($form_response['message'] == "Authentication failed"){
            return view("auth.login");
        }

        $approval = $create['approvals'];
        $agreement = new SmartflowFormAgreement();
        $agreement['formId'] = $form_response['data']['formId'];
        foreach ($approval as $key => $values) {
            $agreement['level'] = $key;
            $agreement['levelName'] = "Niveau " . $key;
            foreach ($values as $value) {
                $agreement['personId'] = $value;
                $agreement_response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->post('http://' . $ip_adress . '/odsmartflow/manages-formsAgreements/add/formAgreement', $agreement);
                if ($agreement_response['message'] == "Access denied") {
                    return view('errors.401');
                }elseif($agreement_response['message'] == "Authentication failed"){
                    return view("auth.login");
                }
            }
        }

        $viewers = $create['viewers'];
        $viewer = new SmartflowFormView();
        $viewer['formId'] = $form_response['data']['formId'];
        foreach ($viewers as $value) {
            $viewer['personId'] = $value;
            $viewers_response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-formsView/add/formView', $viewer);
            if ($viewers_response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($viewers_response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        }

        return Redirect::to('/form/myforms/0');
    }

    public function delete(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $formId = $request['tempInput'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/delete/form/' . $formId);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/form/myforms/0');
    }

    public function edit($formId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        try{
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId . '/byUserAccess/' . $personId)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $form = $response['data'];
        } catch(Exception $e) {
            return new Response(500);
        }
        return view('forms.edit', compact('formId', 'form'));
    }

    public function update(Request $request){
        $ip_adress = env('APP_IP_ADRESS');
        $update = $request->all();
        $token = session('session.token');
        $form = new SmartflowForm();
        $form['formId'] = $update['formId'];
        $form['name'] = $update['title'];
        $form['content'] = $update['content'];
        $form['code'] = $update['code'];
        $form['status'] = $update['status'];
        $form['userIdForLog'] = $update['userIdForLog'];
        $form['agreeLevelNumber'] = $update['agreeLevelNumber'];
        $form['createdBy'] = $update['createdBy'];
        $form['createdAt'] = $update['createdAt'];
        $form['deletedFlag'] = $update['deletedFlag'];
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->put('http://' .$ip_adress . '/odsmartflow/manages-forms/update/form', $form);
            if($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
    }

    public function search(Request $request)
    {


        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $formName = $request->search;
        //dd($formName);
        if ($formName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }
        //dd($request->search);
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get("http://{$ip_adress}/odsmartflow/manages-forms/form/byName/{$formName}/access/byUserAccess/{$personId}")
                ->json();

            // dd($name);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $myforms = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/own/form/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $request = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/count/access/form/' . $personId)->json();
            $access = $request['data'];
            if ($request['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($request['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }


        return view('forms.myforms', compact('myforms', 'numbers', 'access', 'current', 'totalPages', 'numberOfElements'));
    }

}
