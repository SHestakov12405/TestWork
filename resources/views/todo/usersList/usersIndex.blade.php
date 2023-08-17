@extends('layouts.main')
<?php
    // dd($lists);
?>
@section('content')
    <h1>Листы {{$name}}</h1>
    @empty($lists)
        <h1>Листов пока нет!</h1>
    @endempty

    <div class="input-group mt-4">
        <div class="form-outline">
          <input type="search" id="searchInput" class="form-control" placeholder="Поиск по тегу"/>
          <a href="{{route('edits.create')}}" class="btn btn-primary mt-2">Создать лист пользователю</a>
        </div>
    </div>



    <div id="allList" class="list-group mt-2 mb-2">
        @csrf
        @foreach ($lists as $key => $list)




            <a href="{{ route('edits.edit', $list['id']) }}" id='{{$list['id']}}' class="list-group-item list-group-item-action oneList mt-5 border p-2" aria-current="true">
                <div class="listItem d-flex w-100 justify-content-between">
                    <h5 class="mb-1 pl-3">{{$list['name']}}</h5>
                    <small>{{substr($list['created_at'], 0, 10)}}</small>
                </div>
                {{-- @foreach ($list as $keyP => $point) --}}
                    @foreach ($list->points as $point)
                        <p class="listItem mb-1 pl-5 mt-4">{{$point['text']}}</p>
                        @foreach ($point->tags as $tag)
                            <small class="listItem tagItem pl-5 ml-4">{{$tag['name']}}</small><br/>
                        @endforeach
                    @endforeach
                    {{-- @if (array_key_exists('tags', $point))
                        @foreach ($point['tags'] as $tag)
                            <small class="listItem pl-5 ml-4">{{$tag['name']}}</small><br/>
                        @endforeach
                    @endif --}}
                {{-- @endforeach --}}
                <button type="button" class="listDelete btn btn-outline-danger btn-sm mt-3 ml-3">Удалить лист</button>
            </a>
        @endforeach

        </div>
        {{$lists->links()}}
@endsection

<script>
    let listId = 0

    document.addEventListener('DOMContentLoaded', function () {
     $(document).ready(function(){



        $("#searchInput").on("keyup", function() {
            var  value = $(this).val().toLowerCase();
            $("#allList a").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        console.log();
        $(document).on('click', '.listDelete',function(e) {
            e.preventDefault();

            if ($(this).parent().attr("id")==='undefined') {
                listId = 0
            }else{
                listId = $(this).parent().attr("id");
            }

            let listDelete = confirm("Вы действительно хотите удалить лист?");

            if (listDelete) {


                $.ajax({
                url: `/edits/${listId}`,
                type: 'DELETE',
                data: {
                _token: $("input[name='_token']").val(),
                },
                dataType: 'json',
                success: function(result){
                    console.log(result);
                    if (result['ok']) {
                        location.reload();
                    }
                }});



            }
        });

      });
    }, false);
</script>




