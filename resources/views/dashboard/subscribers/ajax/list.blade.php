{{ printfile("views/dashboard/subscribers/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="modal clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editModelLabel">Newsletter</h4>
            </div>
            {!! Form::open(array('url' => 'subscribers/send', 'name'=>'editForm', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
            <!--<div id="ajaxloader"></div>-->
            <div class="modal-body" id="contents">
                <?= newrow(false, "Subject:"); ?>
                    <INPUT TYPE="TEXT" NAME="subject" CLASS="form-control" REQUIRED>
                </DIV></DIV>

                <?= newrow(false, "Contents:"); ?>
                    <TEXTAREA NAME="newsletter" CLASS="form-control" REQUIRED></TEXTAREA>
                </DIV></DIV>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" TITLE="Close" TITLE="Close">Close</button>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">Subscribers
                    <!--button type="button" class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel">
                        Send Message
                    </button-->
                </h4>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <thead>
                <tr>
                    <th width="10%">
                        <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                        ID
                        <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="60%">
                        <a class="sortOrder" data-meta="email" data-order="ASC" data-title="Email" title="Sort [Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Email
                        <a class="sortOrder" data-meta="email" data-order="DESC" data-title="Email" title="Sort [Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="created_at" data-order="ASC" data-title="Date" title="Sort [Date] ASC"><i class="fa fa-caret-down"></i></a>
                        Date
                        <a class="sortOrder" data-meta="created_at" data-order="DESC" data-title="Date" title="Sort [Date] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="12%">
                        <a class="sortOrder" data-meta="status" data-order="ASC" data-title="Status" title="Sort [Status] ASC"><i class="fa fa-caret-down"></i></a>
                        Status
                        <a class="sortOrder" data-meta="status" data-order="DESC" data-title="Status" title="Sort [Status] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                    @foreach($Query as $key => $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ date('d M, Y', strtotime($value->created_at)) }}</td>
                            <td>{{ ($value->status == 1)?"Active":"Inactive" }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2"><span class="text-muted">No Records</span></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">{!! $Pagination !!}    </div>
    @endif
</div>