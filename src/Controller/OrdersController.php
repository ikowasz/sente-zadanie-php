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
        $sort = $request->query->get('sort', self::$defaultSortBy);

        $this->validateSortParam($sort);

        $orders = $repo->findAll()
            ->sortBy($sort);

        return $this->render('orders/base.html.twig', [
            'rows' => self::$tableRows,
            'sort' => $sort,
            'orders' => $orders,
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