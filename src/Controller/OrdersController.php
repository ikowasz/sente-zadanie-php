<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    public static $defaultSortBy = 'ref';
    public static $allowSortBy = ['ref', 'symbol', 'regdate', 'sendDate'];
    public static $tableRows = ['ref', 'clientName', 'regdate', 'symbol', 'sendDate', 'invoiced'];

    #[Route('/orders', name: 'orders_index')]
    public function index(OrderRepository $repo, Request $request): Response
    {
        $sortBy = $request->query->get('sort_by', self::$defaultSortBy);

        $this->validateSortParam($sortBy);

        $orders = $repo->findAll()->sortBy($sortBy);

        return $this->render('orders/index.html.twig', [
            'availableSort' => self::$allowSortBy,
            'rows' => self::$tableRows,
            'sortBy' => $sortBy,
            'orders' => $orders,
            'query' => '',
        ]);
    }

    #[Route('/orders/search', name: 'orders_search')]
    public function search(OrderRepository $repo, Request $request): Response
    {
        $queryText = $request->query->get('q');
        $order = $repo->findBySymbolOrRef($queryText);

        if (!is_null($order)) {
            return $this->render('orders/index.html.twig', [
                'availableSort' => [],
                'rows' => self::$tableRows,
                'sortBy' => '',
                'orders' => [$order],
                'query' => $queryText,
            ]);
        }

        return $this->render('orders/not_found.html.twig', ['query' => $queryText]);
    }

    /**
     * Check if given stort parameter is allowed
     *
     * @throws HttpException
     * @param string $param
     * @return void
     */
    private function validateSortParam(string $param)
    {
        if (!in_array($param, self::$allowSortBy)) {
            throw new HttpException(400, "Sort parameter not allowed: $param");
        }
    }

}