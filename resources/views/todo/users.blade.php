@extends('layouts.main')
<?php

?>
@section('content')

    <div class="mt-2 d-flex justify-content-center flex-wrap">
        @csrf
        @foreach ($users as $user)
            @if (Auth::user()->id === $user->id)
                {{-- {{dd($users, $user)}} --}}
                <div class="card m-2" style="width: 350px;">
                    <div class="card-body">
                        <h5 class="card-title">Вы</h5>
                        <p class="card-text">{{$user->email}}</p>
                        <a href="{{route('account')}}" class="btn-sm btn-primary">Профиль</a> <a href="{{route('todo.index')}}" class="btn-sm btn-primary">Мои листы</a>
                    </div>
                </div>

            @else

                <div class="card m-2" style="width: 350px;">
                    <div class="card-body">
                        <h5 class="card-title">{{$user->name}}</h5>
                        <p class="card-text">{{$user->email}}</p>
                        @if (array_search($user->id, array_column($giver, 'id')) !== false)
                            <button href="#" id="{{$user->id}}" class="delete btn-sm btn-primary">Удалить права</button>
                        @else
                            <button href="#" id="{{$user->id}}" class="add btn-sm btn-primary">Предоставить права</button>
                        @endif
                        @if (array_search($user->id, array_column($receiving, 'id')) !== false)
                            <a href="{{route('session.save', ['id' => $user->id])}}" class="btn-sm btn-primary">Редактировать</a>
                        @endif
                    </div>
                </div>

            @endif
        @endforeach


    </div>
@endsection

<script>

    document.addEventListener('DOMContentLoaded', function () {
     $(document).ready(function(){

        $(document).on('click', '.delete',function(e) {
            e.preventDefault();
            usersId = $(this).attr("id")

            $.ajax({
            url: `/users/${usersId}`,
            type: 'DELETE',
            data: {
            _token: $("input[name='_token']").val(),
            },
            dataType: 'json',
            success: function(result){
                console.log(result);
                location.reload();
            }});

        });


        $(document).on('click', '.add',function(e) {

            e.preventDefault();

            usersId = $(this).attr("id")

            $.ajax({
            url: `/users`,
            type: 'POST',
            data: {
            _token: $("input[name='_token']").val(),
            id:usersId
            },
            dataType: 'json',
            success: function(result){
                console.log(result);
                location.reload();
            }});

        });

      });
    }, false);
</script>
