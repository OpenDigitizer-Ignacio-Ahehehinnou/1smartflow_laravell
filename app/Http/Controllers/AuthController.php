<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\SmartflowPerson;
use App\Models\SmartflowPersonLite;
use App\Models\SmartflowRegister;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\RequestException;


class AuthController extends Controller
{
    public function register()
    {
        return view("auth.register");
    }


    public function handleregister(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        //dd($request->all());
        $data = $request->all();
        $register = new SmartflowRegister();
        $confirm = $request['confirm_password'];
        $register['enterpriseName'] = $request['enterprise_name'];
        $register['enterpriseAdress'] = $request['enterprise_adress'];
        $register['enterpriseEmail'] = $request['enterprise_email'];
        $register['enterpriseIfu'] = $request['enterprise_ifu'];
        $register['enterprisePhone'] = $request['enterprise_phone'];
        $register['personFirstname'] = $request['person_firstname'];
        $register['personLastname'] = $request['person_lastname'];
        $register['personPassword'] = $request['person_password'];
        $register['personUsername'] = $request['person_username'];
        $register['personPhone'] = $request['person_phone'];
        $register['personSignature'] = $request['person_signature'];
        $register['personFunction'] = $request['person_function'];
        if ($confirm != $request['person_password']) {
            return redirect()->back()->withInput($data)->with('error', "Les mots de passe ne correspondent pas.");
        }
        $response = Http::post('http://' . $ip_adress . '/odsmartflow/manages-generals/signUp', $register);
        if ($response['code'] == 409) {
            return redirect()->back()->withInput($data)->with('error', "L'email que vous essayer d'utiliser existe déjà.'");
        }
        return Redirect::to('/auth/login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function handlelogin(AuthRequest $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $credentials = $request->only(['username', 'password']);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://' . $ip_adress . '/odsmartflow/manages-persons/authenticate', $credentials)->json();
       /// dd($response);
        session(['session' => $response['data']]);
        if ($response['code'] == "403") {
            return redirect()->back()->with('bad_credentials', "Identifiants de connexion incorrects.");
        }
        return Redirect::to('/approval/pending/0');
    }

    public function reset()
    {
        return view('auth.reset');
    }

    public function profile()
    {

        // Récupérez les données de session
        $sessionData = session('session');

        // dd($sessionData);

        // Utilisez les données de session comme vous le souhaitez
        if ($sessionData) {
            // Accédez aux données de session, par exemple :
            $personId = $sessionData['userDto']['personId'];
            $firstName = $sessionData['userDto']['firstName'];
            $lastName = $sessionData['userDto']['lastName'];
            $telephone = $sessionData['userDto']['telephone'];
            $username = $sessionData['userDto']['username'];
            $function = $sessionData['userDto']['smartflowFunction']['libelle'];
            $role = $sessionData['userDto']['smartflowRole']['label'];
            $signature = $sessionData['userDto']['signature'];
            $enterprise = $sessionData['userDto']['smartflowEnterprise']['name'];

            //dd($firstName,$lastName,$telephone,$username,$function,$role,$signature,$enterprise);

            // Faites ce dont vous avez besoin avec les données de session
        } else {
            // La session n'a pas été trouvée ou est vide
        }
        return view('auth.profile')->with([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'telephone' => $telephone,
            'username' => $username,
            'function' => $function,
            'role' => $role,
            'signature' => $signature,
            'enterprise' => $enterprise,
            'personId' => $personId,
        ]);
    }

    public function show()
    {
        return view('signature');
    }

