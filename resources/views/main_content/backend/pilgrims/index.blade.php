@extends('layouts.backend')

@section('pageTitle', _lang('app.pilgrims'))
@section('breadcrumb')
<li><a href="{{url('admin')}}">{{_lang('app.dashboard')}}</a> <i class="fa fa-circle"></i></li>
<li><span> {{_lang('app.pilgrims')}}</span></li>

@endsection
@section('js')
<script src="{{url('public/backend/js')}}/pilgrims.js" type="text/javascript"></script>
@endsection
@section('content')
<style>
    .btn-qr{
        position: absolute; top: 50%; left: 50%; margin-left: -90px; margin-top: -62px;padding: 32px 0 0;height: 110px; min-width: 190px;
    }
</style>
<div class="modal fade" id="addEditPilgrims" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="addEditPilgrimsLabel"></h4>
            </div>

            <div class="modal-body">


                <form role="form"  id="addEditPilgrimsForm"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="0">
                    <div class="form-body">
                        <div class="form-group form-md-line-input col-md-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{_lang('app.name')}}">
                            <label for="name">{{_lang('app.name')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input col-md-6">
                            <input type="text" class="form-control" id="nationality" name="nationality" placeholder="{{_lang('app.nationality')}}">
                            <label for="nationality">{{_lang('app.nationality')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input col-md-6">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{_lang('app.mobile')}}">
                            <label for="number">{{_lang('app.mobile')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input col-md-6">
                            <input type="text" class="form-control" id="ssn" name="ssn" placeholder="{{_lang('app.ssn')}}">
                            <label for="number">{{_lang('app.ssn')}}</label>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group form-md-line-input col-md-6">
                            <input type="number" class="form-control" id="reservation_no" name="reservation_no" placeholder="{{_lang('app.reservation_no')}}">
                            <label for="reservation_no">{{_lang('app.reservation_no')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input col-md-6">
                            <select class="form-control" id="location" name="location">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                @foreach ($locations as $key => $value)
                                <option value = "{{$value->id}}">{{$value->title}}</option>
                                @endforeach
                            </select>
                            <label for = "location">{{_lang('app.location')}}</label>
                            <span class="help-block"></span>  
                        </div>
                        <div class="form-group form-md-line-input col-md-6">
                            <select class="form-control" id="pilgrim_class" name="pilgrim_class">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                @foreach ($pilgrims_class as $key => $value)
                                <option value = "{{$value->id}}">{{$value->title}}</option>
                                @endforeach
                            </select>
                            <label for = "pilgrim_class">{{_lang('app.pilgrim_class')}}</label>
                            <span class="help-block"></span>  
                        </div>
                        <div class = "form-group form-md-line-input col-md-6">
                            <select class = "form-control" id = "gender" name = "gender">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                <option value = "1">{{_lang('app.male')}}</option>
                                <option value = "2">{{_lang('app.female')}}</option>

                            </select>
                            <label for = "gender">{{_lang('app.gender')}}</label>
                            <span class="help-block"></span>  

                        </div>
                        <div class = "form-group form-md-line-input col-md-6">
                            <select class = "form-control" id = "active" name = "active">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                <option value = "1">{{_lang('app.active')}}</option>
                                <option value = "0">{{_lang('app.not_active')}}</option>

                            </select>
                            <label for = "active">{{_lang('app.status')}}</label>
                            <span class="help-block"></span>  

                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">{{_lang('app.image')}}</label>

                            <div class="image_box">
                                <img src="{{url('no-image.png')}}" width="100" height="80" class="image" />
                            </div>
                            <input type="file" name="image" id="image" style="display:none;">     
                            <span class="help-block"></span>             
                        </div>
                        <div class="clearfix"></div>



                    </div>


                </form>

            </div>

            <div class = "modal-footer">
                <span class = "margin-right-10 loading hide"><i class = "fa fa-spin fa-spinner"></i></span>
                <button type = "button" class = "btn btn-info submit-form"
                        >{{_lang("app.save")}}</button>
                <button type = "button" class = "btn btn-white"
                        data-dismiss = "modal">{{_lang("app.close")}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="importPilgrims" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="importPilgrimsLabel"></h4>
            </div>

            <div class="modal-body">
                <!--                <div class="generate-qr-box" style="height:180px;">
                                    <a href="javascript:;" class="icon-btn btn-qr">
                                        <i class="fa fa-thumbs-up"></i>
                                        <div>
                                            Feedback
                                        </div>
                                        <span class="badge badge-info">
                                            2 </span>
                                    </a> 
                                </div>-->
                <form role="form"  id="importPilgrimsForm"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-body">


                        <div class="form-group form-md-line-input">
                            <select class="form-control edited" id="location" name="location">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                @foreach ($locations as $key => $value)
                                <option value = "{{$value->id}}">{{$value->title}}</option>
                                @endforeach
                            </select>
                            <label for = "location">{{_lang('app.location')}}</label>
                            <span class="help-block"></span>  
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control edited" id="pilgrim_class" name="pilgrim_class">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                @foreach ($pilgrims_class as $key => $value)
                                <option value = "{{$value->id}}">{{$value->title}}</option>
                                @endforeach
                            </select>
                            <label for = "pilgrim_class">{{_lang('app.pilgrim_class')}}</label>
                            <span class="help-block"></span>  
                        </div>
                        <div class = "form-group form-md-line-input">
                            <select class = "form-control edited" id = "gender" name = "gender">
                                <option value = "" selected>{{_lang('app.choose')}}</option>
                                <option value = "1">{{_lang('app.male')}}</option>
                                <option value = "2">{{_lang('app.female')}}</option>

                            </select>
                            <label for = "gender">{{_lang('app.gender')}}</label>
                            <span class="help-block"></span>  

                        </div>
                        <div class="form-group">
                            <label class="control-label">{{_lang('app.csv')}}</label>

                            <input type="file" name="file" id="file">     
                            <span class="help-block"></span>             
                        </div>
                        <div class="clearfix"></div>

                    </div>


                </form>

            </div>

            <div class = "modal-footer">
                <span class = "margin-right-10 loading hide"><i class = "fa fa-spin fa-spinner"></i></span>
                <button type = "button" class = "btn btn-info submit-form"
                        >{{_lang("app.save")}}</button>
                <button type = "button" class = "btn btn-white"
                        data-dismiss = "modal">{{_lang("app.close")}}</button>
            </div>
        </div>
    </div>
</div>
<form method="" id="filter-reports">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ _lang('app.filter_by') }}</h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="col-sm-3 inputbox utbox control-label">{{_lang('app.locations')}}</label>
                    <div class="col-sm-9 inputbox">
                        <select class="form-control" name="location" id="location">
                            <option value="">{{_lang('app.choose')}}</option>
                            @foreach($locations as $one)
                            <option {{ (isset($location) && $location==$one->id) ?'selected':''}} value="{{$one->id}}">{{$one->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-6">
                    <label class="col-sm-3 inputbox utbox control-label">{{_lang('app.class')}}</label>
                    <div class="col-sm-9 inputbox">
                        <select class="form-control" name="pilgrim_class" id="pilgrim_class">
                            <option value="">{{_lang('app.choose')}}</option>
                            @foreach($pilgrims_class as $one)
                            <option {{ (isset($pilgrim_class) && $pilgrim_class==$one->id) ?'selected':''}} value="{{$one->id}}">{{$one->title}}</option>
                            @endforeach


                        </select>
                    </div>
                </div>
              
                <div class="form-group col-md-6">
                    <label class="col-sm-3 inputbox utbox control-label">{{ _lang('app.code') }}</label>
                    <div class="col-sm-9 inputbox">

                        <input type="text" class="form-control" placeholder=""  name="code" value="{{ (isset($code)) ? $code :'' }}">

                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-sm-3 inputbox utbox control-label">{{ _lang('app.reservation_no') }}</label>
                    <div class="col-sm-9 inputbox">

                        <input type="text" class="form-control" placeholder=""  name="reservation_no" value="{{ (isset($reservation_no)) ? $reservation_no :'' }}">

                    </div>
                </div>

             
       



            </div>
            <!--row-->
        </div>
        <div class="panel-footer text-center">
            <button class="btn btn-info submit-form btn-report" type="submit">{{ _lang('app.apply') }}</button>
        </div>
    </div>
</form>
<div class = "panel panel-default">

    <div class = "panel-body">
        <!--Table Wrapper Start-->
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <a class="btn green" href="" onclick="Pilgrims.add(); return false;">{{ _lang('app.add_new')}}<i class="fa fa-plus"></i> </a>
                    </div>

                    <div class="btn-group">
                        <a class="btn blue" href="" onclick="Pilgrims.import(); return false;">{{ _lang('app.import_csv')}}</a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-warning" href="" onclick="Pilgrims.truncate(); return false;">{{ _lang('app.emptying')}}</a>
                    </div>
                </div>
            
            </div>
        </div>

        <table class = "table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
            <thead>
                <tr>
                    <th>{{_lang('app.name')}}</th>
                    <th>{{_lang('app.ssn')}}</th>
                    <th>{{_lang('app.reservation_no')}}</th>
                    <th>{{_lang('app.code')}}</th>
                    <th>{{_lang('app.country')}}</th>
                    <th>{{_lang('app.status')}}</th>
                    <th>{{_lang('app.accommodation_status')}}</th>
                    <th>{{_lang('app.pilgrim_card')}}</th>
                    <th>{{_lang('app.options')}}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <!--Table Wrapper Finish-->
    </div>
</div>
<script>
    var new_lang = {

    };
    var new_config = {

    };
    var filter = {
          location:"{{ (isset($location)) ? $location :false }}",
          pilgrim_class:"{{ (isset($pilgrim_class)) ? $pilgrim_class :false }}",
          code:"{{ (isset($code)) ? $code :false }}",
          reservation_no:"{{ (isset($reservation_no)) ? $reservation_no :false }}"
    };
</script>
@endsection