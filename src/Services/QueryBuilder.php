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
     * Recieves input from Advanced Search form (POST /advanced_search), prepares for redirect to search
     * @param  array $params  Associative array of POST parameters
     * @return Returns associative array or string, based on flag
     */
    public function advanced_query_build($params, $as_string = false)
    {

        $this->logger->debug("running advanced_query_build");

        // translate advanced search form parameters to Solr-ese
        $search_params = [];

        /*     
        anticipating one of the "mighty four" form values:
            - all_q
            - exact_q
            - any_q
            - none_q
        prepare the 'q' string based on these
        */

        $q_array = [];
        // all
        if (!empty($params['all_q'])){
            $q_array['all_q'] = implode(" AND ", explode(' ', $params['all_q']));
        }
        // exacct
        if (!empty($params['exact_q'])){
            $q_array['exact_q'] = '"' . $params['exact_q'] . '"';
        }
        // all
        if (!empty($params['any_q'])){
            $q_array['any_q'] = implode(" OR ", explode(' ', $params['any_q']));
        }
        // none
        if (!empty($params['none_q'])){
            $q_array['none_q'] = "-".implode(" -", explode(' ', $params['none_q']));
        }
        // create search string from q_array
        $q_string = implode(" AND ", $q_array);    
        // add to search_params
        if (!$q_string == ''){
            // add q_string to search_params for 'q'
            $search_params['q'] = $q_string;
            // escape q field in API (needed for advanced solr syntax)
            $search_params['field_skip_escape'] = 'q';
        }    

        /* 
        prepare 'fq' section
        reacts to dropdown (e.g. collection, content-type, etc.)        
        */

        // begin
        $search_params['fq'] = [];

        if (!empty($params['collection'])){
            // push to fq array
            array_push($search_params['fq'], "human_isMemberOfCollection:".$params['collection']);
        }

        if (!empty($params['content_type'])){
            // push to fq array
            array_push($search_params['fq'], "human_hasContentModel:".$params['content_type']);
        }

        if ($as_string) {
            return $this->q_string_without_indices($search_params);
        }
        else {
            return $search_params;
        }

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
     * Add parameter to current URL
     * @param  string $param  key=value string to add to query string
     * @param  string $query_string all parameters as single query string
     * @return Return new query string
     */
    public function add_param_to_query_string($param, $query_string)
    {
        // $this->logger->debug("Adding: ".urlencode($param)." to ".$query_string);
        $new_query_string = $query_string."&fq%5B%5D=".urlencode($param);
        return $this->query_string_cleaner($new_query_string);
    }


    /**
     * Removes parameter from current URL
     * @param  string $param  key=value string to remove from query string
     * @param  string $query_string all parameters as single query string
     * @return Return new query string
     */
    public function del_param_from_query_string($param, $query_string)
    {
        $this->logger->debug("Looking for: ".urlencode($param)." in ".$query_string);
        $new_query_string = str_replace("fq%5B%5D=".urlencode($param), '', $query_string);
        return $this->query_string_cleaner($new_query_string);
    }


     /**
     * Set layout URL param for search/browse page
     * @param  string $param  key=value string to remove from query string
     * @param  string $query_string all parameters as single query string
     * @return Return new query string
     */
    public function set_layout_param($target_layout, $query_string)
    {
        $this->logger->debug("setting layout as: $target_layout");

        // handle list
        if ($target_layout == 'list'){
            $new_query_string = str_replace("layout=grid", '', $query_string);
        }

        // handle grid
        if ($target_layout == 'grid'){
            $new_query_string = $query_string."&layout=grid";
        }

        // $new_query_string = str_replace("fq%5B%5D=".urlencode($param), '', $query_string);
        return $this->query_string_cleaner($new_query_string);        
    }


     /**
     * Cleans up query string, errant &'s, etc.
     * @param  string $query_string all parameters as single query string
     * @return Return new query string
     */
    public function query_string_cleaner($query_string)
    {
        // clean query string
        // remove & from beginning and end of query string
        $query_string = trim($query_string, "&");
        // remove repeating & from query string
        $repeating = preg_match_all('/&{2,}/', $query_string, $matches);
        $this->logger->debug("Looking for repeating ampersands; found the following matches: ".print_r($matches, True));
        foreach ($matches[0] as $match) {
            $query_string = str_replace($match, "&", $query_string);
        }
        return $query_string;
    }
    
}






