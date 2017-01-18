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
        
        /* Custom query parser
            if 'custom_query_parser' in $params:
                1) use custom parser to create query string
                2) affix to $this->uri
                3) set $params to false, and continue
        */
        if (array_key_exists('custom_query_parser', $params['query'])) {
            $this->logger->info("Using custom query parser");
            // this will be the custom parser here
            $q_string = $this->custom_query_parser($params);
            // affix to URI
            $this->uri.=$q_string;
            $this->logger->info($this->uri);
            // empty $params array, and pass as normal
            $params = [];
        }

        /* String style params
            if $params is string
                1) affix to $this->uri
                3) set $params to false, and continue
        */
        if (gettype($params)) {
            $this->logger->info("String passed as params, using");
            // affix to URI
            $this->uri.=$params;
            $this->logger->info($this->uri);
            // empty $params array, and pass as normal
            $params = [];
        }

        // PLACEHOLDER to sniff out if debug flag was set
        // http://docs.guzzlephp.org/en/latest/request-options.html
        // logger interface logs activity; indicate log level through logger->info, error, or critical
        $start = microtime(true);
        $response = $this->client->request($type, $this->uri, $params);
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
     * Custom query parser
     * @param  array $params  Array of search parameters that were passed to APIRequest
     * @return string Custom formatted query string, including leading "?"
     */
    public function custom_query_parser($params)
    {
        $this->logger->info("Working with the following params for custom query parser");
        $this->logger->info(print_r($params,True));
        $q_string = '?';
        foreach ($params['query'] as $param => $value) {
            if (gettype($value) == 'array') {
                $this->logger->info("'$param' is array type, converting to non-bracketed, repeating form");
                $param_string = '';
                foreach ($value as $value_instance) {
                    $param_string.="$param=$value_instance&";
                }
                $q_string.=$param_string;
            }
            else {
                $q_string.="$param=$value&";
            }
        }
        $this->logger->info("Custom query string: $q_string");
        return $q_string;
    }
}
