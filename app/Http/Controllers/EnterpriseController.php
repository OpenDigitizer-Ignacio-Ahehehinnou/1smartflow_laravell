<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use PDF;

class EnterpriseController extends Controller
{
    public function index()
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-enterprises/find/enterprise/' . $enterpriseId)->json();
          //  dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $enterprise = $response['data'];
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('enterprise.index', compact('enterprise'));
    }

    public function pdf($enterprise)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');

        try {
            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
            //recuperer tout les information de l'entreprise
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-enterprises/find/enterprise/' . $enterpriseId)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $enterprise = $response['data'];
            $name = $response['data']['name'];
            $manager = $response['data']['manager'];
            $telephone = $response['data']['telephone'];

            $data = [
                'name' => $name,
                'manager' => $manager,
                'telephone' => $telephone,
            ];
            // Chargez la vue Laravel que vous souhaitez convertir en PDF
            $html = View::make('enterprise.facture', compact('enterprise'))->render();
            // Créez une instance de Dompdf
            $dompdf = new Dompdf();
            // Chargez le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);
            // Rendez le PDF
            $dompdf->render();
            // Téléchargez le PDF
            return $dompdf->stream('Entreprise_' . $name . '.pdf', ['Attachment' => false]);
        } catch (Exception $e) {
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $donnees = $request->all();
        //dd($donnees);

        $request->validate([
            "name" => "required",
            "manager" => "required",
        ]);

        $test = array();
        $test['enterpriseId'] = $request['enterpriseId'];
        $test['name'] = $request['name'];
        $test['manager'] = $request['manager'];
        $test['ifu'] = $request['ifu'];
        $test['email'] = $request['email'];
        $test['address'] = $request['address'];
        $test['telephone'] = $request['telephone'];
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
                ->put('http://' . $ip_adress . '/odsmartflow/manages-enterprises/update/enterprise', $test);
            $enterprise = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $entreprises = $response->json();
            $statusCode = $response->status();
            return new Response(200);
        } catch (Exception $e) {
            // dd(0);
            return new Response(500);
        }

        return view('enterprise.index', compact('enterprise'));
    }
}
