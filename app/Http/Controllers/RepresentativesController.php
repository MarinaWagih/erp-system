<?php

namespace App\Http\Controllers;

use App\Representative;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RepresentativesController extends Controller
{
    /**
     *
     */
    protected $pagination_No=5;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $representatives=User::where('type','representative')->paginate($this->pagination_No);
        return view('representative.all')->with(['representatives'
                                                    =>$representatives]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
//    public function create()
//    {
//
//        return view('representative.create');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
//    public function store(Request $request)
//    {
//        //
//        $this->validate($request,['name'=>'required',
//                                  'phone'=>'required|unique:representatives|min:11'
//                                   ]);
//        $representative = new Representative();
//        $representative->name = $request->get('name');
//        $representative->phone = $request->get('phone');
//        $representative->save();
//        return redirect('representative/' . $representative->id);
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
        $representative = User::find($id);
        if ($representative) {
            return view('representative.show')->with(['representative'=>$representative]);
        } else {
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
        $representative = User::find($id);
        if ($representative) {
            return view('representative.edit')->with(['representative' => $representative]);

        }else{
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
        $this->validate($request,['name'=>'required',
            'phone'=>'required|min:11'
        ]);
        $representative = User::find($id);
        if ($representative) {
            $representative->name = $request->get('name');
            $representative->phone = $request->get('phone');
            $representative->save();
            return redirect('representative/' . $representative->id);
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
        User::destroy($id);
        return redirect('representative');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $name=$request->get('query');
        $representatives = User::where('type','representative')
            ->where(
                function($query) use ($name){
                    $query->where('name', 'like', $name . "%")
                        ->orWhere('phone', 'like', '%' .$name . "%");
                })
            ->paginate($this->pagination_No);
        $result=$representatives->toArray();
        $result['render']=$representatives->render();
        if($request->get('type')=='json')
        {
            return response()->json($result);
        }
        return view('representative.all')->with(['representatives' => $representatives]);
    }
}
