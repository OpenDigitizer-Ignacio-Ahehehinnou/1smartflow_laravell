<?php

namespace App\Http\Controllers;

use App\Models\SmartflowSignEntries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class DocumentAgreementController extends Controller
{
    //
    public function pending($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $initiated = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/agreement/concern/' . $personId . '/inStatus/INITIATED?page=' . $page)->json();
            //dd($initiated);
            if ($initiated['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($initiated['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $pending = $initiated['data']['content'];
            $current = $initiated['data']['number'];
            $totalPages = $initiated['data']['totalPages'];
            $numberOfElements = $initiated['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.pending', compact('pending', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function approved($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $validated = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/agreement/concern/' . $personId . '/inStatus/VALIDATED?page=' . $page)->json();
            if ($validated['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($validated['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $validate = $validated['data']['content'];
            $current = $validated['data']['number'];
            $totalPages = $validated['data']['totalPages'];
            $numberOfElements = $validated['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.approved', compact('validate', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function search(Request $request)
    {
        //dd($request);
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "INITIATED";
        // dd($status,$documentName,$personId);


        // dd($documentName);
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }

        try {
            $initiated = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/agreement/concern/{$personId}/inStatus/{$status}/withName/{$documentName}")
                ->json();


            //dd($initiated);
            if ($initiated['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($initiated['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $pending = $initiated['data']['content'];
            $current = $initiated['data']['number'];
            $totalPages = $initiated['data']['totalPages'];
            $numberOfElements = $initiated['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            // dd($response);
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.pending', compact('pending', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }


    public function search1(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "VALIDATED";
        // dd($status,$documentName,$personId);


        // dd($documentName);
        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }


        try {
            $validated = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/agreement/concern/{$personId}/inStatus/{$status}/withName/{$documentName}")
                ->json();


            // dd($validated);
            if ($validated['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($validated['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $validate = $validated['data']['content'];
            $current = $validated['data']['number'];
            $totalPages = $validated['data']['totalPages'];
            $numberOfElements = $validated['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.approved', compact('validate', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function search2(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $documentName = $request->search;
        $status = "REJECTED";
        // dd($status,$documentName,$personId);

        if ($documentName === null) {
            return back()->with('error', 'Le nom du formulaire est vide');
        }


        try {
            $rejected = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get("http://{$ip_adress}/odsmartflow/manages-documents/search/document/agreement/concern/{$personId}/inStatus/{$status}/withName/{$documentName}")
                ->json();
            if ($rejected['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($rejected['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $reject = $rejected['data']['content'];
            $current = $rejected['data']['number'];
            $totalPages = $rejected['data']['totalPages'];
            $numberOfElements = $rejected['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.rejected', compact('reject', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function rejected($page)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');

        try {
            $rejected = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/list/document/agreement/concern/' . $personId . '/inStatus/REJECTED?page=' . $page)->json();
            if ($rejected['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($rejected['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $reject = $rejected['data']['content'];
            $current = $rejected['data']['number'];
            $totalPages = $rejected['data']['totalPages'];
            $numberOfElements = $rejected['data']['numberOfElements'];
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/count/documentAgreement/' . $personId)->json();
            $numbers = $response['data'];
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return view('approvals.rejected', compact('reject', 'numbers', 'current', 'totalPages', 'numberOfElements'));
    }

    public function reject(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $reject = new SmartflowSignEntries();
        $reject['documentId'] = intval($request['rejectId']);
        $reject['personId'] = $personId;
        $reject['comment'] = $request['comment'];
        $reject['level'] = intval($request['level']);
        $reject['statusAgreement'] = "DOC_AGREE_REJECTED_BY_ME";
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-documentsAgreements/addApproving/agree', $reject);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/approval/rejected/0');
    }

    public function valid(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $valid = new SmartflowSignEntries();
        $valid['documentId'] = intval($request['validId']);
        $valid['personId'] = $personId;
        $valid['comment'] = $request['comment'];
        $valid['level'] = intval($request['level']);
        $valid['statusAgreement'] = "DOC_AGREE_APPROVED_BY_ME";
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-documentsAgreements/addApproving/agree', $valid);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/approval/approved/0');
    }

    public function sign(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $personId = session('session.userDto.personId');
        $sign = new SmartflowSignEntries();
        $sign['documentId'] = intval($request['signId']);
        $sign['personId'] = $personId;
        $sign['comment'] = $request['comment'];
        $sign['level'] = intval($request['level']);
        $sign['statusAgreement'] = "DOC_AGREE_APPROVED_BY_ME";
        $sign['signature'] = $request['signature'];
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('http://' . $ip_adress . '/odsmartflow/manages-documentsAgreements/addApproving/sign', $sign);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
        } catch (Exception $e) {
            return new Response(500);
        }
        return Redirect::to('/approval/approved/0');
    }

    public function persons($formId, $agreeLevelNumber)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $response = array();
        try {
            for ($i = 1; $i <= $agreeLevelNumber; $i++) {
                $person = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-persons/list/byFormId/' . $formId . '/byLevel/' . $i)->json();
                $persons = $person['data'];
                if ($person['message'] == "Access denied") {
                    return view('errors.401');
                } elseif ($person['message'] == "Authentication failed") {
                    return view("auth.login");
                }
                $response['Niveau ' . $i] = $persons;
            };
        } catch (Exception $e) {
            return new Response(500);
        }
        return response()->json(['persons' => $response]);
    }

    public function overview($documentId)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $token = session('session.token');
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://' . $ip_adress . '/odsmartflow/manages-documents/one/document/' . $documentId)->json();
            $document = $response['data'];
            //dd($document);
            if ($response['message'] == "Access denied") {
                return view('errors.401');
            } elseif ($response['message'] == "Authentication failed") {
                return view("auth.login");
            }
            $formId = $response['data']['formId'];
            //$approvals = $response['data']['listOfSmartflowDocumentSuccessAgreement'];
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
        return view('approvals.overview', compact('document', 'form'));
    }
}
