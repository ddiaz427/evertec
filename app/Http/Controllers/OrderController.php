<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\OrderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Dnetix\Redirection\PlacetoPay;

class OrderController extends AppBaseController
{
    /** @var  OrderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        parent::__construct();
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     *
     * @param OrderDataTable $orderDataTable
     * @return Response
     */
    public function index(OrderDataTable $orderDataTable)
    {
        if(Auth::user()->is_customer == 0)
        {
            return $orderDataTable->render('orders.index');
        }
        else
        {
            return $orderDataTable->with(['user_id' => Auth::user()->id])->render('orders.index', ['user_id' => Auth::user()->id]);
        }
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param CreateOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        $order = $this->orderRepository->create($input);

        Flash::success('Orden guardado con éxito.');

        return redirect(route('orders.show', $order->id));
    }

    /**
     * Display the specified Order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->find($id);
        if (Auth::user()->id != $order->user_id)
        {
            abort(403);
        }
        if (empty($order)) {
            Flash::error('Orden no encontrada');

            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Payment process.
     *
     * @param  int              $id
     *
     * @return Response
     */
    public function pay($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Orden no encontrada');

            return redirect(route('orders.index'));
        }
        if ($order->status == $order::ORDER_PAYED)
        {
            abort(400);
        }
        if (Auth::user()->id != $order->user_id)
        {
            abort(403);
        }

        $placetopay = new PlacetoPay(config("placetopay"));

        $response = $placetopay->request([
            'payment' => [
                'reference' => $order->id,
                'description' => 'Pago Orden No '.$order->id,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->amount,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => route('orders.response', ['id' => $order->id]),
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ]);
        if ($response->isSuccessful()) {
            $order->update([
                'payment_id' => $response->requestId(),
                'payment_url' => $response->processUrl()
            ]);
    
            return redirect($response->processUrl());
        } else {
            $order->update([
                'status' => $order::ORDER_REJECTED
            ]);
            Flash::error('El pago de la orden fue rechazada, por favor intentelo mas tarde.');

            return redirect(route('orders.show', $order->id));
        }
    }

    /**
     * responde page to payment.
     *
     * @param  int              $id
     *
     * @return Response
     */
    public function response($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Orden no encontrada');

            return redirect(route('orders.index'));
        }

        if (Auth::user()->id != $order->user_id)
        {
            abort(403);
        }

        $placetopay = new PlacetoPay(config("placetopay"));

        $response = $placetopay->query($order->payment_id);
        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                $order->update(['status' => $order::ORDER_PAYED]);
                Flash::success('La orden fue pagada correctamente.');
            }
            if ($response->status()->isRejected()) {
                $order->update(['status' => $order::ORDER_REJECTED]);
                Flash::error('El pago de la orden fue rechazada, por favor intentelo mas tarde.');
            }
        }
        return redirect(route('orders.show', $order->id));
    }
}
