<?php 

namespace CatalogX\Enquiry;
use CatalogX\Utill;

/**
 * CatalogX Enquiry Module class
 *
 * @class 		Module class
 * @version		6.0.0
 * @author 		MultivendorX
 */
class Module {
    /**
     * Container contain all helper class
     * @var array
     */
    private $container = [];

    /**
     * Contain reference of the class
     * @var 
     */
    private static $instance = null;

    /**
     * Catalog class constructor function
     */
    public function __construct() {

        // Init helper classes
        $this->init_classes();

        do_action( 'load_premium_enquiry_module' );
            
    }

    /**
     * Init helper classes
     * @return void
     */
    public function init_classes() {
        $this->container[ 'util' ]      = new Util();
        $this->container[ 'frontend' ]  = new Frontend();
        $this->container[ 'rest' ]      = new Rest();
    }

    /**
     * Magic getter function to get the reference of class.
     * Accept class name, If valid return reference, else Wp_Error. 
     * @param   mixed $class
     * @return  object | \WP_Error
     */
    public function __get( $class ) {
        if ( array_key_exists( $class, $this->container ) ) {
            return $this->container[ $class ];
        }
        return new \WP_Error( sprintf('Call to unknown class %s.', $class ) );
    }

    /**
     * Magic setter function to store a reference of a class.
     * Accepts a class name as the key and stores the instance in the container.
     *
     * @param string $class The class name or key to store the instance.
     * @param object $value The instance of the class to store.
     */
    public function __set( $class, $value ) {
        $this->container[ $class ] = $value;
    }

    /**
     * Initializes Catalog class.
     * Checks for an existing instance
     * And if it doesn't find one, create it.
     * @param mixed $file
     * @return object | null
     */
    public static function init() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}