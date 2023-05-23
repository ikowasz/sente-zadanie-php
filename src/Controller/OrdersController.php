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
        $queryText = $request->query->get('q');

        $this->validateSortParam($sortBy);

        $orders = empty($queryText) ? $repo->findAll() : $repo->findBySymbolOrRef($queryText);
        $orders = $orders->sortBy($sortBy);

        if (count($orders) > 0) {
            return $this->render('orders/index.html.twig', [
                'availableSort' => self::$allowSortBy,
                'rows' => self::$tableRows,
                'sortBy' => $sortBy,
                'orders' => $orders,
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