<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name}', name: 'hello_world')]
    public function index(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'name' => $name
        ]);
    }
}
