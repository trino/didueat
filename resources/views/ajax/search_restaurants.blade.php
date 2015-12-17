<div id="restuarant_bar" class="restuarant-list">
    <div class="row">
        @if(isset($query) && $count > 0)
        @foreach($query as $value)
            <?php $logo = ($value['logo'] != "") ? 'restaurants/'.$value['id'] .'/'. $value['logo'] : 'default.png'; ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="new-layout-box">
                    <div class="row">
                      <div class="col-md-9">
                        <div class="new-layout-box-content">
                          <div class="restaurant-name">
                            <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}"><h2>{{ $value['name'] }}</h2></a>
                          </div>
                          <p class="box-des">
                              {{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }}, 
                              {{ select_field("countries", 'id', $value['country'], 'name') }}
                              <br />
                              {{ $value['phone'] }}
                          </p>  
                          <p><strong>Minimum Delivery:</strong> {{ $value['minimum'] }}</p>
                          <p><strong>Delivery Fee:</strong> {{ $value['delivery_fee'] }}</p>
                          <p><strong>Tags:</strong>
                          <?php 
                             $tag = $value['tags'];
                             $tags = explode(",", $tag);
                               for ($i=0; $i <= 4; $i++) { 
                                  if($i == 4){
                                    echo (isset($tags[$i]))?$tags[$i]:'';
                                   }else{
                                    echo (isset($tags[$i]))?$tags[$i].',':'';  
                                  }
                              }
                            ?>
                            </p>
                             
                          <a class="btn custom-default-btn" href="{{ url('restaurants/'.$value['slug'].'/menus') }}">{{ $value['name'] }} Pick-up Only</a>
                          <div class="row">
                              {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="menu-img">
                          <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}">
                            <div class="card-image">
                                <img class="img-responsive full-width" alt="" src="{{ asset('assets/images/' . $logo) }}">
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
        <div id="loadMoreBtnContainer">
        @if($hasMorePage > 0)
            <div class="row">
                <div class="col-md-12 col-md-offset-5">
                    <button id="loadingbutton" data-id="{{ $start }}" align="center" class="loadMoreRestaurants btn custom-default-btn" title="Load more restaurants...">Load More ...</button>
                    <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
                </div>
            </div>
        @endif
        <input type="hidden" id="countTotalResult" value="{{ $count }}" />
        </div>
    </div>
</div>
<img class='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>