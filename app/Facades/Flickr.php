<?php namespace FlickrPhotoSearch\Facades;

use Illuminate\Support\Facades\Facade;

class Flickr extends Facade{
	protected static function getFacadeAccessor() {
		return 'flickrtool'; 
	}
}