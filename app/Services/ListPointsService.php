<?php

namespace App\Services;

use App\Models\TagPoint;
use App\Models\PointList;

class ListPointsService
{
    public function pointsDelete($list)
    {
        foreach ($list->points as $key => $point) {
            $point->delete();
        }
    }

    public function pointsAndTagCreate($idList, $pointsArray)
    {

        // Массив должен быть вида:
        //     [
        //         text: "Текст поинта",
        //         tag: [
        //             name: "Имя тега"
        //         ]
        //     ]

        //     Массив tag не обязателен

        if (!empty($pointsArray)) {

            foreach ($pointsArray as $key => $pointRequest) {

                $point = new PointList();
                $point->text = $pointRequest['text'];
                $point->userList()->associate($idList);
                if ($point->save()) {

                    if (array_key_exists('tag', $pointRequest)) {

                        foreach ($pointRequest['tag'] as $key => $tag) {

                            $newTagPoint = new TagPoint();
                            $newTagPoint->name = $tag;
                            $newTagPoint->pointList()->associate($point->id);
                            $newTagPoint->save();
                        }
                    }

                }
            }
        }
    }
}
