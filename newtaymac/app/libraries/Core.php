<?php

class Core{


    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params  = [];

    public function __construct(){


        if(!$url = $this->getUrl()){
            $url = array("pages","index");
        }

        /*
         * Adding logic to conditionally route requests other than GET
         * to an alternate controller mechanism.
         *
         * This is related to another change in the libraries: the introduction
         * of the BaseController superclass of Controller.
         *
         * This still keeps to the pattern of /controller/method for routes.
         *
         */

        // set a default controllerPath that can be overriden.
        $controllerPath = "controllers/";

        // TODO FOR FRAMEWORK: The condition of checking for the login will not be ideal for all projects.
      
            if((defined('ROUTE_REQUEST') && ROUTE_REQUEST === true) || isset($_REQUEST['ROUTE_REQUEST'])) {
                /*
                 * the default controllerPath is already defined. In the following
                 * switch, we can provide alternates and override it. At the moment
                 * we only care about POST or GET (GET is the default), but could easily
                 * add cases for PATCH, DELETE, etc.
                 */
                switch ( strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
                    case 'post':
                        $controllerPath = 'controllers/post/';
                        break;
                    default:
                        // if $controllerPath is not set now, there is a problem
                        if ( ! isset( $controllerPath ) ) {
                            throw  new frameworkError( "Can't determine controller path!" );
                        }
                }
            }

        

        // force GET requests to use https if the FORCEHTTPS constant is set
        // Adding exception for API requests to avoid dropping POST
        if((!isset($_REQUEST['apikey']) && !isset($_REQUEST['apikey'])) &&
           defined('FORCEHTTPS') &&
           strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) != 'https'){
            //Tell the browser to redirect to the HTTPS URL.
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            //Prevent the rest of the script from executing.
            exit;
        }

        if(file_exists('../app/' . $controllerPath . ucwords($url[0]).'.php')){
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        } else {
            $this->notfound("Couldn't find a matching controller.");
        }

        require_once '../app/' . $controllerPath . $this->currentController.'.php';

        $this->currentController = new $this->currentController();

        if(isset($url[1])){
            // Check to see if method exists in controller
            $methodtocall = $url[1];
            /*
             * By using is_callable instead of method_exists, we can use the magic
             * method __call() in addition to actually having the methods.
            */
            if(is_callable([$this->currentController, $methodtocall])){
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            } else {
                $this->notfound("Couldn't find a matching method in a controller.");
            }
        }

        $this->params = $url ? array_values($url) : [];
        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){

        // NOTE: checking $_REQUEST['url'] instead of $_GET because we need to route POST and other methods also
        if(isset($_REQUEST['url']) && trim($_REQUEST['url']) != ''){

            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            return explode('/', $url);
        }
    }

    public static function notfound($message = null){

        $url = $_REQUEST['url'];

        if (!isset($message)){
            $message = "We're sorry, $url could not be found.";
        }

        $message .= " (HTTP 404 - $url)";

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        echo $message;
        //Redirecting::location('pages/notfound');
        exit();
    }

    public static function unauthorized($message = null,$redirect = false){

        if($redirect === true){
            header("Location: " . URLROOT);
            exit();
        }

        $url = $_REQUEST['url'];

        if (!isset($message)){
            $message = "We're sorry, you don't have permission to access $url.";
        }

        $message .= " (HTTP 403 - Unauthorized)";

        header($_SERVER["SERVER_PROTOCOL"]." 403 Unauthorized", true, 403);
        echo $message;
        exit();
    }
}



?>