<?php

namespace App\Infrastructure\Http;

use App\Application\order\GetPortfolioOrdersUseCase;
use App\Application\portfolio\AddPortfolioUseCase;
use App\Application\portfolio\GetPortfoliosUseCase;
use App\Application\portfolio\GetPortfolioUseCase;
use App\Application\portfolio\PutPortfolioUseCase;
use App\Service\PortfolioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/api/portfolios/{id}', name: 'app_api_portfolio', methods: ['get'])]
    public function portfolioApi(GetPortfolioUseCase $getPortfolioUseCase, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $id = (int) $request->get('id') ?? 0;
        $portfolio = $getPortfolioUseCase->execute($entityManager, $id);

        return new JsonResponse($portfolio, 200);
    }

    #[Route('/api/portfolios/{id}', name: 'app_api_portfolio_path_error', methods: ['patch'])]
    public function portfolioApiPatch(): Response
    {
        return new Response('', 405);
    }


    #[Route('/api/portfolios', name: 'app_api_all_portfolios')]
    public function portfoliosApi(GetPortfoliosUseCase $getPortfolioUseCase, EntityManagerInterface $entityManager): JsonResponse
    {
        $portfolios = $getPortfolioUseCase->execute($entityManager);

        return new JsonResponse($portfolios);
    }

    #[Route('/portfolio/{id}', name: 'app_portfolio_search', methods: ['get'])]
    public function index(GetPortfolioUseCase $getPortfolioUseCase, GetPortfolioOrdersUseCase $portfolioOrders, EntityManagerInterface $entityManager, Request $request): Response
    {
        $id = (int) $request->get('id') ?? 0;
        $portfolio = $getPortfolioUseCase->execute($entityManager, $id);
        $orders = $portfolioOrders->execute($entityManager, $id);

        return $this->render('portfolio/index.html.twig', [
            'portfolio' => $portfolio,
            'orders' => $orders
        ]);
    }

    #[Route('/portfolio-create', name: 'app_create_portfolio', methods: ['get'])]
    public function addPortfolio(AddPortfolioUseCase $addPortfolioUseCase, EntityManagerInterface $entityManager): Response
    {
        $portfolio = $addPortfolioUseCase->execute($entityManager);
        return $this->render('portfolio/portfolio-created.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    #[Route('/api/portfolios/{id}', name: 'app_put_portfolio', methods: ['put'])]
    public function putPorfolio(PutPortfolioUseCase $putPortfolioUseCase, EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = json_decode($request->getContent());
        $putPortfolioUseCase->execute($entityManager, $request->get('id'), $data);
        return new Response('', 200);
    }

}
