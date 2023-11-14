<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\SmartflowPerson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class PersonController extends Controller
{

    public function index($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $roleId = session('session.userDto.roleId');
        if ($token == null) {
            return Redirect::to('/auth/login');
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/list/paginate/byEnterprise/' . $enterpriseId . '?page=' . $page)->json();
            //dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $users = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('users.index', compact('users', 'current', 'totalPages', 'numberOfElements'));
    }

    public function create()
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        if ($token == null) {
            return Redirect::to('/auth/login');
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-roles/selectList/byEnterprise/' . $enterpriseId)->json();
            $roles = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-functions/list/byEnterprise/' . $enterpriseId)->json();
            $functions = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('users.create', compact('roles', 'functions'));
    }

    public function handlecreate(Request $request)
    {
        //dd($request);
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $person = new SmartflowPerson();
        $confirm = $request['confirm'];
        $data = $request->all();
        $person['firstName'] = $request['firstname'];
        $person['lastName'] = $request['lastname'];
        $person['password'] = $request['password'];
        $person['username'] = $request['email'];
        $person['telephone'] = $request['phone'];
        $person['enterpriseId'] = session('session.userDto.smartflowEnterprise.enterpriseId');
        $person['functionId'] = $request['functionId'];
        $person['roleId'] = $request['roleId'];
        if ($confirm != $request['password']) {
            return redirect()->back()->withInput($data)->with('error', "Les mots de passe ne correspondent pas");
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->post('http://' . $ip_adress . '/odsmartflow/manages-persons/create', $person);
           // dd($response['code']);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }elseif($response['code'] == 500){
                return redirect()->back()->withInput($data)->with('error', "L'email que vous essayer d'utiliser existe déjà.'");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/user/index/0');
        //return back()->with("success", "Utilisateur crée avec succès")->with(compact('response'));
    }

    public function search (Request $request){


        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        //dd($token);
        $personId = session('session.userDto.personId');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $roleId = session('session.userDto.roleId');
        if ($token == null) {
            return Redirect::to('/auth/login');
        }


        $username = $request->search;
        //dd($username);
        if ($username === null) {
            return back()->with('error', 'Entrer un nom d\'utilisateur');
        }
        try {
            // $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
            // ->get("http://{$ip_adress}/odsmartflow/manages-persons/find/byUsername/{$username}")
            // ->json();
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/find/byUsername/' . $username)->json();
            //http://192.168.1.9:8081/odsmartflow/manages-persons/find/byUsername/oloukponah@gmail.com
            //dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $users = $response['data'];
            $current = $response['data'];
            $totalPages = $response['data'];
            $numberOfElements = $response['data'];
            return view('users.index', compact('users', 'current', 'totalPages', 'numberOfElements'));


        } catch (Exception $e) {
            dd($e);
            return new Response(500);
        }
        return view('users.index', compact('users', 'current', 'totalPages', 'numberOfElements'));
    }

    public function delete(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = $request['personId'];
        //dd($personId);
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/delete/' . $personId);
        
            //dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }else{
                //return view("user.index");
                return redirect()->route('user.index',['page'=>0]);

            }
        } catch (Exception $e) {
            return redirect()->route('user.index',['page'=>0]);

            //dd($e);
            return new Response(500);
        }
        return Redirect::to('/user/index/0');
    }

    public function edit($personId)
    {
        //dd($personId);
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-roles/selectList/byEnterprise/' . $enterpriseId)->json();
            $roles = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-functions/list/byEnterprise/' . $enterpriseId)->json();
            $functions = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $request = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/find/' . $personId)->json();
            $person = $request['data'];
            if ($request['message'] == "Access denied") {
                return view('errors.401');
            }elseif($request['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('users.edit', compact('person', 'roles', 'functions'));
    }

    public function update(Request $request, $personId)
    {

        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $person = array();
        $person['personId'] = $personId;
        $person['firstName'] = $request['firstname'];
        $person['lastName'] = $request['lastname'];
        $person['password'] = $request['password'];
        $person['username'] = $request['email'];
        $person['telephone'] = $request['phone'];
        $person['enterpriseId'] = session('session.userDto.smartflowEnterprise.enterpriseId');
        $person['functionId'] = $request['functionId'];
        $person['roleId'] = $request['roleId'];
        $person['createdBy'] = "open@gmail.com";
        $person['createdAt'] = "1690976267544";
        $person['updatedAt'] = "1692950440044";
        $person['softDeleteAt'] = null;
        $person['updatedBy'] = "hans.oloukpona-yinnon@opendigitizer.com";
        $person['softDeletedBy'] = null;
        $person['deletedFlag'] = "a";
        $person['userIdForLog'] = null;

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->put('http://' . $ip_adress . '/odsmartflow/manages-persons/update', $person);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/user/index/0');
    }
}
