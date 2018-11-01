<?php 

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\models\Project;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'cursointroduccionphp',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

#Variables superglobales, ejemplos:
/*var_dump($_GET);
var_dump($_POST);*/

if (!empty($_POST)) {

	$job = new Project();
	$job->title = $_POST['title'];
	$job->description = $_POST['description'];
	$job->save();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add job</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
    crossorigin="anonymous">
</head>
<body>
<form action="addProject.php" method="POST">
	<h2>Add job</h2>
	<label for="title">Title</label>
	 <input type="text" name="title" id="title"><br>
	 <label for="title">Description</label>
	 <input type="text" name="description" id="description"><br>
	 <button type="submit">Save</button>
</form>
</body>
</html>