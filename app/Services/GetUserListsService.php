<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;


class GetUserListsService
{
    public function getUserLists()
    {
        $user = Auth::user();
        $lists = $user->user_list()->get();

        $array = [];
        foreach ($lists as $keyList => $list) {

            $array['lists'][$keyList]=$list->toArray();


            if (!empty($list->points()->get()->toArray())) {

                foreach ($list->points()->get() as $keyPoint => $point) {


                    $array['lists'][$keyList]['points'][$keyPoint]= $point->toArray();

                    if (!empty($point->tags()->get()->toArray())) {


                        foreach ($point->tags()->get() as $keyTags => $tag) {

                            $array['lists'][$keyList]['points'][$keyPoint]['tags'][$keyTags]= $tag->toArray();

                        }
                    }
                }
            }
        }


        return $array;
    }


    public function getUserList($id)
    {
        $user = Auth::user();
        $list = $user->user_list()->where('id', $id)->first();
        // dd($list->points()->get());

        $array = ['list' => ['id' => $id,'name'=>$list->name]];


            if (!empty($list->points()->get()->toArray())) {

                foreach ($list->points()->get() as $keyPoint => $point) {


                    $array['list']['points'][$keyPoint] = $point->toArray();

                    if (!empty($point->tags()->get()->toArray())) {


                        foreach ($point->tags()->get() as $keyTags => $tag) {

                            $array['list']['points'][$keyPoint]['tags'][$keyTags]= $tag->toArray();

                        }
                    }
                }

            }
        return $array;
    }
}
