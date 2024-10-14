<?php

namespace App\Controller;

use App\Entity\Client; // Import the Client entity
use App\Entity\Users; // Import the Client entity
use App\Form\ClientType;
use App\Form\UserType;
use App\Form\ClientTelephoneType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    // #[Route('/clients', name: 'clients.index', methods: ['GET', 'POST'])]
    // public function index(ClientRepository $clientRepository): Response
    // {
    //     $clients = $clientRepository->findAll();
    //     return $this->render('client/index.html.twig', [
    //         'clients' => $clients,
    //     ]);
    // }
    // #[Route('/clients', name: 'clients.index', methods: ['GET', 'POST'])]
    // public function index(Request $request, ClientRepository $clientRepository): Response
    // {
    //     $form = $this->createForm(ClientTelephoneType::class);
        
    //     $clients = [];
    
        
    //     $form->handleRequest($request);
    
       
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $telephone = $form->get('telephone')->getData();
            
           
    //         $clients = $clientRepository->findBy(['telephone' => $telephone]); 
    //     } else {
    //         $clients = $clientRepository->findAll();
    //     }
    
    //     return $this->render('client/index.html.twig', [
    //         'form' => $form->createView(),
    //         'clients' => $clients,
    //     ]);
    // }

    // #[Route('/clients', name: 'clients.index', methods: ['GET', 'POST'])]
    // public function index(Request $request, ClientRepository $clientRepository): Response
    // {
    //     $form = $this->createForm(ClientTelephoneType::class);
        
    //     $form->handleRequest($request);
        
    //     // Pagination settings
    //     $limit = 2; // Number of clients per page
    //     $page = $request->query->getInt('page', 1); // Current page, defaults to 1
    //     $offset = ($page - 1) * $limit; // Offset calculation

    //     // Search functionality
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $telephone = $form->get('telephone')->getData();
    //         $clients = $clientRepository->findBy(['telephone' => $telephone]);
    //     } else {
    //         $clients = $clientRepository->findPaginatedClients($limit, $offset);
    //     }

    //     // Count total clients for pagination
    //     $totalClients = $clientRepository->count();
    //     $totalPages = ceil($totalClients / $limit);

    //     return $this->render('client/index.html.twig', [
    //         'form' => $form->createView(),
    //         'clients' => $clients,
    //         'current_page' => $page,
    //         'total_pages' => $totalPages,
    //     ]);
    // }

    #[Route('/clients', name: 'clients.index', methods: ['GET', 'POST'])]
public function index(Request $request, ClientRepository $clientRepository): Response
{
    $form = $this->createForm(ClientTelephoneType::class);
    $form->handleRequest($request);
    
    $limit = 4; 
    $page = $request->query->getInt('page', 1);
    $offset = ($page - 1) * $limit; 

    if ($form->isSubmitted() && $form->isValid()) {
        $telephone = $form->get('telephone')->getData();

        $clients = $clientRepository->findBy(['telephone' => $telephone]);
        
        $totalClients = count($clients); 
        $totalPages = ceil($totalClients / $limit);
        
        $clients = array_slice($clients, $offset, $limit);
    } else {
        $clients = $clientRepository->findPaginatedClients($limit, $offset);
        
        $totalClients = $clientRepository->count();
        $totalPages = ceil($totalClients / $limit);
    }

    return $this->render('client/index.html.twig', [
        'form' => $form->createView(),
        'clients' => $clients,
        'current_page' => $page,
        'total_pages' => $totalPages,
    ]);
}







    #[Route('/client/show/{id?}', name: 'client.show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    // #[Route('/client/search/telephone/{telephone}', name: 'client.searchClientByTelephone', methods: ['GET'])]
    // public function searchClientByTelephone(Request $request): Response
    // {
    //     $telephone = $request->query->get('tel');
    //     dd($telephone);
    //     return $this->render('client/index.html.twig', [
    //         'controller_name' => 'ClientController',
    //     ]);
    // }


    // #[Route('/client/store', name: 'clients.store', methods: ['GET','POST'])]
    // public function store(Request $request,EntityManagerInterface $entityManager): Response
    // {
    //     $client= new Client();
    //     $form =$this->createForm(ClientType::class, $client);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted()  && $form->isValid()){
    //         $client->setCreatedAt(new \DateTimeImmutable('now'));
    //         $client->setUpdatedAt(new \DateTimeImmutable('now'));
    //         $entityManager->persist($client);
    //         $entityManager->flush();
    //         return $this->redirectToRoute('clients.index');
    //     }
    //     // dd($form->createView());
    //     // dd($client);

    //     return $this->render('client/form.html.twig', [
    //         'formClient'=>$form->createView()
    //     ]);
        
    // }


    #[Route('/client/store', name: 'clients.store', methods: ['GET', 'POST'])]
public function store(Request $request, EntityManagerInterface $entityManager): Response
{
    $client = new Client();
    $user = new Users(); 
    $formClient = $this->createForm(ClientType::class, $client);
    $formUser = $this->createForm(UserType::class, $user);
    $formClient->handleRequest($request);

    if ($formClient->isSubmitted() && $formClient->isValid()) {
        $client->setCreatedAt(new \DateTimeImmutable('now'));
        $client->setUpdatedAt(new \DateTimeImmutable('now'));

        if ($request->request->get('creerCompte') === 'on') {
            $formUser->handleRequest($request); 
            if ($formUser->isSubmitted()) {
                    $user->setCreatedAt(new \DateTimeImmutable('now'));
                    $user->setUpdatedAt(new \DateTimeImmutable('now'));
                    $user->setBlocked(false); 
                    // dd($user);
                    dump($formUser->getData());
                    $entityManager->persist($user);
                    $client->setUsers($user); 
                    // dd($client);
            }
        }
        // dd($client);
        // dd($user);

        $entityManager->persist($client);
        $entityManager->flush();

        return $this->redirectToRoute('clients.index');
    }

    return $this->render('client/form.html.twig', [
        'formClient' => $formClient->createView(),
        'formUser' => $formUser->createView(), 
    ]);
}

    
}    