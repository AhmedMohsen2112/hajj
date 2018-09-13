<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FrontController extends Controller {

    protected $lang_code;
    protected $User = false;
    protected $isUser = false;
    protected $_Request = false;
    protected $data = array();

    //protected $companyBranchUserPermissions = array();

    public function __construct() {
        
    }

    protected function _view($main_content, $type = 'front') {
        $main_content = "main_content/$type/$main_content";
        //dd($main_content);
        return view($main_content, $this->data);
    }

}
