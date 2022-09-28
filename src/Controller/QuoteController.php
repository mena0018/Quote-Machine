<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    #[Route('/quote', name: 'quote_index')]
    public function index(): Response
    {
        $quotes = [
            ['content' => "Sire, Sire ! On en a gros !",
                'meta' => "Perceval, Livre II, Les Exploités"],
            ['content' => "[Dame Séli : Les tartes, la pêche, tout ça c'est du patrimoine] (Arthur, montrant la tarte) C'est du patrimoine ça ?",
                'meta' => "Arthur, Livre I, La tarte aux myrtilles"],
            ['content' => "Quoi, c'est parce que je préfère les hommes c'est ça ? A ce compte là faut virer Bohort aussi...",
                'meta' => "Edern, épisode pilotes,6 : Le Chevalier femme"],
            ['content' => "Don't f*ck with the Peaky Blinders !",
                'meta' => "Tommy Shelby Peaky Blinders"],
            ['content' => "Je viens de lui mettre une balle dans la tête…… Il m’a regardé de travers.",
                'meta' => "Tommy Shelby Peaky Blinders"],
        ];

        return $this->render('quote/index.html.twig', [
            'controller_name' => 'QuoteController',
            'quotes' => $quotes
        ]);
    }
}
