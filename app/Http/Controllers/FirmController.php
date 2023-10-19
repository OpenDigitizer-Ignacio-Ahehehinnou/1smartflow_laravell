<?php

namespace App\Http\Controllers;

use App\Models\SmartflowFirm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class FirmController extends Controller
{
    //

    public function index($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-enterprises/find/enterprise/byEnterprise/' . $enterpriseId . '?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $firms = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('firms.index', compact('firms', 'current', 'totalPages', 'numberOfElements'));
    }

    public function edit($firmId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-enterprises/find/enterprise/' . $firmId)->json();
            $firm = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return view('firms.edit', compact('firm'));
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $firm = array();
        $firm['enterpriseId'] = $request['enterpriseId'];
        $firm['name'] = $request['name'];
        $firm['manager'] = $request['manager'];
        $firm['ifu'] = $request['ifu'];
        $firm['email'] = $request['email'];
        $firm['address'] = $request['address'];
        $firm['telephone'] = $request['telephone'];
        $firm['deletedFlag'] = $request['deletedFlag'];
        $firm['createdBy'] = $request['createdBy'];
        $firm['createdAt'] = $request['createdAt'];
        $firm['updatedAt'] = $request['updatedAt'];
        $firm['softDeleteAt'] = $request['softDeleteAt'];
        $firm['updatedBy'] = $request['updatedBy'];
        $firm['softDeletedBy'] = $request['softDeletedBy'];
        $firm['enterpriseParentCompanyId'] = $request['enterpriseParentCompanyId'];
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put('http://' . $ip_adress . '/odsmartflow/manages-enterprises/update/enterprise', $firm);
                if ($response['message'] == "Access denied") {
                    return view('errors.401');
                }elseif($response['message'] == "Authentication failed"){
                    return view("auth.login");
                }
        } catch (Exception $e) {
            return new Response(500);
        }

        return Redirect::to('firm/index/0');
    }

    public function delete($firmId)
    {

    }

    public function store(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $data = $request->all();
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $firm = new SmartflowFirm();
        $confirm = $request['confirm_password'];
        $firm['enterpriseName'] = $request['enterprise_name'];
        $firm['enterpriseAdress'] = $request['enterprise_adress'];
        $firm['enterpriseEmail'] = $request['enterprise_email'];
        $firm['enterpriseIfu'] = $request['enterprise_ifu'];
        $firm['enterprisePhone'] = $request['enterprise_phone'];
        $firm['personFirstname'] = $request['person_firstname'];
        $firm['personLastname'] = $request['person_lastname'];
        $firm['personPassword'] = $request['person_password'];
        $firm['personUsername'] = $request['person_username'];
        $firm['personPhone'] = $request['person_phone'];
        $firm['personSignature'] = $request['person_signature'];
        $firm['personFunction'] = $request['person_function'];
        $firm['enterpriseParentCompanyId'] = $enterpriseId;
        if ($confirm != $request['confirm_password']) {
            return redirect()->back()->withInput($data)->with('error', "Les mots de passe ne correspondent pas");
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->post('http://' . $ip_adress . '/odsmartflow/manages-enterprises/create/filiale', $firm);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }elseif($response['code'] == 409){
                return redirect()->back()->withInput($data)->with('error', "L'email que vous essayer d'utiliser existe déjà.'");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return Redirect::to('/firm/index/0');
    }

    public function create()
    {
        return view('firms.create');
    }
}
