<?php 

namespace App\models;

//require_once 'BaseElement.php';

use Illuminate\Database\Eloquent\Model;

class Project extends Model{

	protected $table = 'projects';

	public function getDurationAsString() {

		  $years = floor($this->months / 12);
		  $extraMonths = $this->months % 12;

		  return "Project duration: $years years $extraMonths months";

		}
	
}