<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var int
     * Number of pagination result
     */
    protected $pagination_No=10;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['except'=>['index']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return view('home.home');
    }

    /**
     * Display a listing of the resource.
     * with pagination
     * @return Response
     */
    public function user_all()
    {
        $users=User::paginate($this->pagination_No)
            ->setPath(url() . '/user');
        return view('auth.all')->with(['users'=>$users]);
    }

    /**
     * @param Request $request
     * find users by name /username /type
     * @return Response
     */
    public function user_search(Request $request)
    {
        $name=$request->get('query');
        $users = User::where('name', 'like', '%' .$name . "%")
            ->orWhere('email', 'like', '%' .$name . "%")
            ->orWhere('type', 'like', '%' .$name . "%")
            ->paginate($this->pagination_No)
            ->setPath(url() . '/user/search');
        $result=$users->toArray();
        $result['render']=$users->render();
        if($request->get('type')=='json')
        {
            return response()->json($result);
        }
        return view('auth.all')->with(['users' => $users]);
    }

    /**
     * Edit user name,username,type
     * @param $id
     * @return $this
     */
    public function user_edit($id)
    {
        $user=User::find($id);
        if($user)
        {
            return view('auth.edit')->with(['user' => $user]);

        }else{
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
        }

    }

    /**
     * submit of edit form
     * @param Request $request
     * @param $id
     * @return Redirect to User_all
     */
    public function user_update(Request $request,$id)
    {
        $this->validate($request,[
//            'name'=>'required',
            'email'=>'required'
        ]);
        $user = User::find($id);
        if ($user) {
            $new_data=
                [
                'email' => $request->get('email'),
                'password' =>$request->get('password')!==null?bcrypt($request->get('password')):$user->password,
                'type'=>$request->get('type')!==''?$request->get('type'):$user->type,
                'name' => $request->get('name')!==''?$request->get('name'):$user->email,
                ];
            $user->update($new_data);
            return redirect('/user');
        } else {
            return view('errors.Unauth')->with(['msg' => 'variables.not_found']);
        }
    }

    /**
     * delete user
     * @param $id
     * @return Redirect to user_all
     */
    public function user_delete($id)
    {
        User::destroy($id);
        return redirect('user');
    }
}
