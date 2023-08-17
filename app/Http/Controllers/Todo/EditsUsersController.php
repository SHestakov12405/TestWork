<?php

namespace App\Http\Controllers\Todo;

use App\Models\UserList;
use Illuminate\Http\Request;
use App\Services\ListPointsService;
use App\Http\Controllers\Controller;
use App\QueryBuilders\ListQueryBuilder;
use App\QueryBuilders\UserQueryBuilder;

class EditsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserQueryBuilder $userQueryBuilder)
    {
        $user = $userQueryBuilder->getOne(session('userEntitlementsId'))->first();
        return \view('todo.usersList.usersIndex', [
            'lists' => $user->user_list()->paginate(),
            'name' => $user->name,
            'userId' => $user->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd(session('userEntitlementsId'));
        if ($request->session()->has('userEntitlementsId')) {
            return \view('todo.usersList.usersCreate');
        }
        return redirect()->route('users.index');
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
        $userList->user()->associate(session('userEntitlementsId'));
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
    public function show(int $id, Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request, ListQueryBuilder $listQueryBuilder)
    {
        if ($request->session()->has('userEntitlementsId')) {
            return  \view('todo.usersList.usersEdit', [
                'list' => $listQueryBuilder->getOne($id)->first()
            ]);
        }
        return redirect()->route('users.index');

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
        $list->user()->associate(session('userEntitlementsId'));

        if ($list->save()) {

            $listPoints->pointsAndTagCreate($list->id, $request->input('point'));

        }



        return redirect()->route('edits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, ListQueryBuilder $listQueryBuilder)
    {
        $list = $listQueryBuilder->getOne($id)->first();
        $list->delete();
        return response()->json(['ok'=> true]);
    }
}
