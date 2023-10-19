<?php

namespace App\Http\Controllers;

use App\Models\SmartflowDocument;
use App\Models\SmartflowDocumentAgreement;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class DocumentController extends Controller
{
    //
    // public function create($formId)
    // {
    //     $ip_adress = env('APP_IP_ADRESS');
    //     $token = session('session.token');
    //     $personId = session('session.userDto.personId');

    //     try {
    //         $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId . '/byUserAccess/' . $personId)->json();
    //         $myform = $response['data'];
    //         if ($response['message'] == "Access denied") {
    //             return view('errors.401');
    //         } elseif ($response['message'] == "Authentication failed") {
    //             return view("auth.login");
    //         }
    //     } catch (Exception $e) {
    //         return new Response(500);
    //     }
    //     return view('documents.create', compact('myform'));
    // }

    public function create($formId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId . '/byUserAccess/' . $personId)->json();
            $myform = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('test', compact('myform'));
    }


    public function try(Request $request)
    {
        $test = $request->all();
        dd($test);
    }

    public function handlecreate(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $create = $request->all();
        dd($create);
        $token = session('session.token');

        $content = $create['content'];
        $name = $create['name'];
        $formId = $create['formId'];
        $agreeLevelNumber = $create['agreeLevelNumber'];
        $document = new SmartflowDocument();
        $document['name'] = $name;
        $document['content'] = $content;
        $document['formId'] = $formId;
        $document['agreeLevelNumber'] = $agreeLevelNumber;

        try {
            $document_response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-documents/create/document', $document);
            if ($document_response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($document_response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        $approval = $create['approvals'];
        $agreement = new SmartflowDocumentAgreement();
        $agreement['documentId'] = $document_response['data']['documentId'];
        foreach ($approval as $key => $values) {
            $agreement['level'] = $key;
            foreach ($values as $value) {
                $agreement['personId'] = $value;
                try {
                    $agreement_response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                    ])->post('http://' . $ip_adress . '/odsmartflow/manages-documentsAgreements/add/documentAgreement', $agreement);
                    if ($agreement_response['message'] == "Access denied") {
                        return view('errors.401');
                    } elseif ($agreement_response['message'] == "Authentication failed") {
                        return view("auth.login");
                    }
                } catch (Exception $e) {
                    return new Response(500);
                }
            }
        }
    }

    public function created($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/userOwn/' . $personId . '/status/CREATED?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $created = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.created', compact('created', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function initiated($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/userOwn/' . $personId . '/status/INITIATED?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $initiated = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return view('documents.initiated', compact('initiated', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function rejected($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/userOwn/' . $personId . '/status/REJECTED?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $rejected = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.rejected', compact('rejected', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function validated($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/userOwn/' . $personId . '/status/VALIDATED?page=' . $page)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $validated = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.validated', compact('validated', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function display($documentId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/one/document/' . $documentId)->json();
            $document = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $formId = $document['formId'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId)->json();
            $form = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.display', compact('document', 'form'));
    }

    public function preview($documentId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/exportPrepare/document/' . $documentId)->json();
            $document = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $formId = $document['formId'];
            $approvals = $document['listOfSmartflowDocumentSuccessAgreement'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId)->json();
            $form = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.preview', compact('document', 'form', 'approvals'));
    }

    public function initiate(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $documentId = $request['initiateId'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/initiate/document/' . $documentId)->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/document/initiated/0');
    }

    public function new()
    {
        return view('documents.new');
    }

    public function delete(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $documentId = $request['documentId'];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/delete/document/' . $documentId);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/document/created/0');
    }

    public function edit($documentId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/one/document/' . $documentId)->json();
            $document = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $formId = $document['formId'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId)->json();
            $form = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.edit', compact('document', 'form'));
    }

    public function enhance($documentId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/one/document/' . $documentId)->json();
            $document = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $formId = $document['formId'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId)->json();
            $form = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.update', compact('document', 'form'));
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $update = $request->all();
        $token = session('session.token');
        $document = new SmartflowDocument();
        $document['documentId'] = $update['documentId'];
        $document['content'] = $update['content'];
        $document['name'] = $update['name'];
        $document['formId'] = $update['formId'];
        $document['createdBy'] = $update['createdBy'];
        $document['createdAt'] = $update['createdAt'];
        $document['deletedFlag'] = $update['deletedFlag'];
        $document['status'] = $update['status'];
        $document['agreeLevelNumber'] = $update['agreeLevelNumber'];
        $document['actualAgreeLevel'] = $update['actualAgreeLevel'];
        $document['userIdForLog'] = $update['userIdForLog'];
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->put('http://' . $ip_adress . '/odsmartflow/manages-documents/update/document', $document);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }

        return back();
    }

    public function pdfDocument($document)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
            //recuperer tout les information de l'entreprise
            $document = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/exportPrepare/document/' . $document)->json();

            $resp = $document['data'];

            $resp1 = $document['data']['listOfSmartflowDocumentSuccessAgreement'][0]['validatorFirstName'];
            $resp2 = $document['data']['listOfSmartflowDocumentSuccessAgreement'][0]['validatorLastName'];
            $resp3 = $document['data']['listOfSmartflowDocumentSuccessAgreement'][0]['documentAgreementSignature'];
            $resp4 = $document['data']['listOfSmartflowDocumentSuccessAgreement'][0]['documentAgreementSignature'];

            //dd($resp1,$resp2,$resp3,$resp4);

            $formId = $document['data']['formId'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-forms/one/form/' . $formId)->json();
            $form = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            //dd($form['content'],$form['name'],$resp['name']);

            // Chargez la vue Laravel que vous souhaitez convertir en PDF
            $html = View::make('documents.facture', compact('resp', 'resp1', 'resp2', 'resp3', 'resp4', 'form'));

            // Créez une instance de Dompdf
            $dompdf = new Dompdf();

            // Chargez le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // Rendez le PDF
            $dompdf->render();

            // Téléchargez le PDF
            return $dompdf->stream('Document.pdf', ['Attachment' => false]);
        } catch (Exception $e) {
            // dd($e);
            throw new Exception("Une erreur est survenue lors du téléchargement de la liste");
        }
    }

    public function search1(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "VALIDATED";
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/userOwn/{$personId}/inStatus/{$status}/withName/{$documentName}")
                ->json();
            dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $validated = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.validated', compact('validated', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }



    public function search2(Request $request)

    {

        $ip_adress = env('APP_IP_ADRESS');

        $token = session('session.token');

        $personId = session('session.userDto.personId');

        $documentName = $request->search;

        $status = "REJECTED";
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }

        try {

            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])

                ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/userOwn/{$personId}/inStatus/{$status}/withName/{$documentName}")

                ->json();
            if ($response['message'] == "Access denied") {

                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {

                return view("auth.login");
            }

            $rejected = $response['data']['content'];

            $current = $response['data']['number'];

            $totalPages = $response['data']['totalPages'];

            $numberOfElements = $response['data']['numberOfElements'];

            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();

            $numbers = $data['data'];

            if ($data['message'] == "Access denied") {

                return view('errors.401');
            } elseif ($data['message'] == "Authentication failed") {

                return view("auth.login");
            }
        } catch (Exception $e) {

            return new Response(500);
        }

        return view('documents.rejected', compact('rejected', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function search3(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "INITIATED";
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/userOwn/{$personId}/inStatus/{$status}/withName/{$documentName}")
            ->json();
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $initiated = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }


        return view('documents.initiated', compact('initiated', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function search(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "CREATED";
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/userOwn/{$personId}/inStatus/{$status}/withName/{$documentName}")
            ->json();           //dd($response);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            }elseif($response['message'] == "Authentication failed"){
                return view("auth.login");
            }
            $created = $response['data']['content'];
            $current = $response['data']['number'];
            $totalPages = $response['data']['totalPages'];
            $numberOfElements = $response['data']['numberOfElements'];
            $data = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/document/' . $personId)->json();
            $numbers = $data['data'];
            if ($data['message'] == "Access denied") {
                return view('errors.401');
            }elseif($data['message'] == "Authentication failed"){
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('documents.created', compact('created', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

}
