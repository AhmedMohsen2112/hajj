@extends('layouts.backend')

@section('pageTitle',_lang('app.rate_question'))
@section('breadcrumb')
<li><a href="{{url('admin')}}">{{_lang('app.dashboard')}}</a> <i class="fa fa-circle"></i></li>
<li><a href="{{url('admin/commen/')}}">{{_lang('app.rate_question')}}</a> <i class="fa fa-circle"></i></li>
<li><span> {{_lang('app.add_rate_question')}}</span></li>

@endsection

@section('js')
<script src="{{url('public/backend/js')}}/rate_question.js" type="text/javascript"></script>
@endsection
@section('content')
<form role="form"  id="addEditRateQuestionsForm" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="panel panel-default" id="addEditRateQuestions">
        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.basic_info') }}</h3>
        </div>
        <div class="panel-body">


            <div class="form-body">
                <input type="hidden" name="id" id="id" value="0">
                <div class="row">

                    @foreach ($languages as $key => $value)
                    <div class="col-md-4">
                        <div class="form-group form-md-line-input col-md-12">
                            <input type="text" class="form-control" id="title[{{ $key }}]" name="title[{{ $key }}]" value="">
                            <label for="title">{{_lang('app.title') }} {{ _lang('app. '.$value.'') }}</label>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
            </div>
            <!--Table Wrapper Finish-->
        </div>
        
    </div>


    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.answers') }}</h3>
        </div>
        <div class="panel-body">
            <a class="btn btn-primary add-answer">{{_lang('app.add')}}</a>
            <div class="form-body">

                <div class="table-scrollable" style="border:none;">
                    <table class="table" id="answers-table">
                        <tbody>            
                            {{--  @php $count=0 @endphp
                            @foreach($meal_toppings as $meal_topping)
                            <tr class="answer-one">
                                <td>
                                    <input type="text" class="form-control form-filter input-lg" style="width:25%;" name="answers[{{ $count }}]" value="{{ $meal_size->price }}">
                                    <select class="form-control edited" name="toppings[{{ $count }}][topping_id]">
                                        @foreach ($toppings as $topping)
                                        <option {{ $topping->id == $meal_topping->menu_section_topping_id ? 'selected' : '' }} value="{{ $topping->id }}">{{ $topping->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <a class="btn btn-danger remove-topping">{{_lang('app.remove')}}</a>
                                </td>
                            </tr>
                            @php $count++ @endphp
                            @endforeach  --}}
                        </tbody>
                    </table>
                </div>




            </div>

            <!--Table Wrapper Finish-->
        </div>

    </div>


    <div class="panel panel-default">

        <div class="panel-body">


            <div class="form-body">
                 <div class="form-group form-md-line-input col-md-6">
                    <input type="number" class="form-control" id="this_order" name="this_order" value="">
                    <label for="this_order">{{_lang('app.this_order') }}</label>
                    <span class="help-block"></span>
                </div>

                <div class="form-group form-md-line-input col-md-6">
                    <select class="form-control edited" id="active" name="active">
                        <option  value="1">{{ _lang('app.active') }}</option>
                        <option  value="0">{{ _lang('app.not_active') }}</option>
                    </select>
                    <label for="status">{{_lang('app.status') }}</label>
                    <span class="help-block"></span>
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

};

</script>
@endsection