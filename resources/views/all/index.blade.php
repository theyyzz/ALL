@extends('layouts.top')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @guest
                <div class="panel-heading">你不先去登陆怎么玩</div>
                @else
                <div class="panel-heading"> {{ Auth::user()->name }}</div>
                @endguest
                <div class="panel-body">
                    <div class="panel-danger"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.end')



