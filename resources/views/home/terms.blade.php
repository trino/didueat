@extends('layouts.default')
@section('content')

    <div class="container">
    <?php printfile("views/home/terms.blade.php"); ?>
    @include('popups.terms'))
    </div>
@stop
