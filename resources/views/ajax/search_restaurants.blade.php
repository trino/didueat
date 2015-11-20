@foreach($query as $value)
    <?php $logo = ($value->logo != "") ? 'restaurants/'.$value->id .'/'. $value->logo : 'default.png'; ?>
    <div class="row startRow" id="{{ $start }}">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card row">
                <div class="card-image col-md-1 col-sm-1 col-xs-2">
                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                        <img class="img-responsive full-width" alt="" src="{{ asset('assets/images/' . $logo) }}">
                    </a>
                    <span class="card-title">{{ $value->name }}</span>
                </div>
                <div class="card-content col-md-7 col-sm-7 col-xs-12">
                    <p>
                        <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{{ $value->name }}</a>
                    </p>
                    <p>
                        {{ $value->address }}, {{ $value->city }}, {{ $value->province }}
                        , {{ select_field("countries", 'id', $value->country, 'name') }}
                        <BR> {{ $value->phone }}
                    </p>
                </div>
                <div class="card-action col-md-4 col-sm-4 col-xs-12">
                    <a class="red btn" href="{{ url('restaurants/'.$value->slug.'/menus') }}">{{ $value->name }} Pick-up Only</a>
                    {!! rating_initialize("static-rating", "restaurant", $value->id) !!}
                </div>
            </div>
        </div>
    </div>
@endforeach