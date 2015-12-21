<div class="col-md-12 col-sm-12 col-xs-12">
    <?php printfile("views/loadrestaurants.blade.php"); ?>
    <table class="table table-bordered table-hover">
        <tbody>
        @foreach ($restaurants_list as $value)
            <tr>
                <td width="10%">
                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                        @if(!empty($value->logo))
                            <img class="img-responsive full-width" alt="" src="{{ asset('assets/images/restaurants/'.$value->id.'/thumb_'.$value->logo) }}">
                        @else
                            <img class="img-responsive full-width" alt="" src="{{ asset('assets/images/default.png') }}">
                        @endif
                    </a>
                </td>
                <td width="80%">
                    <h2>
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{!! $value->name !!} </a>
                    </h2>
                    <ul class="blog-info">
                        <li>
                            <i class="fa fa-map-marker"></i>{!! $value->address.' , '.$value->city.' , '.$value->province.' , '. select_field("countries", 'id', $value->country, 'name') !!}
                            <i class="fa fa-truck"></i>{!!  $value->delivery_fee.' , '.$value->minimum !!}<i class="fa fa-tags"></i>{!! $value->phone !!}
                        </li>
                    </ul>
                <td width="10%">
                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}" class=" btn btn-success red">Order Online</a></td>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div style="display: none;" class="nxtpage">
    <li class="next"><a href="{{ $restaurants_list->nextPageUrl() }}">Next &gt;&gt;</a></li>
</div>