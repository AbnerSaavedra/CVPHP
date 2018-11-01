<?php 

namespace App\Controller;

use App\Models\{Job, Project};

class AdminController extends BaseController{

    public function getIndex(){

		return $this->renderHTML('admin.twig');
    }
}