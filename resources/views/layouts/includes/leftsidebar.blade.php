<div class="col-lg-3 hidden-md-down">
    @include('common.navbar_content')
</div>

<!--SCRIPT>
    was_small = false;

    $("#expand-header").show();

    $(window).resize(function () {
        resize();
    });
    $(document).ready(function () {
        resize();
    });

    function resize() {
        var width = $(window).width();
        var is_small = width <= 970;

        if (is_small != was_small) {
            width = $(".navbar-collapse").height();
            if ((is_small && width) || (!is_small && !width)) {
                $(".menu-toggler").trigger("click");
            }
        }
        was_small = is_small;
    }
</SCRIPT-->