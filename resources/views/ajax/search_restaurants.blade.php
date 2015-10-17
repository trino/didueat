







@foreach($query as $value)
    <?php
    $logo = ($value->logo)?'/'.$value->logo:'default.png';
    ?>
    <tr id="{{ $start }}">


<td>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="card small">
                    <div class="card-image">
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                            <img style="width:100%;" class="img-responsive" alt=""
                                 src="{{ asset('assets/images/restaurants/' . $value->id .'/'.$logo) }}">
                        </a> <span class="card-title">{{ $value->name }}</span>
                    </div>
                    <div class="card-content">
                        <p>
                            <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{{ $value->name }}</a>
                        </p>

                        <p>
                            {{ $value->address }}, {{ $value->city }}, {{ $value->province }}, {{ select_field("countries", 'id', $value->country, 'name') }}
                          <BR> {{ $value->phone }}
                        </p>
                    </div>
                    <div class="card-action">
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{{ $value->name }}</a>

                    </div>
                </div>
            </div>


</td>


    </tr>




@endforeach
