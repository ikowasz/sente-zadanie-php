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
    /**
     * Default order property to sort table by
     *
     * @var string
     */
    private static string $defaultSortBy = 'ref';

    /**
     * Default sort direction
     *
     * @var string
     */
    private static string $defaultSortOrder = SortDirection::DEFAULT->value;

    /**
     * Order property names available as columns
     *
     * @var array
     */
    private static array $availableTableCols = ['ref', 'clientName', 'regdate', 'symbol', 'sendDate', 'invoiced'];
    
    /**
     * Order property names available for sorting
     *
     * @var array
     */
    private static array $sortableTableCols = ['ref', 'symbol', 'regdate', 'sendDate'];

    #[Route('/orders', name: 'orders_index')]
    public function index(OrderRepository $repo, Request $request): Response
    {
        $query = $request->query->get('q', '');
        $sortBy = $request->query->get('sort_by', self::$defaultSortBy);
        $sortOrder = $request->query->get('sort_order', self::$defaultSortOrder);

        if (!in_array($sortBy, self::$sortableTableCols)) {
            throw new HttpException(400, "Sort parameter not allowed: $sortBy");
        }

        $sortDirection = SortDirection::fromString($sortOrder);
        $orders = empty($query) ? $repo->findAll() : $repo->findBySymbolOrRef($query);
        $orders->sortBy($sortBy, $sortDirection);

        return $this->render('orders/index.html.twig', [
            'cols' => self::$availableTableCols,
            'sortableCols' => self::$sortableTableCols,
            'defaultSortOrder' => self::$defaultSortOrder,
            'sortBy' => $sortBy,
            'sortOrder' => $sortDirection->value,
            'orders' => $orders,
            'query' => $query,
        ]);
    }
}
