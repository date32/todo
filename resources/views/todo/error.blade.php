@extends('layouts.todo')

@section('todo')

@include('components.header', ['user' => $user])

<p>不正なアクセスです</p>
<p><a href="/todo/">マイページへ</a></p>
    
@endsection
