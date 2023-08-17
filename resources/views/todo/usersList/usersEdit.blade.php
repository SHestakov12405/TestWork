@extends('layouts.main')
<?php

    if ($list->points->first() !== null) {
        foreach ($list->points as $key => $value) {
            $ids[] = $value['id'];
        }
        $id = max($ids);
    }else {
        $id = 1;
    }

?>
@section('content')

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-contrast alert-danger alert-dismissible" role="alert">
            <div class="message">
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                <strong>Danger!</strong> {{$error}}
            </div>
    </div>
    @endforeach
    @endif
    <div class="alert d-none alert-danger mt-2 alert-no" role="alert">

    </div>
    <form class="formList" method="post" enctype="multipart/form-data" action="{{route('edits.update', $list->id)}}">

        @csrf
        @method('put')
        <div class="formLitsInput">
            {{-- @foreach ($list as $item) --}}
        {{-- {{dd($item, $item->id)}} --}}

                <input class="listName form-control mt-2" required name="list" type="text" id="list" value="{{$list->name}}" placeholder="Ведите название листа">
                    <button type="submit" class="addPoint btn border mb-2">Добавить поинт</button>

                @foreach ($list->points as $keyPoint => $pointItem)
                {{-- {{dd($pointItem->id)}} --}}
                {{-- {{dd($pointItem)}} --}}
                {{-- <div class="point0">
                    <input class="point form-control mt-3" required name="point"  type="text" id="point0" placeholder="Ведите название поинта">
                    <button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button>
                    <div class="tag0">
                        <input class="form-control" name="point0" type="text" id="tag0" placeholder="Ведите название тега">
                        <button type="submit" class="deleteTag btn border mb-2">Удалить тег</button>
                    </div>

                </div> --}}
                {{-- {{dd($pointItem->id)}} --}}
                    <div class="point{{$pointItem->id}}">
                        <input class="point form-control mt-3" required name="point[point{{$pointItem->id}}][text]"  type="text" id="point{{$pointItem->id}}" value="{{$pointItem->text}}" placeholder="Ведите название поинта">
                        <button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button>


                            @foreach ($pointItem->tags as $tagKey => $tagItem)

                                <div>
                                    <input class="tag form-control" name="point[point{{$pointItem->id}}][tag][]" type="text" id="tag{{$tagItem->id}}" value="{{$tagItem->name}}"  placeholder="Ведите название тега">
                                    <button type="submit" class="deleteTag btn border mb-2">Удалить тег</button>

                                </div>
                            @endforeach

                    </div>


                @endforeach
            {{-- @endforeach --}}
            <div class="add mt-2">
                <button type="submit" class="saveList btn btn-primary mb-2">Сохранить лист</button>
            </div>
        </div>
    </form>

@endsection

<script>
    let pointId = +"{{$id}}" + 1;
    let tagId = 1;
    let arr= {};

    document.addEventListener('DOMContentLoaded', function () {
     $(document).ready(function(){

        $(document).on('click', '.addPoint',function(e) {
            e.preventDefault();
            //  $("addList").insertBefore("<p>blablablalblablab</p>");

            $('.add').before(`<div class="point${pointId}"><input class="point form-control mt-3" required name="point[point${pointId}][text]" type="text" id="point${pointId}" placeholder="Ведите название поинта"><button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button></div>`)
            pointId = pointId + 1;
        });




        $(document).on('click', '.addTag',function(e) {
            e.preventDefault();
            let pointClass = $(this).parent().attr("class");
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            $(`.${pointClass}`).append(`<div><input class="form-control" name="point[${pointClass}][tag][]" type="text" id="tag${tagId}" placeholder="Ведите название тега"><button type="submit" class="deleteTag btn border mb-2">Удалить тег</button></div>`)
            tagId = tagId + 1


        });


        $(document).on('click', '.deleteTag',function(e) {
            e.preventDefault();
            // let tagClass = $(this).parent().attr("class");
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            $(this).parent().remove()


        });


        $(document).on('click', '.deletePoint',function(e) {
            e.preventDefault();

            // let pointClass = $(this).parent().attr("class");
            $(this).parent().remove();


        });

      });
    }, false);
</script>
