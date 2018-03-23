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
use App\Services\QueryBuilder;


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
    public function __construct(Logger $logger, Client $client, QueryBuilder $QueryBuilder)
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
        // load QueryBuilder class
        $this->QueryBuilder = $QueryBuilder;
    }

    /**
     * Make an HTTP request to WSUDOR API
     * Note: private method
     *
     * @param  string $type HTTP 1.1 Methods (GET, POST, etc)
     * @param  array|string|null $params an optional series of HTTP parameters, as array or string
     * @return object PSR-7 response object via Guzzle library
     */

    private function request($type, $params = null, $custom_query = false)
    {

        // catch type
        $this->type = $type;

        // catch params
        $this->params = $params;

        // run through custom_query_writer if custom_query == true
        if ($custom_query && !empty($params)) {
            $this->logger->debug("using custom query writer");
            $this->custom_query_writer();
        }

        // debug
        $this->logger->debug($this->uri);
        $this->logger->debug(print_r($this->params,True));
        
        // send request to API
        $start = microtime(true);
        $response = $this->client->request($type, $this->uri, $this->params);
        $time_spent = microtime(true) - $start;
        $this->logger->info("Request took: $time_spent");

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
     * @param  boolean $custom_query If True, runs $this->custom_query_writer() before query
     * @return object PSR-7 response object via Guzzle library
     */
    public function get($uri, $params = null, $custom_query = false)
    {        
        $params = ['query' => $params];
        $this->uri = $uri;
        return $this->request('GET', $params, $custom_query);
    }

    /**
     * Send a POST request
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @param  boolean $custom_query If True, runs $this->custom_query_writer() before query
     * @return object PSR-7 response object via Guzzle library
     */
    public function post($uri, $params = null, $custom_query = false)
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
     * Custom query writer - formats requests to accomodate back-end API
     * @param  string $uri  The Route that initialized this request (/action/PID/sub-action)
     * @param  array $params Associative array of parameters
     * @return object PSR-7 response object via Guzzle library
     */
    private function custom_query_writer()
    {
        
        if ($this->type == 'GET') { 
            // if user logged in, include "isDiscoverable=true"        
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                $this->params['query']['isDiscoverable'] = false;
            }
            // custom parsing for GET requests
            // removes indexes from bracketed, repeating parameters
            // uses Services\QueryBuilder class
            if (!empty($this->params['query'])){
                $qstring = $this->QueryBuilder->q_string_without_brackets($this->params['query']);
                $this->uri.="?".$qstring;            
                $this->params = [];    
            }
        }

        if ($this->type == 'POST') { 
            // handle custom POST form_data
        }
    }

}
