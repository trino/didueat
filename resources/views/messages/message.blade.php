<?php printfile("views/messages/message.blade.php"); ?>
@extends('layouts.default')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-0">
            @if($msg_type != "")
            <div class="note note-{{ $msg_type }}">
                <h1 class="block">{{ $msg_type }}!</h1>
                <p>
                    {!! $msg_desc !!}
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

@stop