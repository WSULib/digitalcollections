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
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;


class APIRequest
{
    protected $client;
    public $base_uri;
    public $uri;
    public $username;
    public $password;
    public $type;
    public $params;
/**
 * Constructor
 * @param Logger $logger Monolog logging
 * @param Client $client Guzzle Client
 * @return void
 */
    public function __construct(Logger $logger, Client $client)
    {
        $this->uri = null;
        // Future Stuff to do about sessions go here
        $this->logger = $logger;
        // Instantiate a guzzle client with the base_uri already pointed to the API
        $this->client = $client;
        // Query parameters for request instance
        $this->type = null;
        // Query parameters for request instance
        $this->params = null;
    }

    /**
     * Make an HTTP request to WSUDOR API
     * Note: private method
     *
     * @param  string $type HTTP 1.1 Methods (GET, POST, etc)
     * @param  array|string|null $params an optional series of HTTP parameters, as array or string
     * @return object PSR-7 response object via Guzzle library
     */

    private function request($type, $params = null)
    {

        // catch type
        $this->type = $type;

        // catch params
        $this->params = $params;

        // run through custom query parser
        /*
            Figure out how to use CustomQuery service, import/use from container?
            For the time being, using local, repeated custom_query_writer below
            And it's possible, that method should exist, and IT should use the CustomQuery
        */
        $this->custom_query_writer();

        // debug
        $this->logger->debug("---------------- APIRequest firing: ----------------");
        $this->logger->debug($this->uri);
        $this->logger->debug(print_r($this->params,True));
        $this->logger->debug("----------------------------------------------------");
        
        // send request to API
        $start = microtime(true);
        $response = $this->client->request($type, $this->uri, $this->params);
        $time_spent = microtime(true) - $start;
        $this->logger->info("Request took $time_spent");

        // parse status code
        $httpStatus = $response->getStatusCode();
        if ($httpStatus == 456) {
            // perhaps some special response if API returns a custom HTTP response code
        }

        return $response;
    }

    /**
     * Send a GET request
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @return object PSR-7 response object via Guzzle library
     */
    public function get($uri, $params = null)
    {
        $params = ['query' => $params];
        $this->uri = $uri;
        return $this->request('GET', $params);
    }

    /**
     * Send a POST request
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @return object PSR-7 response object via Guzzle library
     */
    public function post($uri, $params = null)
    {
        $params = ['form_params' => $params];
        $this->uri = $uri;
        return $this->request('POST', $params);
    }

    /**
     * Send a HEAD request - e.g. retrieves headers from endpoint
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @return object PSR-7 response object via Guzzle library
     */
    public function head($uri, $params = null)
    {
        $params = ['query' => $params];
        $this->uri = $uri;
        return $this->request('HEAD', $params);
    }

    /**
     * Custom query parser - formats requests to accomodate back-end API
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @return object PSR-7 response object via Guzzle library
     */
    private function custom_query_writer()
    {
        // custom parsing for GET requests
        // removes indexes from bracketed, repeating parameters
        if ($this->type == 'GET') {
            // function / walk based (http://stackoverflow.com/a/26565074/1196358)
            $walk = function( $item, $key, $parent_key = '' ) use ( &$output, &$walk ) {
                is_array( $item ) 
                    ? array_walk( $item, $walk, $key ) 
                    : $output[] = http_build_query( array( $parent_key ?: $key => $item ) );
            };
            array_walk( $this->params['query'], $walk );
            $qstring = implode( '&', $output );
            $this->logger->info("custom query string via APIRequest: ".$qstring);
            $this->uri.="?".$qstring;            
            $this->params = [];
        }
    }

}
