<?php
if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
}
// Chemin de la base de l'application avec un slash final
$sBasepath=$_SERVER['DOCUMENT_ROOT'].'/';
require_once($sBasepath."/app/core/autoload.php");

session_start();
$oRouter = new Router();
$oApp = new App();

//  Routeur
// Ajout des routes (request_path, controller, action)
$oRouter->addRoute('/',                    'HomeController',           'home');
$oRouter->addRoute('/connexion',           'LoginController',          'login');
$oRouter->addRoute('/checklogin',          'LoginController',          'checklogin');
$oRouter->addRoute('/forgotpasswd',        'LoginController',          'forgotpasswd');
$oRouter->addRoute('/newpasswd',           'LoginController',          'newpasswd');
$oRouter->addRoute('/logout',              'LoginController',          'logout');
$oRouter->addRoute('/inscription',         'InscriptionController',    'register');
$oRouter->addRoute('/inscription-save',    'InscriptionController',    'register-save');
$oRouter->addRoute('/logement',            'LogementController',       'logement');
$oRouter->addRoute('/logement-add',        'LogementController',       'logement-add');
$oRouter->addRoute('/logement-edit',       'LogementController',       'logement-edit');
$oRouter->addRoute('/logement-delete',     'LogementController',       'logement-delete');
$oRouter->addRoute('/logement-save',       'LogementController',       'logement-save');
$oRouter->addRoute('/piece',               'PieceController',          'piece');
$oRouter->addRoute('/piece-add',           'PieceController',          'piece-add');
$oRouter->addRoute('/piece-edit',          'PieceController',          'piece-edit');
$oRouter->addRoute('/piece-delete',        'PieceController',          'piece-delete');
$oRouter->addRoute('/piece-save',          'PieceController',          'piece-save');
$oRouter->addRoute('/contact',             'ContactController',        'contact');
$oRouter->addRoute('/eco',                 'EcoController',            'eco');
$oRouter->addRoute('/rgpd',                'RgpdController',           'rgpd');
$oRouter->addRoute('default',              'err404Controller',         'err404');


// Boucle principale
// Les redirections sont correctement gérées et les codes de réponse HTTP retournés
do {
    // Recherche de la route dans request_path et initialise controller_name et controller_action
    $oRouter->matchRoute();

    // Initialise le controller et execute l'action
    $oApp->initController();
    $oApp->runController();
    $oApp->stopController();

    if ($oApp->exit_code === App::EXIT_REDIRECT) {
//        $sRedirect = "Location: http://".$_SERVER['HTTP_HOST'].$oApp->redirect_path;
//        header( $sRedirect,true, $oApp->http_response_code );
        $oRouter->request_path = $oApp->redirect_path;
    }
} while ($oApp->exit_code !== App::EXIT_DONE);

