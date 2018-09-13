<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;
use App\Models\PilgrimClass;
use App\Models\PilgrimClassTranslation;
use App\Models\Supervisor;
use Validator;
use DB;

class PilgrimsClassController extends BackendController {

    private $rules = array(
        'this_order' => 'required',
        'supervisors.0.name' => 'required',
        'supervisors.0.contact_numbers' => 'required',
        'supervisors.0.image' => 'image|mimes:gif,png,jpeg|max:1000',
        'supervisors.1.name' => 'required',
        'supervisors.1.contact_numbers' => 'required',
        'supervisors.1.image' => 'image|mimes:gif,png,jpeg|max:1000',
        'supervisors.2.name' => 'required',
        'supervisors.2.contact_numbers' => 'required',
        'supervisors.2.image' => 'image|mimes:gif,png,jpeg|max:1000',
        'supervisors.3.name' => 'required',
        'supervisors.3.contact_numbers' => 'required',
        'supervisors.3.image' => 'image|mimes:gif,png,jpeg|max:1000',
    );

    public function __construct() {

        parent::__construct();
        $this->middleware('CheckPermission:pilgrims_class,open', ['only' => ['index']]);
        $this->middleware('CheckPermission:pilgrims_class,add', ['only' => ['store']]);
        $this->middleware('CheckPermission:pilgrims_class,edit', ['only' => ['show', 'update']]);
        $this->middleware('CheckPermission:pilgrims_class,delete', ['only' => ['delete']]);
    }

