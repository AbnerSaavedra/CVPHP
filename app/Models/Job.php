<?php 

namespace App\models;

//require_once 'BaseElement.php';

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

	protected $table = 'jobs';

	/*public function __construct($title, $description){

		$newTitle = 'Job: '.$title;
		//$this->title = $newTitle;
		parent::__construct($newTitle, $description); //De manera explícita se solicitan los atributos de la clase padre.
		//De igual forma se puede acceder directamente con la palabra reservada $this siempre y cuando la propiedad sea público o protegido//
	}*/

    public function getDurationAsString() {

		  $years = floor($this->months / 12);
		  $extraMonths = $this->months % 12;

		  return "Job duration: $years years $extraMonths months";

		}

}
