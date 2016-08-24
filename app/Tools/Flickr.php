<?php namespace FlickrPhotoSearch\Tools;

class Flickr 
{

	private function config()
	{
		return array(
				'method' 		=> 'flickr.photos.search',
				'api_key' 		=> 'c16d69dcca5f49cc90337d3f5588c306',
				'format'		=> 'php_serial',
				'extras' 		=> 'url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l',
			);
	}
	
	public function args($page, $text = '', $perPage = 30, $mode = 'text', $safeSearch = 1, $contentType = 7) 
	{
		return array(
				'page'			=> $page,
				'per_page'		=> $perPage,
				"$mode" 		=> urlencode($text),
				'safe_search'   => $safeSearch,
				'content_type'	=> $contentType
			);
	}
	
	private function resource($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

	    try {
			$data = curl_exec($ch);
			$retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if ($retCode == 200) {
				return unserialize($data);
			} else {
				return null;
			}

	    } catch (Exception $e) {
	      	error_log('Flickr Photo Search Error: ' . $e->getMessage());
	    }
	}

	public function getSearchData($args) 
	{
		$config = $this->config();
		$parameters = array_merge($config, $args);

	    $url = 'https://api.flickr.com/services/rest/?';
	    $query = $url.http_build_query($parameters);
	    
	    $searchResult = $this->resource($query);
	    
	    if ($searchResult['stat'] == 'ok') {
	      return $searchResult['photos'];
	    } else {
	      error_log('Flickr Search Error: [' . $searchResult['code'] . '] ' . $searchResult['message']);
	      return null;
	    }
	    
	}

	public function getPagination($page, $pages, $perPage, $query, $mode, $safeSearch, $contentType) 
	{
    	$str = '';

	    // make sure we dont go over result boundary 
	    if ($page < 1) { 
	    	$page = 1; 
	    } else if ($page > $pages) { 
	      	$page = $pages; 
	    }

	    if ($page > 1) {
	      	$str .= sprintf('<li><a href="?keyword=%s&page=%s&perPage=%s&mode=%s&safeSearch=%s&contentType=%s">First</a></li>', $query, 1, $perPage, $mode, $safeSearch, $contentType);
	      	$str .= sprintf('<li><a href="?keyword=%s&page=%s&perPage=%s&mode=%s&safeSearch=%s&contentType=%s">Previous</a></li>', $query, $page - 1, $perPage, $mode, $safeSearch, $contentType);
	    }

	    $max = 10;
	    if($page < $max)
	      	$page_from = 1;
	    elseif($page >= ($pages - floor($max / 2)) )
	      	$page_from = $pages - $max + 1;
	    elseif($page >= $max)
	      	$page_from = $page  - floor($max/2);

	    for($i = $page_from; $i <= ($page_from + $max - 1); $i++) {
	      	if($i > $pages) continue;

	      	if($page == $i) {
	        	// the current page
	        	$str .= sprintf('<li><span>%s</span></li>', number_format($i));
	      	} else {
	        	$str .= sprintf('<li><a href="?keyword=%s&page=%s&perPage=%s&mode=%s&safeSearch=%s&contentType=%s">%s</a></li>', $query, $i, $perPage, $mode, $safeSearch, $contentType, number_format($i));          
	      	}
	    }

	    if ($page < $pages) {
	      	$str .= sprintf('<li><a href="?keyword=%s&page=%s&perPage=%s&mode=%s&safeSearch=%s&contentType=%s">Next</a></li>', $query, $page + 1, $perPage, $mode, $safeSearch, $contentType);
	      	$str .= sprintf('<li><a href="?keyword=%s&page=%s&perPage=%s&mode=%s&safeSearch=%s&contentType=%s">Last</a></li>', $query, $pages, $perPage, $mode, $safeSearch, $contentType);
	    }

	    return empty($str) ? '' : '<ul class="pagination">' . $str . '</ul>'; 
	}
}