<?php

namespace App\Http\Controllers\Todo;

use App\Models\User;
use App\Models\TagPoint;
use App\Models\UserList;
use App\Models\PointList;
use Illuminate\Http\Request;
use App\Services\ListPointsService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use App\Services\GetUserListsService;
use App\QueryBuilders\ListQueryBuilder;
use App\QueryBuilders\UserQueryBuilder;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetUserListsService $getUserListsService, ListQueryBuilder $listQuerybuilder, UserQueryBuilder $userQueryBuilder)
    {
        // dd(Auth::user()->user_list()->get());
        $userLists = $getUserListsService->getUserLists();

        return view('todo.todo', [
            'lists' => Auth::user()->user_list()->paginate()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.todoCreate');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserList $userList, ListPointsService $listPoints)
    {

        $userList->name = $request->input('list');
        $userList->user()->associate(Auth::user()->id);
        if ($userList->save()) {

            $listPoints->pointsAndTagCreate($userList->id, $request->input('point'));
            return response()->json(['ok'=>'true', 'name' => $userList->name, 'point'=>$request->input('point')]);

        }else{
            return response()->json(['ok'=>'false']);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ListQueryBuilder $listQueryBuilder)
    {

        return  \view('todo.todoUpdate', [
            'list' => $listQueryBuilder->getOne($id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ListQueryBuilder $listQueryBuilder, ListPointsService $listPoints)
    {

        $list = $listQueryBuilder->getOne($id)->first();
        $listPoints->pointsDelete($list);

        $list->name = $request->input('list');
        $list->user()->associate(Auth::user()->id);

        if ($list->save()) {

            $listPoints->pointsAndTagCreate($list->id, $request->input('point'));

        }



        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ListQueryBuilder $listQueryBuilder)
    {
        $list = $listQueryBuilder->getOne($id)->first();
        $list->delete();
        return response()->json(['ok'=> true]);
    }
}
