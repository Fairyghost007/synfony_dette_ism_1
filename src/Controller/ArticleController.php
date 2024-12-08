<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleLibelleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;


class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleLibelleType::class);
        $form->handleRequest($request);

        $limit = 4;
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;

        if ($form->isSubmitted() && $form->isValid()) {
            $libelle = $form->get('libelle')->getData();

            $articles = $articleRepository->findBy(['libelle' => $libelle]);
            $totalArticles = count($articles);
            $totalPages = ceil($totalArticles / $limit);

            $articles = array_slice($articles, $offset, $limit);
        } else {
            $articles = $articleRepository->findPaginatedArticles($limit, $offset);
            $totalArticles = $articleRepository->count([]);
            $totalPages = ceil($totalArticles / $limit);
        }

        return $this->render('article/index.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
            'current_page' => $page,
            'total_pages' => $totalPages,
        ]);
    }

    #[Route('/article/store', name: 'articles.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $formArticle = $this->createForm(ArticleType::class, $article);
        $formArticle->handleRequest($request);

        if ($formArticle->isSubmitted() && $formArticle->isValid()) {
            // Persist the article
            $entityManager->persist($article);
            $entityManager->flush();

            // Optionally, you can add a flash message to confirm successful creation
            $this->addFlash('success', 'Article created successfully!');

            return $this->redirectToRoute('articles.index');
        }

        return $this->render('article/form.html.twig', [
            'formArticle' => $formArticle->createView(),
        ]);
    }
}
