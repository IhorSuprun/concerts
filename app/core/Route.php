<?php
class Route {
    static public function start() {
	// контроллер и действие по умолчанию
	$controller_name = 'Concerts';
	$action_name = 'index';
	$route = explode('\\', $_SERVER['REQUEST_URI']);
        $routes = explode('/', $route[0]);
        
	// получаем имя контроллера
	if (!empty($routes[2])) {
	    $controller_name = ucfirst($routes[2]);
	}
	// получаем имя экшена
	if (!empty($routes[3])) {
	    $action_name = $routes[3];
	}
	// добавляем префиксы
	$model_name = 'Model_' . $controller_name;
	$controller_name = 'Controller_' . $controller_name;
	$action_name = 'action_' . $action_name;
	// подцепляем файл с классом модели (файла модели может и не быть)
	$model_file = $model_name . '.php';
	$model_path = "app".DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR . $model_file;
	if (file_exists($model_path)) {
	    include $model_path;
	}
	// подцепляем файл с классом контроллера
	$controller_file = $controller_name . '.php';
	$controller_path = "app".DIRECTORY_SEPARATOR."controllers".DIRECTORY_SEPARATOR . $controller_file;
	if (file_exists($controller_path)) {
	    include $controller_path;
	} else {
	    /*
	      правильно было бы кинуть здесь исключение,
	      но для упрощения сразу сделаем редирект на страницу 404
	     */
	    Route::ErrorPage404();
	}
	// создаем контроллер
	$controller = new $controller_name;
	if (method_exists($controller, $action_name)) {
	    $add_params = array();
	    foreach ($routes as $key => $route) {
		if ($key <= 2) {
		    continue;
		}
		$add_params[] = $route;
	    }
	    if (!empty($add_params)) {
		
		$controller->$action_name($add_params);
	    } else {
		$controller->$action_name();
	    }
	    // вызываем действие контроллера
	} else {
	    // здесь также разумнее было бы кинуть исключение
	    Route::ErrorPage404();
	}
    }
    static public function ErrorPage404() {
	header('HTTP/1.1 404 Not Found');
	header("Status: 404 Not Found");
	exit('page not found');
	//TODO красивая страница 404
    }
    static public function redirect($path) {
	$domen_name = $_SERVER['HTTP_ORIGIN'];
	header('Location: ' . $domen_name . $path);
    }
}
