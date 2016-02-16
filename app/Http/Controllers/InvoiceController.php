<?php
namespace App\Http\Controllers;
use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{
    /**
     * number of results for each page in all && search
     * @var int
     * Number of pagination result
     */
    protected $pagination_No = 10;

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
        if(Auth::user()->type=='representative') {
            $id = Auth::user()->id;
//            $rep = Representative::where(['user_id' => $id])->take(1)->get();
            $invoices = Invoice::where('clients.representative_id','=',$id)
                ->join('clients','clients.id','=','invoices.client_id')
                ->paginate($this->pagination_No)
                ->setPath(url() . '/invoice');
        }
        else
        {
            $invoices = Invoice::paginate($this->pagination_No)
                ->setPath(url() . '/invoice');
        }
        return view('invoice.all')->with(['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
//        if(Auth::user()->type=='representative') {
////            $id = Auth::user()->id;
////            $rep = Representative::where(['user_id' => $id])->take(1)->get();
////            $clients=Client::where('representative_id','=',$rep[0]->id)->lists('name', 'id');
//        }
//        else
//        {
////             $clients=Client::lists('name', 'id');
//        }
        return view('invoice.create');
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
            'type' => 'required',
            'client_id' => 'required',
        ]);
        $invoice = Invoice::create($request->all());
//        dd($invoice->id);
        $items=$this->prepareItems($request->get('items'));
        $invoice->items()->sync($items);
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
            $id = Auth::user()->id;
            if(Auth::user()->type=='representative')
            {
                if($invoice->client->representative_id==$id)
                {
                    return view('invoice.show')->with(['invoice' => $invoice]);
                }
                else{
                    return view('errors.Unauth')->with(['msg' => 'variables.unauthorized']);
                }
            }
            else{
                return view('invoice.show')->with(['invoice' => $invoice]);
            }
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
        $invoice = Invoice::find($id);
        if ($invoice)
        {
            $id = Auth::user()->id;
            if(Auth::user()->type=='representative')
            {
                if($invoice->client->representative_id==$id)
                {
                    return view('invoice.edit')->with(['invoice' => $invoice]);
                }
                else
                {
                    return view('errors.Unauth')->with(['msg' => 'variables.unauthorized']);
                }
            }
            else
            {
//                $clients=Client::where('id','!=',$invoice->client->id)->get();
                return view('invoice.edit')->with(['invoice' => $invoice]);
            }
        }
        else
        {
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
            'type' => 'required',
            'client_id' => 'required',
        ]);
        $invoice = Invoice::find($id);
//        dd($request->get(''));
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
        $query=$request->get('query')!=null?$request->get('query'):'';
        $query_id=$request->get('query_id')!=null?$request->get('query_id'):'';
        $query_date=$request->get('query_date')!=null?$request->get('query_date'):'2015-01-01';
//        dd($query,$query_date,$query_id);
        if(Auth::user()->type=='representative') {
            $id = Auth::user()->id;
            $invoices = Invoice::select('invoices.*')->with('client')
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->where('clients.representative_id','=',$id)
                ->where('clients.name','like',$query."%")
                ->where('invoices.id','like',$query_id."%")
                ->Where('invoices.date','>=',$query_date)
                ->get();

//                ->paginate($this->pagination_No)
//                ->setPath(url() . '/invoice/search/'.$query.'/'.$query_id.'/'.$query_date);
        }
        else
        {
            $invoices =Invoice::select('invoices.*')->with('client')
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->where('clients.name','like',"%".$query."%")
                ->where('invoices.id','like',"%".$query_id."%")
                ->Where('invoices.date','>=',$query_date)
                ->get();
        }
        $result = $invoices->toArray();
//        $result['render'] = $invoices->render();
        if ($request->get('type') == 'json') {
            return response()->json($result);
        }
        return view('invoice.all')->with(['invoices' => $invoices]);
    }

    /**
    *public function search_query(Request $request,$query,$query_id,$query_date)
    *    {
    *        if(Auth::user()->type=='representative') {
    *            $id = Auth::user()->id;
    *            $rep = Representative::where(['user_id' => $id])->take(1)->get();
    *            $invoices = Invoice::where('clients.representative_id','=',$id)
    *                ->where('clients.name','like',$query."%")
    *                ->where('invoices.id','like',$query_id."%")
    *                ->orWhere('invoices.date','like',$query_date."%")
    *                ->join('clients', function($join)
    *                {
    *                    $join->on('clients.id', '=', 'invoices.client_id');
    *
    *                });
    *                ->paginate($this->pagination_No)
    *                ->setPath(url() . '/invoice/search/'.$query.'/'.$query_id.'/'.$query_date);
    *        }
    *        else
    *        {
    *            $invoices =Invoice::with('client')
    *                ->where('clients.name','like',$query."%")
    *                ->where('invoices.id','like',"%".$query_id."%")
    *                ->orWhere('invoices.date','>=',$query_date)
    *                ->join('clients', function($join)
    *                {
    *                    $join->on('clients.id', '=', 'invoices.client_id');
    *
    *                });
    *                ->paginate($this->pagination_No)
    *                ->setPath(url() . '/invoice/search/'.$query.'/'.$query_id.'/'.$query_date);        }
    *        $result = $invoices->toArray();
    *        $result['render'] = $invoices->render();
    *        if ($request->get('type') == 'json') {
    *            return response()->json($result);
    *        }
    *        return view('invoice.all')->with(['invoices' => $invoices]);
    *    }
    */

    /**
     * @param $items list of items in invoice
     * @return array of prepared array to sync in db
     */
    private function prepareItems($items)
    {
        $items= json_decode($items, true);
        return $items;
    }
}
