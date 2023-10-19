<?php

namespace App\Http\Controllers;

use App\Models\SmartflowRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
{
    //

    public function index(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-roles/list/byEnterprise/' . $enterpriseId)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $roles = $response['data']['content'];
            $data = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-rights/selectList')->json();
            $rights = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return view('roles.index', compact('rights', 'roles', 'current', 'totalPages', 'numberOfElements'));
    }

    public function showRoleRights($roleId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');

        try {
            // Récupérez le rôle spécifique en fonction de son ID
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get("http://' . $ip_adress . '/odsmartflow/manages-rights/list/byRole/17")->json();
            $role = $response['data'];
            if ($response['code'] == "401") {
                return view('errors.401');
            } elseif ($response['message'] == "Access Denied: You don't have the required access.") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return view('roles.show', compact('role'));
    }

    public function create(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $role = new SmartflowRole();
        $role['label'] = $request['label'];
        $role['description'] = $request['description'];
        $role['enterpriseId'] = session('session.userDto.smartflowEnterprise.enterpriseId');
        $role['listOfSmartflowRightId'] = $request['rights'];
        $token = session('session.token');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-roles/create', $role);
            if ($response['code'] == "401") {
                return view('errors.401');
            } elseif ($response['message'] == "Access Denied: You don't have the required access.") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return back()->with("success", "Role crée avec succès")->with(compact('response'));
    }

    public function delete($roleId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-roles/delete/' . $roleId);
            if ($response['code'] == "401") {
                return view('errors.401');
            } elseif ($response['message'] == "Access Denied: You don't have the required access.") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return back()->with("success", "Role supprimé avec succès");
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $donnees = $request->all();
        $selectedRights = $request->input('selectedRights', []);
        $request->validate([
            "label" => "required",
        ]);

        // Supprimez les caractères "[" et "]" de la chaîne pour obtenir "11","14"
        $stringData = str_replace(["[", "]"], "", $request->input('selectedRights'));
        $stringData = ltrim($stringData, ',');

        // Séparez les valeurs numériques en un tableau en utilisant la virgule comme délimiteur
        $arrayData = explode(",", $stringData);

        // Convertissez chaque élément du tableau en entier (ou laissez-les en tant que chaînes si nécessaire)
        $intArrayData = array_map('intval', $arrayData);

        $role = array();
        $role['roleId'] = $request['roleId'];
        $role['label'] = $request['label'];
        $role['description'] = $request['description'];
        $role['enterpriseId'] = session('session.userDto.smartflowEnterprise.enterpriseId');
        $role['listOfSmartflowRightId'] = $intArrayData;
        $role['createdBy'] = "ignacio@gmail.com";
        $role['createdAt'] = "1690976267544";
        $role['updatedAt'] = "1692950440044";
        $role['softDeleteAt'] = null;
        $role['updatedBy'] = "hans.oloukpona-yinnon@opendigitizer.com";
        $role['softDeletedBy'] = null;
        $role['deletedFlag'] = "a";
        $role['userIdForLog'] = null;

        try {

            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

            // Effectuez la requête HTTP avec la méthode PUT et incluez les données mises à jour
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put('http://' . $ip_adress . '/odsmartflow/manages-roles/update', $role);
            if ($response['code'] == "401") {
                return view('errors.401');
            } elseif ($response['message'] == "Access Denied: You don't have the required access.") {
                return view("auth.login");
            }
            $entreprises = $response->json();
            $statusCode = $response->status();
            //return new Response(200);
        } catch (Exception $e) {
            //dd(0);
            return new Response(500);
        }
        return view('enterprise.index', compact('enterprise'));

    }

}