    public function save(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $signatureDataUrl = $request->input('signature');
        $personId = $request->input('id');
        //dd($signatureDataUrl);
        $sessionData = session('session');

        // $role = array();
        $token = $sessionData['token'];
        $userIdForLog = $sessionData['userIdForLog'];
        $personId = $personId;
        $firstName = $sessionData['userDto']['firstName'];
        $lastName = $sessionData['userDto']['lastName'];
        $telephone = $sessionData['userDto']['telephone'];
        $username = $sessionData['userDto']['username'];
        $function = $sessionData['userDto']['smartflowFunction'];
        $rolee = $sessionData['userDto']['smartflowRole'];
        $signature = $signatureDataUrl;
        $enterprise = $sessionData['userDto']['smartflowEnterprise'];
        $verificationCode = $sessionData['userDto']['verificationCode'];
        $verificationCodeExpiredAt = $sessionData['userDto']['verificationCodeExpiredAt'];
        $listOfSmartflowNotification = $sessionData['userDto']['listOfSmartflowNotification'];
        $createdAt = $sessionData['userDto']['createdAt'];
        $createdBy = $sessionData['userDto']['createdBy'];
        $deletedFlag = $sessionData['userDto']['deletedFlag'];
        $isAccountNonExpired = $sessionData['userDto']['isAccountNonExpired'];
        $isAccountNonLocked = $sessionData['userDto']['isAccountNonLocked'];
        $isCredentialsNonExpired = $sessionData['userDto']['isCredentialsNonExpired'];
        $isEnabled = $sessionData['userDto']['isEnabled'];
        $userIdForLog = $sessionData['userDto']['userIdForLog'];
        $roleId = $sessionData['userDto']['roleId'];
        $updatedBy = $sessionData['userDto']['updatedBy'];
        $updatedAt = $sessionData['userDto']['updatedAt'];
        $softDeletedBy = $sessionData['userDto']['softDeletedBy'];
        $softDeletedAt = $sessionData['userDto']['softDeletedAt'];
        $functionId = $sessionData['userDto']['functionId'];
        $enterpriseId = $sessionData['userDto']['enterpriseId'];

        $role = array();
        $role['personId'] = $personId;
        $role['firstName'] = $firstName;
        $role['lastName'] = $lastName;
        $role['telephone'] = $telephone;
        $role['token'] = $token;
        $role['userIdForLog'] = $userIdForLog;
        $role['username'] = $username;
        $role['enterprise'] = $enterprise;
        $role['function'] = $function;
        $role['role'] = $rolee;
        $role['signature'] = $signature;
        $role['verificationCode'] = $verificationCode;
        $role['verificationCodeExpiredAt'] = $verificationCodeExpiredAt;
        $role['listOfSmartflowNotification'] = $listOfSmartflowNotification;
        $role['isAccountNonExpired'] = $isAccountNonExpired;
        $role['enterpriseId'] = $enterpriseId;
        $role['functionId'] = $functionId;
        $role['roleId'] = $roleId;
        $role['isEnabled'] = $isEnabled;
        $role['isCredentialsNonExpired'] = $isCredentialsNonExpired;
        $role['isAccountNonLocked'] = $isAccountNonLocked;
        $role['createdBy'] = $createdBy;
        $role['createdAt'] = $createdAt;
        $role['updatedAt'] = $updatedAt;
        $role['softDeleteAt'] = $softDeletedAt;
        $role['updatedBy'] = $updatedBy;
        $role['softDeletedBy'] = $softDeletedBy;
        $role['deletedFlag'] = $deletedFlag;
        $role['userIdForLog'] = $userIdForLog;

        //dd($role);
        // try {
        //     $token = session('session.token');
        //     $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

        //     // Effectuez la requête HTTP avec la méthode PUT et incluez les données mises à jour
        //     $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
        //         ->put('http://192.168.1.8:8081/odsmartflow/manages-persons/update', $role);

        //     $entreprises = $response->json();
        //     $statusCode = $response->status();

        //    // dd($response, $entreprises,$statusCode);
        //     return new Response(200);
        // } catch (Exception $e) {
        //     dd($e);
        //     return new Response(500);
        // }

        try {
            $token = session('session.token');
            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
            // $personId = auth()->user()->id; // Obtenez l'ID de la personne connectée

            // Assurez-vous que vous avez le chemin complet de la nouvelle signature
            // $newSignature = $request->input('new_signature');

            // Préparez les données à envoyer dans la requête PUT
            $requestData = [
                'personId' => $personId,
                'signature' => $signature,
            ];

            // Effectuez la requête HTTP avec la méthode PUT et incluez les données mises à jour
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put('http://' . $ip_adress . '/odsmartflow/manages-persons/update', $role);
                if ($response['code'] == "401") {
                    return view('errors.401');
                }
            // Vérifiez la réponse du serveur distant
            if ($response->successful()) {
                // La mise à jour de la signature a réussi
                return new Response(200);
            } else {
                // La mise à jour a échoué, renvoyez un code d'erreur approprié
                // dd(1);
                return new Response(500);
            }
        } catch (Exception $e) {
            // Gérez les erreurs, par exemple, renvoyez un code d'erreur approprié
            dd($e);
            return new Response(500);
        }
        return response()->json(['message' => 'Signature enregistrée avec succès']);
    }

