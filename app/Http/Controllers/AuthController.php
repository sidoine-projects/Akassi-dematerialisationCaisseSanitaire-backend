<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use ReCaptcha\ReCaptcha;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',

    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user,
    //             'message' => 'Authenticated successfully',
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials',
    //     ], 401);
    // }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|max:255',
    //         'password' => 'required',
    //         'recaptcha_token' => 'required',
    //     ]);


    //     $recaptchaToken = $request->input('recaptcha_token');
    //     $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => config('services.recaptcha.secret_key'),
    //         'response' => $recaptchaToken,
    //     ]);

    //     if ($recaptchaResponse->json('success') !== true) {
    //         throw ValidationException::withMessages([
    //             'recaptcha_token' => 'Failed to validate reCAPTCHA.',
    //         ]);
    //     }

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user,
    //             'message' => 'Authenticated successfully',
    //         ], 200);
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials',
    //     ], 401);
    // }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|max:255',
    //         'password' => 'required',
    //         // 'recaptcha_token' => 'required',
    //     ]);

    // Vérifiez le reCAPTCHA
    // $recaptchaToken = $request->input('recaptcha_token');
    // $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //     'secret' => config('services.recaptcha.secret_key'),
    //     'response' => $recaptchaToken,
    // ]);

    // if (!$recaptchaResponse->json('success')) {
    //     throw ValidationException::withMessages([
    //         'recaptcha_token' => 'Failed to validate reCAPTCHA.',
    //     ]);
    // }

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'token' => $token,
    //             'user' => $user,
    //             'message' => 'Authentification réussie',
    //         ], 200);
    //     }

    //     return response()->json([
    //         'message' => 'Identifiants invalides',
    //     ], 401);
    // }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required', // Champ reCAPTCHA
        ]);


        // //Vérifier le reCAPTCHA
        // $recaptcha = new ReCaptcha(config('app.RECAPTCHA_SECRET_KEY'));
        // $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        // if (!$response->isSuccess()) {
        //     return response()->json(['message' => 'reCAPTCHA validation failed'], 401);
        // }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'OK',
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([

                'message' => 'Utilisateur non trouvé',
            ]);
        }
        if (Hash::check($request->password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return response()->json([
                'message' => 'Password updated successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid password',
            ], 401);
        }
    }



    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'password_confirmation' => 'required|min:8|same:password',

        ]);
        if ($request->password !== $request->password_confirmation) {
            return response()->json([
                'message' => 'Les mots de passe ne sont pas conformes',
            ], 400);
        } else if ($request->password == $request->password_confirmation) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                $user->password = Hash::make($request->password);
                $user->save();
                // $user->password=$request->password;
                return response()->json([
                    'message' => 'Mot de passe rénitialisé avec succès',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Utilisateur non trouvé',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Mot de passe échoué',
            ], 400);
        }
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'User registered successfully',
        ]);
    }

    public function requestPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([

                'message' => 'Utilisateur non trouvé',
            ]);
        } else {

            // Générer le token de réinitialisation de mot de passe
            $token = Password::createToken($user);

            // Envoyer l'e-mail de réinitialisation de mot de passe
            Mail::to($user->email)->send(new ResetPasswordEmail($user, $token));
            return response()->json([
                'message' => 'Email envoyé avec succès',
            ]);
        }
    }


    // public function requestPassword(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if ($user == null) {
    //         return response()->json([
    //             'message' => 'Utilisateur non trouvé',
    //         ]);
    //     } else {
    //         $token = Password::createToken($user);
    //         $resetUrl = URL::to('/reset-password') . '?token=' . $token;

    //         $user->sendPasswordResetNotification($token);

    //         return response()->json([
    //             'message' => 'Email envoyé avec succès',
    //             'reset_url' => $resetUrl,
    //         ]);
    //     }
    // }
}