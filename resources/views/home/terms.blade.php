@extends('layouts.default')
@section('content')
    <div class="container">
    <?php printfile("views/home/terms.blade.php"); ?>
        <h4>{{ DIDUEAT  }} Terms of Use</h4><br>
    @include('popups.terms')
    </div>
@stop
