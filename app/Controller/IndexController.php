<?php 

namespace App\Controller;

use App\Models\{Job, Project};

class IndexController extends BaseController{

    public function indexAction(){

		$jobs = Job::all();
		$projects = Project::all();
		$lastname = "Saavedra";
		$name = "Abner ".$lastname;
		$limitMonths = 2400;
		
		return $this->renderHTML('index.twig', [
			'name' => $name,
			'jobs' => $jobs
		]);
    }
}