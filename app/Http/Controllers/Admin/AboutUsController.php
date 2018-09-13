<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BackendController;
use App\Models\Setting;
use App\Models\Supervisor;
use App\Models\SettingTranslation;
use DB;

class AboutUsController extends BackendController {

 
    private $rules = array(
    );

    public function index() {
        //dd('here');
        $this->data['settings'] = Setting::get()->keyBy('name');
        $this->data['settings']['about_text'] = json_decode($this->data['settings']['about_text']->value);
        //dd($this->data['settings']['about_text']);
        return $this->_view('about_us/index', 'backend');
    }

    public function store(Request $request) {

        $this->rules['setting.about_video_url'] = 'file|mimes:mp4|size:2500';
        $this->rules['setting.declarative_video_url'] = 'file|mimes:mp4|size:2500';
    
        $validator = Validator::make($request->all(), array_merge($this->rules, $this->lang_rules(['setting.about_text' => 'required'])));


        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }
        //dd($request->all());

        DB::beginTransaction();
        try {


            $setting = $request->input('setting');
            $data_update = [];
            foreach ($setting as $key => $value) {
                if ($key == 'about_text') {
                    $value=preg_replace("/\r|\n/", "", $value);
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
                $data_update['value'][] = [
                    'value' => $value,
                    'cond' => [['name', '=', "'$key'"]],
                ];
            }
            //dd($request->file('about_video_url'));
            if ($request->file('about_video_url')) {
                $value = Setting::upload_simple($request->file('about_video_url'), 'videos');
                $data_update['value'][] = [
                    'value' => $value,
                    'cond' => [['name', '=', "'about_video_url'"]],
                ];
            }
            if ($request->file('declarative_video_url')) {
                $value = Setting::upload_simple($request->file('declarative_video_url'), 'videos');
                $data_update['value'][] = [
                    'value' => $value,
                    'cond' => [['name', '=', "'declarative_video_url'"]],
                ];
            }
            $this->updateValues2('\App\Models\Setting', $data_update, true);
            DB::commit();
            return _json('success', _lang('app.updated_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }

}
