@extends('layouts.main')
<?php
    // dd($lists);
?>
@section('content')

    <div class="alert d-none alert-success mt-2 alert-ok" role="alert">

    </div>
    <div class="alert d-none alert-danger mt-2 alert-no" role="alert">

    </div>
    <form class="formList">
        @csrf
        <div class="formLitsInput">
            <input class="form-control mt-2" required name="list" type="text" id="list" placeholder="Ведите название листа">
                <button type="submit" class="addPoint btn border mb-2">Добавить поинт</button>
            <div class="point0">
                <input class="point form-control mt-3" required name="point"  type="text" id="point0" placeholder="Ведите название поинта">
                <button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button>
                <div class="tag0">
                    <input class="form-control" name="point0" type="text" id="tag0" placeholder="Ведите название тега">
                    <button type="submit" class="deleteTag btn border mb-2">Удалить тег</button>
                </div>

            </div>

            <div class="add mt-2">
                <button type="submit" class="addList btn btn-primary mb-2">Создать лист</button>

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
        $(document).on('click', '.addPoint',function(e) {
            e.preventDefault();
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            pointId = pointId + 1;
            $('.add').before(`<div class="point${pointId}"><input class="point form-control mt-3" required name="point" type="text" id="point${pointId}" placeholder="Ведите название поинта"><button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button></div>`)

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



        $(document).on('click', '.addTag',function(e) {
            e.preventDefault();
            let pointClass = $(this).parent().attr("class");
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            $(`.${pointClass}`).append(`<div class="tag${tagId}"><input class="form-control" name="${pointClass}" type="text" id="tag${tagId}" placeholder="Ведите название тега"><button type="submit" class="deleteTag btn border mb-2">Удалить тег</button></div>`)
            tagId = tagId + 1


        });


        $(document).on('click', '.deleteTag',function(e) {
            e.preventDefault();
            let tagClass = $(this).parent().attr("class");
            //  $("addList").insertBefore("<p>blablablalblablab</p>");
            $(`.${tagClass}`).remove();

            for (let key of Object.keys(arr)) {
                if (arr[key]['tag'] !== 'undefined') {
                    if (arr[key]['tag'][tagClass] !== 'undefined') {
                        delete arr[key]['tag'][tagClass]
                    }
                }
            }


        });


        $(document).on('click', '.deletePoint',function(e) {
            e.preventDefault();

            let pointClass = $(this).parent().attr("class");
            $(`.${pointClass}`).remove();

            for (let key of Object.keys(arr)) {
                if (key === pointClass) {
                    delete arr[key]
                }
            }


        });


        $('.addList').on('click',function(e) {
         e.preventDefault();

        $.ajax({
            url: "{{route('todo.store')}}",
            type: 'POST',
            data: {
            _token: $("input[name='_token']").val(),
            list: $('#list').val(),
            point: arr,
            },
            dataType: 'json',
            success: function(result){
                if (result['ok']) {
                    $('.alert-ok').removeClass('d-none').append(`Лист "${result['name']}" успешно создан!`);
                    $('.formLitsInput').empty()
                    $('.formLitsInput').append(`
                    <input class="form-control mt-2" required name="list" type="text" id="list" placeholder="Ведите название листа">
                        <button type="submit" class="addPoint btn border mb-2">Добавить поинт</button>
                    <div class="point0">
                        <input class="point form-control mt-3" required name="point"  type="text" id="point0" placeholder="Ведите название поинта">
                        <button type="submit" class="addTag btn border mb-2">Добавить тег</button><button type="submit" class="deletePoint btn border mb-2">Удалить поинт</button>
                        <div class="tag0">
                            <input class="form-control" name="point0" type="text" id="tag0" placeholder="Ведите название тега">
                            <button type="submit" class="deleteTag btn border mb-2">Удалить тег</button>
                        </div>

                    </div>

                    <div class="add mt-2">
                        <button type="submit" class="addList btn btn-primary mb-2">Создать лист</button>

                    </div>
                    `);
                    pointId = 0;
                    tagId = 1;
                    arr= {};

                }else{
                    $('.alert-no').removeClass('d-none').append(`Лист не удалось создать!`);
                }
        }});


        //  $('.addListForm').remove();
        //  $(".listsContent").append('<button class="newListButton">Создать новый лист</button>')
        });
      });
    }, false);
</script>
