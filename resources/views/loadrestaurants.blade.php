@foreach ($restaurants_list as $value)

    <div class="col-md-3 col-sm-3 col-xs-12">

        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-puzzle font-grey-gallery"></i>
								<span class="caption-subject bold font-grey-gallery uppercase">
								            <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{!! $value->name !!} </a>
 </span>
                </div>
                <div class="tools">
                    <a href="" class="remove" data-original-title="" title="">
                    </a>
                </div>
            </div>
            <div class="portlet-body">

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">


                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                            @if(!empty($value->logo))
                                <img class="img-responsive" alt=""
                                     src="{{ url('assets/images/restaurants/'.$value->logo) }}">
                            @else
                                <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">
                            @endif
                        </a>
                    </div>

                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <ul class="blog-info">
                            <li>
                                <i class="fa fa-map-marker"></i>{!! $value->address.' , '.$value->city.' , '.$value->province.' , '.$value->country !!}
                            </li>
                            <li><i class="fa fa-truck"></i>{!!  $value->delivery_fee.' , '.$value->minimum !!}</li>
                            <li><i class="fa fa-tags"></i>{!! $value->phone !!}</li>
                        </ul>
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}" class=" btn btn-success red">Order
                            Online</a>
                    </div>


                </div>
            </div>
        </div>
        <!-- END GRID PORTLET-->
    </div>
@endforeach
<div style="display: none;" class="nxtpage">
    <li class="next"><a href="{{$restaurants_list->nextPageUrl()}}">Next &gt;&gt;</a></li>
</div>
