<?php

namespace App\Http\Controllers\Todo;

use App\Models\User;
use App\Models\TagPoint;
use App\Models\UserList;
use App\Models\PointList;
use Illuminate\Http\Request;
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
    public function index(GetUserListsService $getUserListsService)
    {

        $userLists = $getUserListsService->getUserLists();

        return view('todo.todo', [
            'lists' => $userLists
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
    public function store(Request $request, UserList $userList)
    {

        $userList->name = $request->input('list');
        $userList->user()->associate(Auth::user()->id);
        if ($userList->save()) {

            foreach ($request->input('point') as $key => $value) {

                $newPointList = new PointList();
                $newPointList->text = $value['text'];
                $newPointList->userList()->associate($userList->id);

                if (array_key_exists('tag', $value)) {
                    if ($newPointList->save()) {

                        foreach ($value['tag'] as $key => $valueTag) {
                            // return response()->json(['tag'=>$valueTag]);
                            $newTagPoint = new TagPoint();
                            $newTagPoint->name = $valueTag;
                            $newTagPoint->pointList()->associate($newPointList->id);
                            $newTagPoint->save();
                        }
                    }
                }else{
                    if ($newPointList->save()) {
                        continue;
                    }

                }
            }
            return response()->json(['ok'=>'true', 'name' => $userList->name]);
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
    public function show($id, GetUserListsService $getUserListsService)
    {
        $userList = $getUserListsService->getUserList($id);

        return  \view('todo.todoUpdate', [
            'list' => $userList
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json(['id'=>$id, 'list'=>$request]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
