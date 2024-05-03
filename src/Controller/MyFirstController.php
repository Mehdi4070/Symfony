<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyFirstController extends AbstractController
{
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        // search users in the database
        return $this->render('template.html.twig', [
        ]);
    }

    #[Route('/myfirst', name: 'app_my_first')]
    public function index(): Response
    {
        // search users in the database
        return $this->render('my_first/index.html.twig', [
            'name' => 'Lahouimel',
            'firstname' => 'Mehdi'
        ]);
    }

//    #[Route('/sayHello/{name}', name: 'say.hello')]
    public function sayHello(\Symfony\Component\HttpFoundation\Request $request, $name): Response
    {
        //dd($request);
        return $this->render('my_first/hello.html.twig' ,
            ['name' => $name ,
             'path' => '     '
            ]);
    }

    #[Route('/multi/{entier1<\d+>}/{entier2<\d+>}',
    name: 'multiplication',
    //requirements: ['entier1' => '\d+', 'entier2' => '\d+']
    )]

    public function multi(int $entier1, int $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }

}
