<?php
/**
 * APIRequest class
 * A direct method by which to communicate with the WSUDOR API. Harnesses Guzzle and Monolog to communicate and log activity.
 * Modeled after Eulfedora's HTTP_API_Base
 * @param  object $logger the logging interface
 * @param  object $client the guzzle client instance
 */

namespace App\Services;

use Monolog\Logger;


class QueryBuilder
{    
    public $type;
    public $uri;
    public $params;

	/**
	 * Constructor
	 * @param  string $type HTTP 1.1 Methods (GET, POST, etc)
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
	 * @param Logger $logger Monolog logging
	 * @return void
	 */
    public function __construct(Logger $logger)
    {
        // Query parameters for request instance
        $this->type = null;
        // URI
        $this->uri = null;
        // Query parameters for request instance
        $this->params = null;
        // Logging
        $this->logger = $logger;
    }


	/**
     * Remove indices and brackets from repeating GET parameters
     * @param  array $params  Associative array of GET parameters
     * @return Returns prepared query string
     */
    public function q_string_without_brackets($params)
    {
        // removes indexes from bracketed, repeating parameters
        // function / walk based (http://stackoverflow.com/a/26565074/1196358)
        // function / walk based (http://stackoverflow.com/a/26565074/1196358)
        $walk = function( $item, $key, $parent_key = '' ) use ( &$output, &$walk ) {
            is_array( $item ) 
                ? array_walk( $item, $walk, $key ) 
                : $output[] = http_build_query( array( $parent_key ?: $key => $item ) );
        };
        array_walk( $params, $walk );
        $qstring = implode( '&', $output );
        $this->logger->debug("QueryBuilder -> q string via q_string_without_brackets(): ".$qstring);
        return $qstring;
    }


    /**
     * Remove indices from repeating GET parameters
     * @param  array $params  Associative array of GET parameters
     * @return Returns prepared query string
     */
    public function q_string_without_indices($params)
    {
    	$qstring = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', http_build_query($params));
    	$this->logger->debug("QueryBuilder -> query string via q_string_without_indices(): ".$qstring);
    	return $qstring;
    }


    /**
     * Add parameter
     * @return Return associative array of parameters
     */
    public function add_param($params)
    {
        //
    }


    /**
     * Add parameter
     * @return Return associative array of parameters
     */
    public function del_param($params)
    {
        //
    }
    
}






