<?php

namespace FlickrPhotoSearch\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use FlickrPhotoSearch\Http\Requests;
use FlickrPhotoSearch\Http\Controllers\Controller;

use FlickrPhotoSearch;
use Flickr;

class FlickrPhotoSearchController extends Controller
{
    public function index(Request $request)
    {    	
    	$keyword = $request->input('keyword');
    	$mode = $request->input('mode');
    	$perPage = $request->input('perPage');
    	$safeSearch = $request->input('safeSearch');
    	$contentType = $request->input('contentType');

    	if (isset($_GET["page"])) {
			$page = htmlspecialchars($_GET["page"]);
		} else {
			$page = 1;
		}

    	$args = Flickr::args($page, $keyword, $perPage, $mode, $safeSearch, $contentType);
    	$searchData = Flickr::getSearchData($args);

 		if (!empty($searchData)) {
 			$page = $searchData['page'];
			$pages = $searchData['pages'];

			if ($searchData['total'] > 4000) {
				if (empty($perPage)) {
					$perPage = 10;
				} 
				$pages = 4000 / $perPage;
			}

 			$data = array(
 					'result' => $searchData,
 					'pagination' => Flickr::getPagination($page, $pages, $perPage, $keyword, $mode, $safeSearch, $contentType),
 				);

 			return view('index')->with('searchData', $data);

 		} else {
 			return view('index');
 		}
    }
}
