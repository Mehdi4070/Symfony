<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ToDoController extends AbstractController
{

    #[Route('/todo', name: 'app_to_do')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todos')){
            $todos = [
                'achat' => 'Achter cle usb',
                'cours' => 'Finaliser mon cour',
                'correction' => 'Corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info',"La liste des todos viens d'etre initialisee");
        }

        return $this->render('to_do/index.html.twig');
    }
    #[Route('/todo/add/{name}/{content}', name: 'todo.add', defaults: ['content' => 'sf6'])]
    public function addToDo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name existe deja dans la liste");
            }else{
                $todos[$name] = $content;
                $this->addFlash("succee","le todo d'id $name a ete ajoutee avec succee");
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"la liste des todo n'est pas encore initialisee");
        }
        return $this->redirectToRoute('app_to_do');
    }

    #[Route('/todo/update/{name}/{content}', name: 'update.add')]
    public function updateToDo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name n'existe pas dans la liste");
            }else{
                $todos[$name] = $content;
                $this->addFlash("succee","le todo d'id $name a ete modifiee avec succee");
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"la liste des todo n'est pas encore initialisee");
        }
        return $this->redirectToRoute('app_to_do');
    }

    #[Route('/todo/delete/{name}', name: 'delete.add')]
    public function deleteToDo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todos')){
            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name n'existe pas dans la liste");
            }else{
                unset($todos[$name]);
                $this->addFlash("succee","le todo d'id $name a ete supprimee avec succee");
                $session->set('todos', $todos);
            }
        }else{
            $this->addFlash('error',"la liste des todo n'est pas encore initialisee");
        }
        return $this->redirectToRoute('app_to_do');
    }

    #[Route('/todo/reset', name: 'reset.add')]
    public function resetToDo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_to_do');

    }
}
