       @foreach ($restaurants_list as $value) 
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <h2>
                                <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">{!! $value->name !!} </a>
                            </h2>
                            <div class="clearfix"></div>
                            <div class="resturants-items margin-bottom-20">
                                <div class="margin-bottom-15">
                                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}">
                                        @if(!empty($value->logo)) 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/restaurants/'.$value->logo) }}">
                                        @else 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">    
                                        @endif
                                     </a>
                                </div>
                                <div class="rating-details">
                                    <strong>{!! $value->address !!}</strong>
                                    <ul class="blog-info">
                                        <li><i class="fa fa-map-marker"></i>{!! $value->address.' , '.$value->city.' , '.$value->province.' , '.$value->country !!}</li>
                                        <li><i class="fa fa-truck"></i>{!!  $value->delivery_fee.' , '.$value->minimum !!}</li>
                                        <li><i class="fa fa-tags"></i>{!! $value->phone !!}</li>
                                    </ul>
                                    <a href="{{ url('restaurants/'.$value->slug.'/menus') }}" class=" btn btn-success">Order Online</a>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                          <div style="display: none;" class="nxtpage">
                            <li class="next"><a href="{{$restaurants_list->nextPageUrl()}}" >Next &gt;&gt;</a></li>  
                        </div>