    // Afficher une signature
    public function recupererSignature(Request $request)
    {

        $sessionData = session('session');
        // dd($sessionData);
        // Accédez aux données de session, par exemple :
        $signature = $sessionData['userDto']['signature'];
        //dd($signature);
        $personId = $request->input('id');
        //dd($signature, $personId);
        if ($signature) {
            return response()->json(['signature' => $signature, 'personId' => $personId]);
            //  dd($signature);
        }

        return response()->json(['message' => 'Signature non trouvée'], 404);
    }

    public function modifier()
    {

        return view('auth.modifier');
    }

    public function update(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $donnees = $request->all();
        $test = array();
        $test['current_password'] = $request['current_password'];
        $test['new_password'] = $request['new_password'];
        $test['new_password_confirmation'] = $request['new_password_confirmation'];

        // dump($test);

        //$signatureDataUrl = $request->input('signature');

        $sessionData = session('session');

        // $role = array();
        // $token=$sessionData['token'];
        $userIdForLog = $sessionData['userIdForLog'];
        $personId = $sessionData['userDto']['personId'];
        $firstName = $sessionData['userDto']['firstName'];
        $password = $request['new_password'];
        $lastName = $sessionData['userDto']['lastName'];
        $telephone = $sessionData['userDto']['telephone'];
        $username = $sessionData['userDto']['username'];
        $function = $sessionData['userDto']['smartflowFunction'];
        $rolee = $sessionData['userDto']['smartflowRole'];
        $signature = $sessionData['userDto']['signature'];
        $enterprise = $sessionData['userDto']['smartflowEnterprise'];
        $verificationCode = $sessionData['userDto']['verificationCode'];
        $verificationCodeExpiredAt = $sessionData['userDto']['verificationCodeExpiredAt'];
        $listOfSmartflowNotification = $sessionData['userDto']['listOfSmartflowNotification'];
        $createdAt = $sessionData['userDto']['createdAt'];
        $createdBy = $sessionData['userDto']['createdBy'];
        $deletedFlag = $sessionData['userDto']['deletedFlag'];
        $isAccountNonExpired = $sessionData['userDto']['isAccountNonExpired'];
        $isAccountNonLocked = $sessionData['userDto']['isAccountNonLocked'];
        $isCredentialsNonExpired = $sessionData['userDto']['isCredentialsNonExpired'];
        $isEnabled = $sessionData['userDto']['isEnabled'];
        $userIdForLog = $sessionData['userDto']['userIdForLog'];
        $roleId = $sessionData['userDto']['roleId'];
        $updatedBy = $sessionData['userDto']['updatedBy'];
        $updatedAt = $sessionData['userDto']['updatedAt'];
        $softDeletedBy = $sessionData['userDto']['softDeletedBy'];
        $softDeletedAt = $sessionData['userDto']['softDeletedAt'];
        $functionId = $sessionData['userDto']['functionId'];
        $enterpriseId = $sessionData['userDto']['enterpriseId'];

        //dd($listOfSmartflowNotification,$signature);
        $role = array();
        $role['personId'] = $personId;
        $role['firstName'] = $firstName;
        $role['lastName'] = $lastName;
        $role['telephone'] = $telephone;
        $role['password'] = $password;
        $role['userIdForLog'] = $userIdForLog;
        $role['username'] = $username;
        $role['enterprise'] = $enterprise;
        $role['function'] = $function;
        $role['role'] = $rolee;
        $role['signature'] = $signature;
        $role['verificationCode'] = $verificationCode;
        $role['verificationCodeExpiredAt'] = $verificationCodeExpiredAt;
        $role['listOfSmartflowNotification'] = $listOfSmartflowNotification;
        $role['isAccountNonExpired'] = $isAccountNonExpired;
        $role['enterpriseId'] = $enterpriseId;
        $role['functionId'] = $functionId;
        $role['roleId'] = $roleId;
        $role['isEnabled'] = $isEnabled;
        $role['isCredentialsNonExpired'] = $isCredentialsNonExpired;
        $role['isAccountNonLocked'] = $isAccountNonLocked;
        $role['createdBy'] = $createdBy;
        $role['createdAt'] = $createdAt;
        $role['updatedAt'] = $updatedAt;
        $role['softDeleteAt'] = $softDeletedAt;
        $role['updatedBy'] = $updatedBy;
        $role['softDeletedBy'] = $softDeletedBy;
        $role['deletedFlag'] = $deletedFlag;
        $role['userIdForLog'] = $userIdForLog;

        try {
            $token = session('session.token');
            $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');

            // Effectuez la requête HTTP avec la méthode PUT et incluez les données mises à jour
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put('http://' . $ip_adress . '/odsmartflow/manages-persons/update/password', $role);
                if ($response['code'] == "401") {
                    return view('errors.401');
                }
            $entreprises = $response->json();
            $statusCode = $response->status();

            //dd($response, $entreprises,$statusCode);
            return new Response(200);
        } catch (Exception $e) {
            dd(e);
            return new Response(500);
        }

        return view('auth.modifier');
    }

