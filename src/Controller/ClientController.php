<?php

namespace App\Controller;

use App\Entity\Client; // Import the Client entity
use App\Entity\Users; 
use App\Entity\Dette; // Import the Client entity
use App\Form\ClientType;
use App\Form\UserType;
use App\Form\ClientTelephoneType;
use App\Form\DetteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
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

    #[Route('/client/store', name: 'clients.store', methods: ['GET', 'POST'])]
public function store(Request $request, EntityManagerInterface $entityManager): Response
{
    $client = new Client();
    $user = new Users(); 
    $formClient = $this->createForm(ClientType::class, $client);
    $formUser = $this->createForm(UserType::class, $user);
    $formClient->handleRequest($request);

    if ($formClient->isSubmitted() && $formClient->isValid()) {

        if ($request->request->get('creerCompte') === 'on') {
            $formUser->handleRequest($request); 
            if ($formUser->isSubmitted()) {
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

#[Route('/client/dettes/{id}', name: 'clients.dettes', methods: ['GET'])]
public function listDettes($id, ClientRepository $clientRepository): Response
{
    $client = $clientRepository->find($id);

    if (!$client) {
        throw $this->createNotFoundException('Client not found');
    }

    $dettes = $client->getDettes(); 
    $totalDette=count($dettes);
    $totalMontantDette = 0;
    foreach ($dettes as $dette) {
        $totalMontantDette += $dette->getMontant();
    }

    return $this->render('client/dettes.html.twig', [
        'client' => $client,
        'dettes' => $dettes,
        'totalDette' => $totalDette,
        'totalMontantDette' => $totalMontantDette
    ]);
}



#[Route('/client/dette/add/{id}', name:"clients.dette.add", methods: ['GET', 'POST'])]
public function addDette(Request $request, $id, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
{
    $client = $clientRepository->find($id);
    if (!$client) {
        throw $this->createNotFoundException('Client not found');
    }

    $dette = new Dette();
    $dette->setClient($client);

    $formDette = $this->createForm(DetteType::class, $dette);

    $formDette->handleRequest($request);

    if ($formDette->isSubmitted() && $formDette->isValid()) {
        $entityManager->persist($dette);
        $entityManager->flush();
        return $this->redirectToRoute('clients.dettes', ['id' => $id]);
    }

    return $this->render('dette/form.html.twig', [
        'formDette' => $formDette->createView(),
        'client' => $client
    ]);
}




    
}    