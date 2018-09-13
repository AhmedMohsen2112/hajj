@extends('layouts.backend')

@section('pageTitle',_lang('app.edit_pilgrims_class'))

@section('breadcrumb')
<li><a href="{{url('admin')}}">{{_lang('app.dashboard')}}</a> <i class="fa fa-circle"></i></li>
<li><a href="{{route('pilgrims_class.index')}}">{{_lang('app.pilgrims_class')}}</a> <i class="fa fa-circle"></i></li>
<li><span> {{_lang('app.edit')}}</span></li>
@endsection


@section('js')
<script src="{{url('public/backend/js')}}/pilgrims_class.js" type="text/javascript"></script>
@endsection
@section('content')
<form role="form"  id="addEditPilgrimsClassForm" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.basic_info') }}</h3>
        </div>
        <div class="panel-body">


            <div class="form-body">
                <input type="hidden" name="id" id="id" value="{{ $pilgrim_class->id }}">
                <input type="hidden" name="supervisors[0][id]"  value="{{ $pilgrim_class->supervisor_id }}">
                <input type="hidden" name="supervisors[1][id]"  value="{{ $pilgrim_class->menna_supervisor_id }}">
                <input type="hidden" name="supervisors[2][id]"  value="{{ $pilgrim_class->arafa_supervisor_id }}">
                <input type="hidden" name="supervisors[3][id]"  value="{{ $pilgrim_class->muzdalfa_supervisor_id }}">
                <input type="hidden" name="supervisors[0][old_image]"  value="{{ $pilgrim_class->image }}">
                <input type="hidden" name="supervisors[1][old_image]"  value="{{ $pilgrim_class->menna_image }}">
                <input type="hidden" name="supervisors[2][old_image]"  value="{{ $pilgrim_class->arafa_image }}">
                <input type="hidden" name="supervisors[3][old_image]"  value="{{ $pilgrim_class->muzdalfa_image }}">

                @foreach ($languages as $key => $value)

                <div class="form-group form-md-line-input col-md-4">
                    <input type="text" class="form-control" id="title[{{ $key }}]" name="title[{{ $key }}]" value="{{ $pilgrim_class_translations["$key"] }}">
                    <label for="title">{{_lang('app.title') }} {{ _lang('app. '.$key.'') }}</label>
                    <span class="help-block"></span>
                </div>

                @endforeach
                <div class="form-group form-md-line-input col-md-3">
                    <input type="number" class="form-control" id="this_order" name="this_order" value="{{ $pilgrim_class->this_order }}">
                    <label for="this_order">{{_lang('app.this_order') }}</label>
                    <span class="help-block"></span>
                </div>

            </div>
        </div>


    </div>


    <div class="panel panel-default">

        <div class="panel-body">


            <div class="form-body">
               

         

            </div>
        </div>


    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.class_supervisor') }}</h3>
        </div>
        <div class="panel-body">

            <div class="form-body">
               



                <div class="form-group form-md-line-input col-md-5">
                    <input type="text" class="form-control" id="supervisor_name" name="supervisors[0][name]" value="{{ $pilgrim_class->name }}">
                    <label for="name">{{_lang('app.name') }}</label>
                    <span class="help-block"></span>
                </div>


                <div class="form-group form-md-line-input col-md-5">
                    <input type="text" class="form-control" id="supervisor_contact_numbers" name="supervisors[0][contact_numbers]" value="{{ $pilgrim_class->contact_numbers }}" placeholder="+966663635,+96651515156,....">
                    <label for="supervisor_contact_numbers">{{_lang('app.contact_numbers') }}</label>
                    <span class="help-block"></span>
                </div>
                 <div class="form-group col-md-2">
                    <label class="control-label">{{_lang('app.image')}}</label>

                    <div class="image_one_box">
                        <img src="{{url('public/uploads/supervisors').'/'.$pilgrim_class->image}}" width="100" height="80" class="image_one" />
                    </div>
                    <input type="file" name="supervisors[0][image]" id="image_one" style="display:none;">     
                    <span class="help-block"></span>             
                </div>

            </div>
        </div>

     


    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.locations_supervisors') }}</h3>
        </div>
        <div class="panel-body">

            <div class="form-body">



                <div class="col-md-12">
                    <h3>{{_lang('app.menna')}}</h3>
                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_name" name="supervisors[1][name]" value="{{ $pilgrim_class->menna_name }}">
                        <label for="name">{{_lang('app.name') }}</label>
                        <span class="help-block"></span>
                    </div>


                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_contact_numbers" name="supervisors[1][contact_numbers]" value="{{ $pilgrim_class->menna_contact_numbers }}" placeholder="+966663635,+96651515156,....">
                        <label for="supervisor_contact_numbers">{{_lang('app.contact_numbers') }}</label>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">{{_lang('app.image')}}</label>

                        <div class="image_two_box">
                            <img src="{{url('public/uploads/supervisors').'/'.$pilgrim_class->menna_image}}" width="100" height="80" class="image_two" />
                        </div>
                        <input type="file" name="supervisors[1][image]" id="image_two" style="display:none;">     
                        <span class="help-block"></span>             
                    </div> 
                </div>
                <div class="col-md-12">
                    <h3>{{_lang('app.arafa')}}</h3>
                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_name" name="supervisors[2][name]" value="{{ $pilgrim_class->arafa_name }}">
                        <label for="name">{{_lang('app.name') }}</label>
                        <span class="help-block"></span>
                    </div>


                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_contact_numbers" name="supervisors[2][contact_numbers]" value="{{ $pilgrim_class->arafa_contact_numbers }}" placeholder="+966663635,+96651515156,....">
                        <label for="supervisor_contact_numbers">{{_lang('app.contact_numbers') }}</label>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">{{_lang('app.image')}}</label>

                        <div class="image_three_box">
                            <img src="{{url('public/uploads/supervisors').'/'.$pilgrim_class->arafa_image}}" width="100" height="80" class="image_three" />
                        </div>
                        <input type="file" name="supervisors[2][image]" id="image_three" style="display:none;">     
                        <span class="help-block"></span>             
                    </div> 
                </div>
                <div class="col-md-12">
                    <h3>{{_lang('app.muzdalfa')}}</h3>
                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_name" name="supervisors[3][name]" value="{{ $pilgrim_class->muzdalfa_name }}">
                        <label for="name">{{_lang('app.name') }}</label>
                        <span class="help-block"></span>
                    </div>


                    <div class="form-group form-md-line-input col-md-5">
                        <input type="text" class="form-control" id="supervisor_contact_numbers" name="supervisors[3][contact_numbers]" value="{{ $pilgrim_class->muzdalfa_contact_numbers }}" placeholder="+966663635,+96651515156,....">
                        <label for="supervisor_contact_numbers">{{_lang('app.contact_numbers') }}</label>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">{{_lang('app.image')}}</label>

                        <div class="image_four_box">
                            <img src="{{url('public/uploads/supervisors').'/'.$pilgrim_class->muzdalfa_image}}" width="100" height="80" class="image_four" />
                        </div>
                        <input type="file" name="supervisors[3][image]" id="image_four" style="display:none;">     
                        <span class="help-block"></span>             
                    </div> 
                </div>
           


            </div>
        </div>

        <div class="panel-footer text-center">
            <button type="button" class="btn btn-info submit-form"
                    >{{_lang('app.save') }}</button>
        </div>


    </div>


</form>
<script>
var new_lang = {

};
var new_config = {
    action:"edit"
};

</script>
@endsection