    public function logout()
    {
        session()->forget('session.token');
        return redirect()->route('auth.login');
    }

    public function handlereset(Request $request)
    {
        $ip_adress = env('APP_IP_ADRESS');
        $personId = session('session.userDto.personId');
        $enterpriseId = session('session.userDto.smartflowEnterprise.enterpriseId');
        $roleId = session('session.userDto.roleId');
        $person = new SmartflowPerson();

        $mail=$request->email;
        $person['username'] = $mail;

        if ($mail === null) {
            return back()->with('error', 'Entrer un  mail valide');
        }
        try {

        $response = Http::put("http://{$ip_adress}/odsmartflow/manages-persons/update/verificationCode", $person);

        //dd($response);
        $email = $response['data']['username'];
        } catch (Exception $e) {
           //dd($e);
            return new Response(500);
        }
        return view('auth.code', compact('email') );
    }

    public function handlecode(Request $request) {
       // dd($request);
        $ip_adress = env('APP_IP_ADRESS');
        $username= $request->username;

        $code = new SmartflowPersonLite();
        $code['verificationCode'] = $request['code'];
        $code['username'] = $request['username'];
        $response = Http::post('http://'.$ip_adress.'/odsmartflow/manages-persons/codeVerification', $code);
       // dd($response);
        $statusCode = $response->getStatusCode();

        if($statusCode== 500){
            return view('auth.code',['email' => $username,'error' => 'Le code saisir n\'est pas correste.']);
        }
        $personId = $response['data']['personId'];
        //return redirect()->route('auth.handle.password', );

        return view('auth.password', ['personId' => $personId]);
    }

    public function handlepassword(Request $request) {
            //dd($request);
        $ip_adress = env('APP_IP_ADRESS');
        $passwordb = new SmartflowPersonLite();
         $personId= $request->personId;
         if($request['password'] != $request['confirm']){
            return view('auth.password',['personId' => $personId, 'error' => 'Les mots de passe ne correspondent pas.']);
        }
        
        $passwordb['password'] = $request['password'];

        $passwordb['personId'] = $request['personId'];
        //$response = Http::put('http://192.168.1.11:8080/odsmartflow/manages-persons/update/password', $password);
        $response = Http::put('http://'.$ip_adress.'/odsmartflow/manages-persons/update/password', $passwordb);
        return view('auth.login');
    }
}
