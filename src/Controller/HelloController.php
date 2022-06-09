<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name}', name: 'hello')]
    public function index(string $name): Response
    {
        return $this->render('Hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'name' => ''.$name.'',
        ]);
    }
}
