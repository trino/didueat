<?php

// My common functions
function message($msgtype, $description) {
    if ($msgtype != "" && $description != "") {
        return '<script type="text/javascript">
                        $(document).ready(function() {
                            Command: toastr["' . $msgtype . '"]("' . $description . '")
                            toastr.options = {
                                "closeButton": true,
                                "debug": true,
                                "newestOnTop": true,
                                "progressBar": true,
                                "positionClass": "toast-bottom-left",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        });
                        </script>';
    }
}

function select_field($table, $column, $value, $getcol) {
    $query = DB::table($table)
            ->select($getcol)
            ->where($column, $value);

    if ($query->count() > 0) {
        return $query->first()->$getcol;
    }
}

function select_field_where($table, $where=array(), $getcol) {
    $query = DB::table($table)->select($getcol);
    foreach ($where as $key => $value) {
        $query->where($key, $value);
    }

    if ($query->count() > 0) {
        return $query->first()->$getcol;
    }
}
?>