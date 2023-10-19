<?php

namespace App\Http\Controllers;

use App\Models\SmartflowFunction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class FunctionController extends Controller
{
    //

    public function index($page)
    {
        $token = session('session.token');
        $ip_adress = env('APP_IP_ADRESS');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-functions/list/paginate/byEnterprise/' . $enterpriseId . '?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $functions = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('functions.index', compact('functions', 'current', 'totalPages', 'numberOfElements'));
    }

    public function list()
    {
        $token = session('session.token');
        $ip_adress = env('APP_IP_ADRESS');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-functions/list/paginate/byEnterprise/' . $enterpriseId)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $functions = $response['data']['content'];
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('functions.index', compact('functions', 'current', 'totalPages'));
    }

    public function create(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $function = new SmartflowFunction();
        $function['libelle'] = $request['libelle'];
        $function['enterpriseId'] = session('session.userDto.smartflowEnterprise.enterpriseId');
        $token = session('session.token');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-functions/create/function', $function);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return back()->with("success", "Fonction crée avec succès")->with(compact('response'));
    }

    public function delete(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $functionId = $request['functionId'];
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-functions/delete/function/' . $functionId);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return back()->with("success", "Fonction supprimée avec succès");
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $donnees = $request->all();
        $request->validate([
            "libelle" => "required",
        ]);

        $test = array();
        $test['enterpriseId'] = $request['enterpriseId'];
        $test['libelle'] = $request['libelle'];
        $test['functionId'] = $request['functionId'];
        $test['userIdForLog'] = $request['userIdForLog'];

        $test['deletedFlag'] = $request['deletedFlag'];
        $test['createdBy'] = $request['createdBy'];
        $test['createdAt'] = $request['createdAt'];
        $test['updatedAt'] = $request['updatedAt'];
        $test['softDeleteAt'] = $request['softDeleteAt'];
        $test['updatedBy'] = $request['updatedBy'];
        $test['softDeletedBy'] = $request['softDeletedBy'];

        try {
            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
            // $enterprise = Http::withHeaders(['Authorization' => 'Bearer ' . $token,])->put('http://192.168.1.8:8081/odsmartflow/manages-enterprises/find/enterprise/' .$enterpriseId)->json();
            // Effectuez la requête HTTP avec la méthode PUT et incluez les données mises à jour
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put('http://' . $ip_adress . '/odsmartflow/manages-functions/update/function', $test);
                if ($response['message'] == "Access denied") {
                    return view('errors.401');
                }elseif($response['message'] == "Authentication failed"){
                    return view("auth.login");
                }
            $entreprises = $response->json();
            $statusCode = $response->status();

            return new Response(200);
        } catch (Exception $e) {
            return new Response(500);
        }

        return Redirect::to('/function/index/0');

    }

}
