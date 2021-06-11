<?php


//  <script src="http://localhost/lojasgaucha/wp-includes/js/wp-emoji-release.min.js?ver=5.7.2" type="text/javascript" defer=""></script>



    add_filter('script_loader_tag', 'add_async_to_script', 10, 3);

    function add_async_to_script()
    {
        if ('dropbox.js' === $handle) {
            $tag = '<script type="text/javascript" src="' . esc_url($src) . '" id="dropboxjs" data-app-key="MY_APP_KEY"></script>';
        }

        return $tag;
    }


// add async and defer attributes to enqueued scripts
function shapeSpace_script_loader_tag($tag, $handle) {

    echo $tag;
    echo $handle;
	
	// if ($handle === 'my-plugin-javascript-handle') {
		
	// 	if (false === stripos($tag, 'async')) {
			
	// 		$tag = str_replace(' src', ' async="async" src', $tag);
			
	// 	}
		
	// 	if (false === stripos($tag, 'defer')) {
			
	// 		$tag = str_replace('<script ', '<script defer ', $tag);
			
	// 	}
		
	// }
	
	return $tag;
	
}
add_filter('script_loader_tag', 'shapeSpace_script_loader_tag', 10, 3);