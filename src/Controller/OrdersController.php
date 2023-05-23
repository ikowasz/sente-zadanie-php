<?php

namespace App\Controller;

use App\Enum\SortDirection;
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
        $queryText = $request->query->get('q');
        $sortBy = $request->query->get('sort_by', self::$defaultSortBy);
        $sortOrder = $request->query->get('sort_order');
        $sortDirection = SortDirection::fromString($sortOrder);

        $this->validateSortParam($sortBy);

        $orders = empty($queryText) ? $repo->findAll() : $repo->findBySymbolOrRef($queryText);
        $orders = $orders->sortBy($sortBy, $sortDirection);

        return $this->render('orders/index.html.twig', [
            'availableSort' => self::$allowSortBy,
            'defaultOrder' => SortDirection::DEFAULT->value,
            'rows' => self::$tableRows,
            'sortBy' => $sortBy,
            'sortOrder' => $sortDirection->value,
            'orders' => $orders,
            'query' => $queryText,
        ]);
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
