<?php

// Valid PHP Version?
$minPHPVersion = '7.2';
if (phpversion() < $minPHPVersion)
{
	die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}
unset($minPHPVersion);

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(FCPATH . '../VOIA_App/app/Config/Paths.php');
// ^^^ Change this if you move your application folder

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
$app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */


$request = \Config\Services::request();
$path = $request->uri->getPath();
$request->setHeader("X-API-Key", "d4f9ea86999948c4060588e61484e8f36a06d7a2");	//Permet le déboguage en tant de structure sans préciser X-API-Key dans le header


$userPathArray = [
	"/",
	"formations/(:segment)",
	"connexion",
	"deconnexion",	
	"/admin/connexion",
	"inscription",
	"inscription/(:segment)",
	"cours",
];

$adminPathArray = [
	""
];

// if ($request->hasHeader("X-API-Key")) {
// 	if (strpos($path, "apis") === 0) {
// 		$header_x_api_key = ($request->getHeader("X-API-Key"));
// 		$permitedURIArray = (\App\Libraries\Helper::getPermitedURI($header_x_api_key->getValue("X-API-Key")));
// 		if(isset($permitedURIArray["get"])){
// 			$permitedURIArray = $permitedURIArray[$request->getMethod()];
// 			if (\App\Libraries\Helper::isValidateURI($path, $permitedURIArray)) {
// 				$app->run();
// 			} else {
// 				echo json_encode([
// 					"status" => "failed",
// 					"message" => "Vous n'avez pas le droits requis pour faire cette requête"
// 				], JSON_UNESCAPED_UNICODE);
// 			}
// 		}else{
// 			echo json_encode([
//                 "status" => "failed",
//                 "message" => "Le token n'est pas dans la base de données"
//             ], JSON_UNESCAPED_UNICODE);
// 		}

// 	} else {
// 		$app->run();
// 	}
// } else {
// 	if (strpos($path, "apis") === 0) {
// 		echo json_encode([
// 			"status" => "failed",
// 			// "message" => "vous n'avez aucun accès à l'api car vous n'avez pas d'api key"
// 		], JSON_UNESCAPED_UNICODE);
// 	} else {
// 		$app->run();
// 	}
// }

$app->run();
