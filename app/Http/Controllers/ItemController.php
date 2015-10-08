<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * @var int
     * Number of pagination result
     */
    protected $pagination_No=5;
    /**
     * Constructor
     * to add Middleware That needed to this controller
     *which are:
     *  1. user should be authenticated
     *  2. user should be admin if he/she going to delete an item
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['except'=>['index','search','ajaxSearch',
                                    'show','search_by_id']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //

        $items=Item::paginate($this->pagination_No);
        return view('item.all')->with(['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,['name'=>'required']);
        $item=new Item($request->all());
        if($request->file('picture')!==null) {
            $imageName = $this->saveImg($request);
        }
        else{
            $imageName = '';
        }
        $item->picture=$imageName;
        $item->save();
        return redirect('item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        $item = Item::find($id);
        if ($item) {
            return view('item.show')->with(['item' => $item]);
        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $item = Item::find($id);
        if ($item) {
            return view('item.edit')->with(['item' => $item]);
        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,['name'=>'required']);
        $item = Item::find($id);
        if ($item) {
            $item->name=$request->get('name');
//            dd($request->file('picture'));
            if($request->file('picture')!==null)
            {
//                dd($request->file('picture'));
//                exit();
                unlink(base_path() . '/public/images/'.$item->picture);
                $item->picture=$this->saveImg($request);
            }
            $item->price_31_a=$request->get('price_31_a');
            $item->price_32_b=$request->get('price_32_b');
            $item->price_1050=$request->get('price_1050');
            $item->price_1250=$request->get('price_1250');
            $item->price_1034=$request->get('price_1034');
            $item->save();
            return redirect('item/'.$item->id);
        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        Item::destroy($id);
        return redirect('item');
    }
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $items = Item::where('name', 'like', $request->get('query') . "%")
            ->orWhere('code', 'like', '%'.$request->get('query')."%")
            ->paginate($this->pagination_No);
        $result=$items->toArray();
        $result['render']=$items->render();
        if($request->get('type')=='json')
        {
            return response()->json($result);
        }
        return view('item.all')->with(['items' => $items]);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearch(Request $request)
    {
        $price_type= $request->get('price_type');
        if($request->get('query')!==null) {
         $items =
             Item::select('id', 'name as text','picture',$price_type.' as price' )
                ->where('name', 'like', $request->get('query') . "%")
                ->orwhere('id', 'like', $request->get('query') . "%")
                ->get();
            return response()->json($items);
        }
        return response()->json([]);
    }
    public function search_by_id(Request $request)
    {
        $price_type= $request->get('price_type');
        if($request->get('query')!==null) {
            $items =
                Item::select('id', 'name as text','picture',$price_type.' as price' )
//                    ->where('name', 'like', $request->get('query') . "%")
                    ->where('id', '=', $request->get('query'))
                    ->get();
            return response()->json($items);
        }
        return response()->json([]);
    }
    /**
     * @param $request
     * @return string New img name
     */
    private function saveImg($request)
    {
        $imageName=rand(0,9999999999) .
            rand(0,9999999999) .rand(0,9999999999) .'.'.
        $request->file('picture')->getClientOriginalExtension();
        $request->file('picture')->move(
            base_path() . '/public/images/', $imageName
        );
        return $imageName;
    }


}
