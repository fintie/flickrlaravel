<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Flickr Photo Search</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="magnific-popup/magnific-popup.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="magnific-popup/jquery.magnific-popup.js"></script>
		<script src="js/style.js"></script>
	</head>
	<body>
		<div class="container">
			<form class="form-inline" action="" method="get">
				<div class="form-group">
			        <input type="text" name="keyword" class="form-control" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''?>" placeholder="Type search text here..." >
			    </div>

		    	<div class="form-group">
					<select name="mode">
						<option value="text"> - keyword Mode -</option>
						<option value="text" <?php if (isset($_GET['mode']) && $_GET['mode']=="text") echo "selected";?>>All Text</option>
						<option value="tags" <?php if (isset($_GET['mode']) && $_GET['mode']=="tags") echo "selected";?>>Tags Only</option>
					</select>
		    	</div>

		    	<div class="form-group">
					<select name="perPage">
						<option value="10"> - Number Per Page -</option>
						<option value="10" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="10") echo "selected";?>>10</option>
						<option value="20" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="20") echo "selected";?>>20</option>
						<option value="30" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="30") echo "selected";?>>30</option>
						<option value="40" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="40") echo "selected";?>>40</option>
						<option value="50" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="50") echo "selected";?>>50</option>
						<option value="60" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="60") echo "selected";?>>60</option>
						<option value="70" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="70") echo "selected";?>>70</option>
						<option value="80" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="80") echo "selected";?>>80</option>
						<option value="90" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="90") echo "selected";?>>90</option>
						<option value="100" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="100") echo "selected";?>>100</option>
						<option value="200" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="200") echo "selected";?>>200</option>
						<option value="300" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="300") echo "selected";?>>300</option>
						<option value="400" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="400") echo "selected";?>>400</option>
						<option value="500" <?php if (isset($_GET['perPage']) && $_GET['perPage']=="500") echo "selected";?>>500</option>
					</select>
		    	</div>

		    	<div class="form-group">
			    	<div>
			    		<select name="safeSearch">
			    			<option value="1">- Safe Level -</option>
							<option value="1" <?php if (isset($_GET['safeSearch']) && $_GET['safeSearch']=="1") echo "selected";?>>Safe</option>
							<option value="2" <?php if (isset($_GET['safeSearch']) && $_GET['safeSearch']=="2") echo "selected";?>>Moderate</option>
							<option value="3" <?php if (isset($_GET['safeSearch']) && $_GET['safeSearch']=="3") echo "selected";?>>Restricted</option>
						</select>
			    	</div>
		    	</div>

		    	<div class="form-group">
			    	<div>
			    		<select name="contentType">
			    			<option value="7">- Content Type -</option>
			    			<option value="1" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="1") echo "selected";?>>Photo Only</option>
							<option value="2" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="2") echo "selected";?>>Screenshots Only</option>
							<option value="3" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="3") echo "selected";?>>'Other' Only</option>
							<option value="4" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="4") echo "selected";?>>Photos and ScreenShots</option>
							<option value="5" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="5") echo "selected";?>>ScreenShots and 'other'</option>
							<option value="6" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="6") echo "selected";?>>Photos and 'Other'</option>
							<option value="7" <?php if (isset($_GET['contentType']) && $_GET['contentType']=="7") echo "selected";?>>All</option>
						</select>
			    	</div>
		    	</div>

		    	<button type="submit" class="btn btn-primary">Search</button>
	     	</form>

			@if (isset($searchData))
				@if ($searchData['result']['total'] == 0)
					No Result Found.
			    @endif
			    <div class="container-fixed">
				    <ul class="list-inline">
			     	@foreach ($searchData['result']['photo'] as $photo)
			     		<li><a class="image-link" href="#test-popup{{$photo['id']}}"><img src="http://farm{{$photo['farm']}}.static.flickr.com/{{$photo['server']}}/{{$photo['id']}}_{{$photo['secret']}}_t.jpg"></a></li>
			     		<div id="test-popup{{$photo['id']}}" class="white-popup mfp-hide">
			     		<div class="row">
							<div class="col-md-8"><img class="img-responsive" src="http://farm{{$photo['farm']}}.static.flickr.com/{{$photo['server']}}/{{$photo['id']}}_{{$photo['secret']}}.jpg"></div>
								<div class="col-md-4">
									<dl>
										<dt>{{$photo['title']}}</dt>
										<hr>
										<dd><b>ID: </b>{{$photo['id']}}</dd>
										<dd><b>Owner: </b>{{$photo["owner"]}}</dd>
										<dd><a target="_blank" href="https://www.flickr.com/photos/{{$photo['owner']}}">Go to Photo Owner's Page</a></dd>
										<dd><a href="http://farm{{$photo['farm']}}.static.flickr.com/{{$photo['server']}}/{{$photo['id']}}_{{$photo['secret']}}.jpg" download>Download</a></dd>
									</dl>
								</div>
							</div>
						</div>
					@endforeach	
					</ul>
				</div>

				<div id="pagination">
		        	{!! $searchData['pagination'] !!}
		        </div>	
		    @elseif (!empty($_GET))
				No Result Found.
		    @endif
		</div>	
	</body>
</html>