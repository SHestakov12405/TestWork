@extends('layouts.main')
<?php
    // dd($list);
?>
@section('content')

    <div class="alert d-none alert-success mt-2 alert-ok" role="alert">

    </div>
    <div class="alert d-none alert-danger mt-2 alert-no" role="alert">

    </div>
    <form class="formList">
        @csrf
        <div class="formLitsInput">
            @foreach ($list as $key => $listItem)
                <input class="form-control mt-2" required name="list" type="text" id="list" value="{{$listItem['name']}}" placeholder="Ведите название листа">
                    <button type="submit" class="addPoint btn border mb-2">Добавить поинт</button>

                @foreach ($listItem['points'] as $keyPoint => $pointItem)
                    <input class="point form-control mt-3" required name="point"  type="text" id="point{{$keyPoint}}" value="{{$pointItem['text']}}" placeholder="Ведите название поинта">
                    @if (array_key_exists('tags', $pointItem))


                        @foreach ($pointItem['tags'] as $tagKey => $tagItem)

                            <input class="form-control" name="point{{$keyPoint}}" type="text" id="tag{{$tagKey}}" value="{{$tagItem['name']}}"  placeholder="Ведите название тега">

                        @endforeach


                    @endif


                @endforeach


            @endforeach
            <div class="add mt-2">
                <button type="submit" class="addList btn btn-primary mb-2">Создать лист</button>
                <button type="submit" class="addPoint btn border mb-2">Добавить поинт</button>
                <button type="submit" class="addTag btn border mb-2">Добавить тег</button>
            </div>
        </div>
    </form>

@endsection

<script>
    let pointId = 0;
    let tagId = 1;
    let arr= {};
    document.addEventListener('DOMContentLoaded', function () {
     $(document).ready(function(){
        $('.addPoint').on('click',function(e) {
            e.preventDefault();
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            pointId = pointId + 1;
            $(".add").before(`<input class="point form-control mt-3" required name="point" type="text" id="point${pointId}" placeholder="Ведите название поинта">`)

        });

        $('.formList').on('change', 'input',function(e) {
            let y = 0
            if (e.target.name=="point") {
                console.log(e.target.id)
                arr[`${e.target.id}`] = {...arr[`${e.target.id}`],text:e.target.value};

            }else if(e.target.name=="list"){

            }else{


                if (typeof arr[`${e.target.name}`] === 'undefined'){
                    arr[`${e.target.name}`] = {text: $(`#${e.target.name}`).val()};

                    arr[`${e.target.name}`]['tag'] = {}
                    arr[`${e.target.name}`]['tag'][`${e.target.id}`] = e.target.value;
                    console.log(arr[`${e.target.value}`]['tag']);
                }else{

                    if(typeof arr[`${e.target.name}`]['tag'] === 'undefined'){

                        arr[`${e.target.name}`]['tag']={};
                        arr[`${e.target.name}`]['tag'][`${e.target.id}`] = e.target.value;

                    }else if (typeof arr[`${e.target.name}`]['text'] === 'undefined') {


                        arr[`${e.target.name}`]['text'] = $(`#${e.target.name}`).val();

                        arr[`${e.target.name}`]['tag'][`${e.target.id}`] = e.target.value;
                    }else{
                        arr[`${e.target.name}`]['tag'][`${e.target.id}`] = e.target.value
                    }
                    console.log(arr);
                }
                // if (arr[`${e.target.name}`] == 'undefined') {
                //     console.log('not')
                // }else{
                //     arr[`${e.target.name}`].tag = [...arr[`${e.target.name}`].tag, e.target.value];
                // }


                //----------------------------------------------------------
                // if (typeof arr[`${e.target.name}`] === 'undefined'){
                //     arr[`${e.target.name}`] = {text: $(`#${e.target.name}`).val()};
                //     arr[`${e.target.name}`]['tag'][`${e.target.id}`] = e.target.value;
                //     console.log(arr[`${e.target.value}`]['tag']]);
                // }else{

                //     if(arr[`${e.target.name}`]['tag'] === 'null'){
                //         arr[`${e.target.name}`] = {...arr[`${e.target.name}`], tag: [e.target.value]}
                //     }else if (arr[`${e.target.name}`].text === 'undefined') {
                //         arr[`${e.target.name}`].text = $(`#${e.target.name}`).val();
                //         arr[`${e.target.name}`].tag = [...arr[`${e.target.name}`].tag, e.target.value]
                //     }else{
                //         arr[`${e.target.name}`].tag = [...arr[`${e.target.name}`].tag, e.target.value]
                //     }
                //     console.log(arr);
                // }

                console.log(arr[`${e.target.name}`], e.target.name);
            }
            console.log(arr)
        });



        $('.addTag').on('click',function(e) {
            e.preventDefault();
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            $(".add").before(`<input class="form-control" name="point${pointId}" type="text" id="tag${tagId}" placeholder="Ведите название тега">`)
            tagId = tagId + 1
        });



        $('.addList').on('click',function(e) {
         e.preventDefault();

        $.ajax({
            url: "{{route('todo.update', $list['list']['id'])}}",
            type: 'POST',
            data: {
            _token: $("input[name='_token']").val(),
            list: $('#list').val(),
            point: arr,
            },
            dataType: 'json',
            success: function(result){
                console.log(result);
        }});


        //  $('.addListForm').remove();
        //  $(".listsContent").append('<button class="newListButton">Создать новый лист</button>')
        });
      });
    }, false);
</script>
