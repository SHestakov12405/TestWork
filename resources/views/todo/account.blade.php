@extends('layouts.main')
<?php

?>
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-lg-4">
      <div class="card mt-4">
        <div class="card-body text-center">
          <div style="width: 60px; height:60px" class="bg-secondary center d-inline-block"></div>
          <h5 class="my-3">{{Auth::user()->name}}</h5>
          <p class="text-muted mb-1">{{Auth::user()->email}}</p>
          <div class="d-flex justify-content-center mt-2">
            <a href="{{route('account.logout')}}" class="btn btn-primary">Выйти</a>
           </div>
        </div>
      </div>
    </div>
</div>
@endsection