    public function index(Request $request) {
        return $this->_view('pilgrims_class/index', 'backend');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return $this->_view('pilgrims_class/create', 'backend');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $columns_arr = array(
            'title' => 'required|unique:pilgrims_class_translations,title'
        );
        $lang_rules = $this->lang_rules($columns_arr);
        $this->rules = array_merge($this->rules, $lang_rules);
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }
        DB::beginTransaction();
        try {
            $supervisors = $request->input('supervisors');
            $supervisors_ids = [];
            if (!empty($supervisors)) {
                foreach ($supervisors as $key => $one) {
                    $supervisor = new Supervisor;

                    $supervisor->name = $one['name'];
                    $supervisor->contact_numbers = $one['contact_numbers'];
                    if ($image = $request->file('supervisors.' . $key . '.image')) {
                        $supervisor->supervisor_image = Supervisor::upload($image, 'supervisors', true);
                    } else {
                        $supervisor->supervisor_image = 'default.png';
                    }

                    $supervisor->save();
                    $supervisors_ids[] = $supervisor->id;
                }
            }


            $pilgrim_class = new PilgrimClass;
            $pilgrim_class->this_order = $request->input('this_order');
            $pilgrim_class->supervisor_id = $supervisors_ids[0];
            $pilgrim_class->menna_supervisor_id = $supervisors_ids[1];
            $pilgrim_class->arafa_supervisor_id = $supervisors_ids[2];
            $pilgrim_class->muzdalfa_supervisor_id = $supervisors_ids[3];
            $pilgrim_class->save();

            $pilgrim_class_translations = array();

            foreach ($request->input('title') as $key => $value) {
                $pilgrim_class_translations[] = array(
                    'locale' => $key,
                    'title' => $value,
                    'pilgrims_class_id' => $pilgrim_class->id
                );
            }

            PilgrimClassTranslation::insert($pilgrim_class_translations);

            DB::commit();
            return _json('success', _lang('app.added_successfully'));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $find = PilgrimClass::find($id);

        if ($find) {
            return _json('success', $find);
        } else {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $pilgrim_class = PilgrimClass::join('supervisors as s1', 'pilgrims_class.supervisor_id', '=', 's1.id')
                ->join('supervisors as s2', 'pilgrims_class.menna_supervisor_id', '=', 's2.id')
                ->join('supervisors as s3', 'pilgrims_class.arafa_supervisor_id', '=', 's3.id')
                ->join('supervisors as s4', 'pilgrims_class.muzdalfa_supervisor_id', '=', 's4.id')
                ->where('pilgrims_class.id', $id)
                ->select(['pilgrims_class.id', 'pilgrims_class.this_order', 's1.name', 's1.contact_numbers', 's1.supervisor_image as image',
                    's2.name as menna_name', 's2.contact_numbers as menna_contact_numbers', 's2.supervisor_image as menna_image',
                    's3.name as arafa_name', 's3.contact_numbers as arafa_contact_numbers', 's3.supervisor_image as arafa_image',
                    's4.name as muzdalfa_name', 's4.contact_numbers as muzdalfa_contact_numbers', 's4.supervisor_image as muzdalfa_image',
                    's1.id as supervisor_id', 's2.id as menna_supervisor_id', 's3.id as arafa_supervisor_id', 's4.id as muzdalfa_supervisor_id'])
                ->first();

        if (!$pilgrim_class) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
        $this->data['pilgrim_class_translations'] = PilgrimClassTranslation::where('pilgrims_class_id', $id)->pluck('title', 'locale');

        $this->data['pilgrim_class'] = $pilgrim_class;

        return $this->_view('pilgrims_class/edit', 'backend');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $pilgrim_class = PilgrimClass::find($id);
        if (!$pilgrim_class) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
        $columns_arr = array(
            'title' => 'required|unique:pilgrims_class_translations,title,' . $id . ',pilgrims_class_id'
        );

        $lang_rules = $this->lang_rules($columns_arr);
        $this->rules = array_merge($this->rules, $lang_rules);
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }


        DB::beginTransaction();
        try {


            $pilgrim_class->this_order = $request->input('this_order');
            $pilgrim_class->save();

            $data_update = [];
            $supervisors = $request->input('supervisors');
            if (!empty($supervisors)) {
                foreach ($supervisors as $key => $one) {
                    $data_update['name'][] = [
                        'value' => $one['name'],
                        'cond' => [['id', '=', $one['id']]],
                    ];
                    $data_update['contact_numbers'][] = [
                        'value' => $one['contact_numbers'],
                        'cond' => [['id', '=', $one['id']]],
                    ];
                    if ($image = $request->file('supervisors.' . $key . '.image')) {
                        Supervisor::deleteUploaded('supervisors', $supervisors[$key]['old_image']);
                        $data_update['supervisor_image'][] = [
                            'value' => Supervisor::upload($image, 'supervisors', true),
                            'cond' => [['id', '=', $one['id']]],
                        ];
                    }else{
                        
                        $data_update['supervisor_image'][] = [
                            'value' => $supervisors[$key]['old_image'],
                            'cond' => [['id', '=', $one['id']]],
                        ];
                    }
                }
            }
     
            $this->updateValues2('\App\Models\Supervisor', $data_update, true);



            PilgrimClassTranslation::where('pilgrims_class_id', $pilgrim_class->id)->delete();

            $pilgrim_class_translations = array();
            foreach ($request->input('title') as $key => $value) {
                $pilgrim_class_translations[] = array(
                    'locale' => $key,
                    'title' => $value,
                    'pilgrims_class_id' => $pilgrim_class->id
                );
            }
            PilgrimClassTranslation::insert($pilgrim_class_translations);
            DB::commit();
            return _json('success', _lang('app.updated_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }
    public function update2(Request $request, $id) {
        $pilgrim_class = PilgrimClass::find($id);
        if (!$pilgrim_class) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
        $columns_arr = array(
            'title' => 'required|unique:pilgrims_class_translations,title,' . $id . ',pilgrims_class_id'
        );

        $lang_rules = $this->lang_rules($columns_arr);
        $this->rules = array_merge($this->rules, $lang_rules);
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }


        DB::beginTransaction();
        try {


            $pilgrim_class->this_order = $request->input('this_order');
            $pilgrim_class->save();

            $data_update = [];
            $supervisors = $request->input('supervisors');
            if (!empty($supervisors)) {
                foreach ($supervisors as $key => $one) {
                    $data_update['name'][] = [
                        'value' => $one['name'],
                        'cond' => [['id', '=', $one['id']]],
                    ];
                    $data_update['contact_numbers'][] = [
                        'value' => $one['contact_numbers'],
                        'cond' => [['id', '=', $one['id']]],
                    ];
                    if ($image = $request->file('supervisors.' . $key . '.image')) {
                        $data_update['supervisor_image'][] = [
                            'value' => Supervisor::upload($image, 'supervisors', true),
                            'cond' => [['id', '=', $one['id']]],
                        ];
                    }
                }
            }
            //dd($data_update);
            $this->updateValues3('\App\Models\Supervisor', $data_update, true);



            PilgrimClassTranslation::where('pilgrims_class_id', $pilgrim_class->id)->delete();

            $pilgrim_class_translations = array();
            foreach ($request->input('title') as $key => $value) {
                $pilgrim_class_translations[] = array(
                    'locale' => $key,
                    'title' => $value,
                    'pilgrims_class_id' => $pilgrim_class->id
                );
            }
            PilgrimClassTranslation::insert($pilgrim_class_translations);
            DB::commit();
            return _json('success', _lang('app.updated_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $pilgrim_class = PilgrimClass::find($id);
        if (!$pilgrim_class) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
        DB::beginTransaction();
        try {
            $pilgrim_class->delete();
            DB::commit();
            return _json('success', _lang('app.deleted_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            if ($ex->getCode() == 23000) {
                return _json('error', _lang('app.this_record_can_not_be_deleted_for_linking_to_other_records'), 400);
            } else {
                return _json('error', _lang('app.error_is_occured'), 400);
            }
        }
    }

    public function data(Request $request) {

        $pilgrims_class = PilgrimClass::Join('pilgrims_class_translations', 'pilgrims_class.id', '=', 'pilgrims_class_translations.pilgrims_class_id')
                ->where('pilgrims_class_translations.locale', $this->lang_code)
                ->select([
            'pilgrims_class.id', "pilgrims_class_translations.title", "pilgrims_class.this_order"
        ]);

        return \Datatables::eloquent($pilgrims_class)
                        ->addColumn('options', function ($item) {

                            $back = "";
                            if (\Permissions::check('pilgrims_class', 'edit') || \Permissions::check('pilgrims_class', 'delete')) {
                                $back .= '<div class="btn-group">';
                                $back .= ' <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> ' . _lang('app.options');
                                $back .= '<i class="fa fa-angle-down"></i>';
                                $back .= '</button>';
                                $back .= '<ul class = "dropdown-menu" role = "menu">';
                                if (\Permissions::check('pilgrims_class', 'edit')) {
                                    $back .= '<li>';
                                    $back .= '<a href="' . route('pilgrims_class.edit', $item->id) . '">';
                                    $back .= '<i class = "icon-docs"></i>' . _lang('app.edit');
                                    $back .= '</a>';
                                    $back .= '</li>';
                                }

                                if (\Permissions::check('pilgrims_class', 'delete')) {
                                    $back .= '<li>';
                                    $back .= '<a href="" data-toggle="confirmation" onclick = "PilgrimsClass.delete(this);return false;" data-id = "' . $item->id . '">';
                                    $back .= '<i class = "icon-docs"></i>' . _lang('app.delete');
                                    $back .= '</a>';
                                    $back .= '</li>';
                                }

                                $back .= '</ul>';
                                $back .= ' </div>';
                            }
                            return $back;
                        })
                        ->escapeColumns([])
                        ->make(true);
    }

}
