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
                        $doit=true;
                    }
                    if (file_exists($filename)){
                        echo '<h4 class="card-title">Debug log<a class="btn btn-danger btn-sm" href="' . url("home/debug") . '?delete" style="float: right;" onclick="return confirm(' . "'Are you sure you want to delete the log file?'" . ');">Delete log file</a></h4>';
                        echo '<PRE style="width: 100%">' . file_get_contents($filename) . '</PRE>';
                    } else {
                        echo '<h4 class="card-title">Debug log</H4><PRE>Log file is empty</PRE>';
                    }
                ?>
                <FORM METHOD="post">
                    <TEXTAREA NAME="hash" style="width:100%;" placeholder="Email hash verifier"><?php if(isset($_POST["hash"])){echo $_POST["hash"];} ?></textarea>
                    <?php
                        if(isset($_POST["hash"])){
                            $hash = hashtext($_POST["hash"]);
                            echo $hash;
                            if(isset($_POST["hash2"]) && $_POST["hash2"]){
                                echo iif($hash == trim($_POST["hash2"]), '<FONT COLOR="green"> is a match</FONT>', '<FONT COLOR="red"> is <B>NOT</B> a match</FONT>');
                            }
                            echo '<BR>';
                        }
                    ?>
                    <INPUT TYPE="text" name="hash2" placeholder="Hash to compare" value="<?php if(isset($_POST["hash2"])){echo $_POST["hash2"];} ?>">
                    <INPUT TYPE="submit" style="float: right;" class="btn btn-success" value="Verify Hash">
                    <DIV CLASS="clearfix"></DIV>
                </FORM>
            </div>
        </div>
    </div>
    @if(isset($_GET["delete"]))
        <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
        <SCRIPT>
            $( document ).ready(function() {
                var URL = window.location + "";
                URL = URL.replace("?delete", "");
                ChangeUrl("Debug Log", URL);
            });
        </SCRIPT>
    @endif
@stop