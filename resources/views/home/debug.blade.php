@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">
                <?php
                    printfile("views/home/debug.blade.php");
                    $filename = public_path("royslog.txt");
                    if (file_exists($filename) && isset($_GET["delete"])){
                        unlink($filename);
                    }
                    if (file_exists($filename)){
                        echo '<h4 class="card-title">Debug log<a class="btn btn-danger btn-sm" href="' . url("home/debug") . '?delete" style="float: right;" onclick="return confirm(' . "'Are you sure you want to delete the log file?'" . ');">Delete log file</a></h4>';
                        echo '<PRE style="width: 100%">' . file_get_contents($filename) . '</PRE>';
                    } else {
                        echo '<h4 class="card-title">Debug log</H4><PRE>Log file is empty</PRE>';
                    }
                ?>
            </div>
        </div>
    </div>
@stop