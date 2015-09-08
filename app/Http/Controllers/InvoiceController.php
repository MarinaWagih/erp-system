<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * number of results for each page in all && search
     * @var int
     * Number of pagination result
     */
    protected $pagination_No = 5;

    /**
     * Constructor
     * to add Middleware That needed to this controller
     *which are:
     *  1. user should be authenticated
     *  2. user should be admin if he/she going to delete,edit or add an item
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['delete']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = Invoice::paginate($this->pagination_No);
//        dd($invoices[0]->id);
        return view('invoice.all')->with(['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clients=Client::lists('name', 'id');
        return view('invoice.create')->with(['clients'=>$clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'installation' => 'required|min:0|max:1',
            'client_id' => 'required',
        ]);
        $invoice = new Invoice();
        $invoice->create($request->all());
        $items=$this->prepareItems($request->get('items'));
        $invoice->items()->sync($items);
//        return redirect('invoice/'.$invoice->id);
        return view('invoice.show')->with(['invoice' => $invoice]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            return view('invoice.show')->with(['invoice' => $invoice]);
        } else {
            return view('errors.Unauth')
                ->with(['msg' => 'variables.not_found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $invoice = Invoice::find($id);
        if ($invoice) {
            $clients=Client::lists('name', 'id');
            return view('invoice.edit')->with(['invoice' => $invoice,'clients'=>$clients]);
        } else {
            return view('errors.Unauth')
                ->with(['msg' => 'variables.not_found']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'installation' => 'required|min:0|max:1',
            'client_id' => 'required',
        ]);
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->update($request->all());
            $items=$this->prepareItems($request->get('items'));
            $invoice->items()->sync($items);
            return view('invoice.show')->with(['invoice' => $invoice]);
        } else {
            return view('errors.Unauth')
                ->with(['msg' => 'variables.not_found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Invoice::destroy($id);
        return redirect('invoice');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $invoices = Invoice::where('id','like',$request->get('query')."%")
                       ->orWhere('date','like',$request->get('query')."%")
                       ->paginate($this->pagination_No);
        $result = $invoices->toArray();
        $result['render'] = $invoices->render();
        if ($request->get('type') == 'json') {
            return response()->json($result);
        }
        return view('invoice.all')->with(['invoices' => $invoices]);
    }

    /**
     * @param $items list of items in invoice
     * @return array of prepared array to sync in db
     */
    private function prepareItems($items)
    {
        $result=[];
//        foreach($items as $item)
//        {
//
//            $result[$item->id]=$item;
//        }
        return $result;
    }
}
