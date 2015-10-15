@foreach($query as $value)
    <?php
    $logo = ($value->logo)?'restaurants/'.$value->logo:'default.png';
    ?>
    <tr id="{{ $start }}">
        <td width="10%">
            <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                <img style="width:100%;" class="img-responsive" alt="" src="{{ asset('assets/images/'.$logo) }}">
            </a>
        </td>
        <td width="80%">
            <h2>
                <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{{ $value->name }}</a>
            </h2>
            <ul class="blog-info">
                <li>
                    <i class="fa fa-map-marker"></i>{{ $value->address }}, {{ $value->city }}, {{ $value->province }}, {{ select_field("countries", 'id', $value->country, 'name') }}
                    <i class="fa fa-truck"></i>99 , 99<i class="fa fa-tags"></i>{{ $value->phone }}
                </li>
            </ul>
        </td>
        <td width="10%">
            <a href="{{ url('restaurants/'.$value->slug.'/menus') }}" class=" btn btn-success red">Order Online</a>
        </td>
    </tr>
@endforeach
