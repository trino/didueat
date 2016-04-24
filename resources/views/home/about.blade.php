@extends('layouts.default')
@section('content')
    <?php printfile("views/home/about.blade.php"); ?>
    <div class="container">
            <div class="row">
            <div class="card">
                <div class="col-md-12 m-t-1">
                    <h1>About Us</h1>

                    {{ DIDUEAT }} is an online service that helps hungry Canadians order delivery from local restaurants.
                    <br><br>
                    Having great local food delivered helps us all keep up with our busy
                    lives. By connecting you to local restaurants, we make your city's great food more accessible, opening up more
                    possibilities for food lovers and more business for local small business owners.
                    <br><br>
                    {{ DIDUEAT }}'s quickly expanding network is reaching our goal of making everyone's life a
                    little bit better. It's secure and easy to use, you'll wonder why you ever ordered over the phone.
                </div>
                </div>
        </div>
    </div>
@stop
