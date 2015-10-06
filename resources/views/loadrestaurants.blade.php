       @foreach ($restaurants_list as $value) 
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <h2>
                                <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}">{!! $value->Name !!} </a>
                            </h2>
                            <div class="clearfix"></div>
                            <div class="resturants-items margin-bottom-20">
                                <div class="margin-bottom-15">
                                    <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}">
                                        @if(!empty($value->Logo)) 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/restaurants/'.$value->Logo) }}">
                                        @else 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">    
                                        @endif
                                     </a>
                                </div>
                                <div class="rating-details">
                                    <strong>{!! $value->Address !!}</strong>
                                    <ul class="blog-info">
                                        <li><i class="fa fa-map-marker"></i>{!! $value->Address.' , '.$value->City.' , '.$value->Province.' , '.$value->Country !!}</li>
                                        <li><i class="fa fa-truck"></i>{!!  $value->DeliveryFee.' , '.$value->Minimum !!}</li>
                                        <li><i class="fa fa-tags"></i>{!! $value->Phone !!}</li>
                                    </ul>
                                    <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}" class=" btn btn-success">Order Online</a>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                          <div style="display: none;" class="nxtpage">
                            <li class="next"><a href="{{$restaurants_list->nextPageUrl()}}" >Next &gt;&gt;</a></li>  
                        </div>