<?php

namespace App\Http\Controllers;

use App\Client;
use App\Representative;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * @var int
     * Number of pagination result
     */
    protected $pagination_No=10;

    /**
     * Constructor
     * to add Middleware That needed to this controller
     *which are:
     *  1. user should be authenticated
     *  2. user should be admin if he/she going to delete a client
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     * with pagination
     * @return Response
     */
    public function index()
    {
        //
        if(Auth::user()->type=='representative')
        {
            $id=Auth::user()->id;
//            $rep=Representative::where(['user_id'=>$id])->take(1)->get();
//            dd($rep);
            $clients=Client::where(['representative_id'=>$id])
                ->paginate($this->pagination_No)
                ->setPath(url() . '/client');
        }
        else
        {
            $clients=Client::paginate($this->pagination_No)
                ->setPath(url() . '/client');
        }
        return view('client.all')->with(['clients'=>$clients]);

    }

    /**
     * Show the form for creating a new resource.
     * Request the create view
     * @return Response -> create view
     */
    public function create()
    {
        //
        $rep = User::where('type','representative')->lists('email', 'id');
        return view('client.create')->with(['representatives' => $rep]);
    }

    /**
     * Store a newly created resource in storage
     * @param  Request $request
     * 1.validate the request by the following rules:
     *      -> name is required
     *      -> address is required
     *      -> phone is required , unique and minimum characters: 12',
     *      -> trading_name is required
     *      -> trading_address is required
     *      -> date is required and should be formatted as a date
     *      -> representative_id is required
     * 2.create the Client and save it to DB
     * @return Response client profile
     */
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required',
                            'mobile'=>'required|unique:clients|min:11',
                            'representative_id'=>'required']);
        $client = new Client();
        $client->create($request->all());
        return redirect('client/' . $client->id);
    }

    /**
     * Display the specified Client.
     *
     * @param  int $id
     *
     * @return Response client Info
     */
    public function show($id)
    {
        $client = Client::find($id);

        $id=Auth::user()->id;
        if ($client)
        {
            if(Auth::user()->type=='representative')
            {
             if($id==$client->representative_id)
             {
                 return view('client.show')->with(['client' => $client]);
             }
              else
              {
                  return view('errors.Unauth')->with(['msg' => 'variables.unauthorized']);
              }
            }
            else
            {
                return view('client.show')->with(['client' => $client]);
            }
//            dd($client->representative);

        }
        else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
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
        $rep = User::where('type','representative')->lists('email', 'id');
        $client = Client::find($id);
        if ($client)
        {
            if(Auth::user()->type=='representative')
            {
                if($id==$client->representative_id)
                {
                    return view('client.edit')->with(['representatives' => $rep,
                        'client' => $client
                    ]);
                }
                else
                {
                    return view('errors.Unauth')->with(['msg' => 'variables.unauthorized']);
                }

            }
            else
            {
                return view('client.edit')->with(['representatives' => $rep,
                    'client' => $client
                ]);
            }

        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
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
        //
        $this->validate($request,[
            'name'=>'required',
//            'address'=>'required',
            'mobile'=>'required|min:11',
//            'mobile'=>'required|min:11',
//            'trading_name'=>'required',
//            'trading_address'=>'required',
//            'date'=>'required|date',
            'representative_id'=>'required']);
        $client = Client::find($id);
        if ($client)
        {

            if(Auth::user()->type=='representative')
            {
                if($id==$client->representative_id)
                {
                    $client->update($request->all());
                    return redirect('client/' . $client->id);
                }
                else
                {
                    return view('errors.Unauth')->with(['msg' => 'variables.unauthorized']);
                }

            }
            else
            {
                $client->update($request->all());
                return redirect('client/' . $client->id);
            }
        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
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
        //
        Client::destroy($id);
        return redirect('client');
    }

    public function search(Request $request)
    {
        $name=$request->get('query');
        if(Auth::user()->type=='representative')
        {
//            $rep=Representative::where(['user_id'=>Auth::user()->id])->take(1)->get();
//            dd(Auth::user()->id);
            $clients = Client::where('representative_id', '=', Auth::user()->id)
            ->where(function($query) use ($name){
                    $query->where('name', 'like', '%' .$name . "%")
                        ->orWhere('phone', 'like', '%' .$name . "%")
                        ->orWhere('mobile', 'like', '%' .$name . "%")
                        ->orWhere('trading_name', 'like', '%' .$name . "%")
                        ->orWhere('trading_address', 'like', '%' . $name . "%");

                })
                ->paginate($this->pagination_No)
                ->setPath(url() . '/client/search/'.$name);
        }
        else{
            $clients = Client::where('name', 'like','%' . $name . "%")
                        ->orWhere('phone', 'like', '%' .$name . "%")
                        ->orWhere('mobile', 'like', '%' .$name . "%")
                        ->orWhere('trading_name', 'like', '%' .$name . "%")
                        ->orWhere('trading_address', 'like', '%' . $name . "%")
                        ->paginate($this->pagination_No)
                        ->setPath(url() . '/client/search/'.$name);
        }

        $result=$clients->toArray();
        $result['render']=$clients->render();
        if($request->get('type')=='json')
        {
            return response()->json($result);
        }
        return view('client.all')->with(['clients' => $clients]);
    }
    public function search_query(Request $request,$query)
    {
        $name=$query;
        if(Auth::user()->type=='representative')
        {
           $clients = Client::where('representative_id', '=', Auth::user()->id)
            ->where(function($query) use ($name){
                    $query->where('name', 'like', '%' .$name . "%")
                        ->orWhere('phone', 'like', '%' .$name . "%")
                        ->orWhere('mobile', 'like', '%' .$name . "%")
                        ->orWhere('trading_name', 'like', '%' .$name . "%")
                        ->orWhere('trading_address', 'like', '%' . $name . "%");

                })
                ->paginate($this->pagination_No)
            ->setPath(url() . '/client/search/'.$name);
        }
        else{
            $clients = Client::where('name', 'like','%' . $name . "%")
                        ->orWhere('phone', 'like', '%' .$name . "%")
                        ->orWhere('mobile', 'like', '%' .$name . "%")
                        ->orWhere('trading_name', 'like', '%' .$name . "%")
                        ->orWhere('trading_address', 'like', '%' . $name . "%")
                        ->paginate($this->pagination_No)
                        ->setPath(url() . '/client/search/'.$name);
        }

        $result=$clients->toArray();
        $result['render']=$clients->render();
        if($request->get('type')=='json')
        {
            return response()->json($result);
        }
        return view('client.all')->with(['clients' => $clients]);
    }

    /**
     * select input data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearch(Request $request)
    {
//        dd($request->get('query'));
        if($request->get('query')!==null)
        {
            if(Auth::user()->type=='representative')
            {
                $id = Auth::user()->id;
//                $rep = Representative::where(['user_id' => $id])->take(1)->get();
                $clients=Client::select('id', 'name as text')
                    ->where('name', 'like', '%' .$request->get('query') . "%")
                    ->where('representative_id','=',$id)
                    ->get();
//                dd($clients);
            }
            else
            {
                $clients = Client::select('id', 'name as text')
                    ->where('name', 'like', '%' .$request->get('query') . "%")
                ->get();
             }
           return response()->json($clients);
        }
        return response()->json();
    }
}
