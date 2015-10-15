<div class="col-md-12 col-sm-12 col-xs-12">
    <table class="table table-bordered table-hover">
        <!--thead>
        <tr role="row" class="heading">
            <th width="1%">
                Image
            </th>

            <th width="8%">
                Sort Order
            </th>

            <th width="10%">
            </th>
        </tr>
        </thead-->
        <tbody>

        @foreach ($restaurants_list as $value)

            <tr>
                <td width="20%">

                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                        @if(!empty($value->logo))
                            <img style="width:100%;" class="img-responsive" alt=""
                                 src="{{ url('assets/images/restaurants/'.$value->id.'/thumb_'.$value->logo) }}">
                        @else
                            <img style="width:100%;" class="img-responsive" alt=""
                                 src="{{ url('assets/images/default.png') }}">
                        @endif
                    </a>
                </td>
                <td width="70%">
                    <h2>
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{!! $value->name !!} </a>
                    </h2>
                    <ul class="blog-info">
                        <li>
                            <i class="fa fa-map-marker"></i>{!! $value->address.' , '.$value->city.' , '.$value->province.' , '.$value->country !!}
                            <i class="fa fa-truck"></i>{!!  $value->delivery_fee.' , '.$value->minimum !!}<i class="fa fa-tags"></i>{!! $value->phone !!}</li>
                    </ul>


                <td width="10%">
                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}" class=" btn btn-success red">Order
                        Online</a></td>
                </td>
            </tr>


        @endforeach


        </tbody>
    </table>
</div>

<div style="display: none;" class="nxtpage">
    <li class="next"><a href="{{$restaurants_list->nextPageUrl()}}">Next &gt;&gt;</a></li>
</div>
