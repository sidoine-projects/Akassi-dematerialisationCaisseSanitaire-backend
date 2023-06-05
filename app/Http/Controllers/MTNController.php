<?php

namespace App\Http\Controllers;

use App\Services\MTNClient;
use Illuminate\Http\Request;

class MTNController extends Controller
{
    protected $mtnClient;

    public function __construct(MTNClient $mtnClient)
    {
        $this->mtnClient = $mtnClient;
    }

    public function makePayment(Request $request)
    {
        $payload = [
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency'),
            // Ajoutez les autres paramètres requis pour le paiement
        ];
        try {
            $response = $this->mtnClient->sendRequest('POST', '/collection/v1_0/requesttopay', $payload);

            // Traitez la réponse de l'API MTN
            // ...
        } catch (\Exception $e) {
            // Gérer les erreurs de requête
            // ...
        }
    }
}
