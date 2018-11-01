<?php 

#FrontController: Patrón de diseño que sirve para brindar una puerta única de entrada a nuestra aplicación, centralizando código de configuracines importantes evitando repetición innecesaria.

ini_set('display_errors', 1);
ini_set('display_starup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();
use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

//use App\models\{Job, Project};

//Creamos la instancia del ORM manager.
$capsule = new Capsule;

//Configuramos la conexión.
$capsule->addConnection([
    'driver'    => getenv('DB_DRIVER'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

//Son capturadas las request en las variables superglobales.
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

//var_dump($request->getUri()->getPath());

//Creamos la instancia del contenedor de rutas.
$routerContainer = new RouterContainer();
//Creamos un mapa de rutas
$map = $routerContainer->getMap();
//Index
$map->get('index', '/curso-introduccion-php-platzi/', [
    'controller' => 'App\Controller\indexController',
    'action' => 'indexAction'
    ]);
//Jobs
$map->get('addJobs', '/curso-introduccion-php-platzi/addJob', [
    'controller' => 'App\Controller\jobController',
    'action' => 'getAddJobAction',
    'auth' => true,
    ]);
$map->post('saveJobs', '/curso-introduccion-php-platzi/saveJob', [
    'controller' => 'App\Controller\jobController',
    'action' => 'getAddJobAction'
    ]);
//Users
$map->get('addUsers', '/curso-introduccion-php-platzi/addUser', [
    'controller' => 'App\Controller\userController',
    'action' => 'getAddUserAction',
    'auth' => true,
    ]);
$map->post('saveUsers', '/curso-introduccion-php-platzi/saveUser', [
    'controller' => 'App\Controller\userController',
    'action' => 'getAddUserAction',
    ]);

//Login
$map->get('loginGet', '/curso-introduccion-php-platzi/login', [
    'controller' => 'App\Controller\AuthController',
    'action' => 'getLogin'
    ]);

$map->post('loginPost', '/curso-introduccion-php-platzi/sign-in', [
    'controller' => 'App\Controller\AuthController',
    'action' => 'getLogin'
    ]);
//Admin
$map->get('admin', '/curso-introduccion-php-platzi/admin', [
    'controller' => 'App\Controller\AdminController',
    'action' => 'getIndex',
    'auth' => true,
    ]);

//Logout
$map->get('logout', '/curso-introduccion-php-platzi/logout', [
    'controller' => 'App\Controller\AuthController',
    'action' => 'getLogout'
    ]);

//Creamos el validador de rutas
$matcher = $routerContainer->getMatcher();
//Obtenermos la ruta según la petición
$route = $matcher->match($request);

//Validamos que la ruta sea correcta y emitimos la respuesta correspondiente.
if (!$route){
	echo "Ruta no encontrada.";
}
else{
    //El manejador de la ruta contiene la información básica de la misma
    $handlerData = $route->handler;
    $controllerName = new $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false; //Se comprueba si el usuario necesita autenticarse

    $sessionUserId = $_SESSION['userId'] ?? null;
    $responseMessage = null;
    if ($needsAuth && !$sessionUserId) {

        $controllerName = 'App\Controller\AuthController';
        $actionName = 'getLogout' ;
    }

    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            
                header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}


function printElement($element){

                     echo "<li class='work-position'>
                            <h5>".$element->title."</h5>
                            <p>".$element->description."</p>
                            <p>".$element->getDurationAsString()."</p>
                            <strong>Achievements:</strong>
                            <ul>
                              <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
                              <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
                              <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
                            </ul>
                          </li>";

    }
 ?>