@extends('layouts.main')
<?php
    // dd($lists);
?>
@section('content')
    @empty($lists)
        <h1>Листов пока нет!</h1>
    @endempty



    <div id="allList" class="list-group mt-2 mb-2">

        @foreach ($lists['lists'] as $key => $list)
            <a href="{{ route('todo.show', $list['id']) }}" class="list-group-item list-group-item-action oneList mt-5 border p-2" aria-current="true">
                <div class="listItem d-flex w-100 justify-content-between">
                    <h5 class="mb-1 pl-3">{{$list['name']}}</h5>
                    <small>{{substr($list['created_at'], 0, 10)}}</small>
                </div>
                @foreach ($list['points'] as $keyP => $point)
                    <p class="listItem mb-1 pl-5 mt-4">{{$point['text']}}</p>
                    @if (array_key_exists('tags', $point))
                        @foreach ($point['tags'] as $tag)
                            <small class="listItem pl-5 ml-4">{{$tag['name']}}</small><br/>
                        @endforeach
                    @endif
                @endforeach
            </a>
        @endforeach

        </div>

@endsection


