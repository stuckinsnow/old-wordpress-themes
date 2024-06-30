if(!class_exists('altabsy_SHORTCODE')){
	class altabsy_SHORTCODE{
		/**
		* $shortcode_tag 
		* holds the name of the shortcode tag
		* @var string
		*/
	    public $shortcode_tag = 'altabsy';

	    /**
		* __construct 
		* class constructor will set the needed filter and action hooks
		* 
		* @param array $args 
		*/
		function __construct($args = array()){
			add_action('init', array($this, 'register_shortcode'));
			add_filter( 'altabsy_shortcode', array( $this,'shortcode_handler'), 999, 4 );
		}


		/**
		* shortcode_handler
		* @param  array  $atts shortcode attributes
		* @param  string $content shortcode content
		* @return string
		*/
		function shortcode_handler($atts , $content = null){
			$pre_atts = $atts;
			$atts = shortcode_atts(array(
				'id'			=> uniqid(),
	            'skin' 			=> 	null,
	            'responsive' 	=> 	true
	        ), $atts);
			$classes = array('altabsy', 'altabsy-' . $atts['id']);
			$data = '';

			if(function_exists('altabsy_customizer')){
		    	altabsy_shortcode_start($pre_atts, $atts);
		    	$classes = altabsy_shortcode_classes( $classes, $pre_atts, $atts );
		    	$data = altabsy_shortcode_data( $data );
		    }

		    $return = '<div class="'. join(' ', $classes);;
		    if(!empty($atts['skin'])){
		    	$return .= ' altabsy-skin-' . $atts['skin'];
		    }
		    $return .='" '. $data .'>';
		    $return .= $this->extract_tab($content) ;
		    $return .= $this->extract_tabcontent($content) ;
		    $return .= '</div>';

		    if(function_exists('altabsy_customizer')){
		    	altabsy_shortcode_end($pre_atts, $atts);
		    }

		    return $return;
		}

		/**
		* extract all [tab] content
		*/

		function extract_tab($content){
			$count = 1;
			$pattern_tabs = '{(\[tab.*?\[/tab\])}is';
	        $pattern_tab = '{\[tab(.*?)\[/tab\]}is';
	        $tabs = preg_split($pattern_tabs, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	        // echo $content;
	        // echo '<pre>';print_r($tabs); echo '</pre>';
	        $tabs = array_filter($tabs);
	        // $a = shortcode_parse_atts($tabs[0]);
	        $navs = '<ul class="altabsy-nav">';
	        foreach ($tabs as $tab) {
	        	if (preg_match($pattern_tab, $tab, $matches)) {
	        		$cl = str_replace('[/tab]', '', $matches[0]);
	        		preg_match_all("#\[[^\]]*\]#", $cl, $tag, PREG_PATTERN_ORDER);
	        		
	        		$label = '';
	        		$atts = '';
	        		$icon = '';
	        		if(isset($tag[0][0])){
	        			$label = str_replace($tag[0][0], '', $cl);
	        			$sc = str_replace('[tab', '', $tag[0][0]);
	        			$sc = str_replace(']', '', $sc);
	        			$atts = shortcode_parse_atts($sc);
	        			if(isset($atts['icon'])){
	        				$icon = '<i class="fa '. preg_replace("/&#?[a-z0-9]+;/i","",$atts['icon']) . '"></i> ';
	        			}
	        		}
	        		
	        		$navs .= '<li><a href="#altabsy-content-'. $count .'">'. $icon . strip_tags($label, '<i><span>') .'</a></li>';
	        		$count++;
	        	}
	        }
	        $navs .= '</ul>';

	        return $navs;
		}

		/**
		* extract all [tabcontent] content
		*/

		function extract_tabcontent($content){
			$count = 1;
			$pattern_tabs = '{(\[tabcontent\].*?\[/tabcontent\])}is';
	        $pattern_tab = '{\[tabcontent\](.*?)\[/tabcontent\]}is';
	        $contents = preg_split($pattern_tabs, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	        $contents = array_filter($contents);
	        $return = '<div class="altabsy-inner">';
	        foreach ($contents as $content) {
	        	if (preg_match($pattern_tab, $content, $matches)) {
	        		$return .= '<div class="altabsy-content" id="altabsy-content-'. $count .'">'. do_shortcode( $matches[1] ) .'</div>';
	        		$count++;
	        	}
	        }
	        $return .= '</div>';

	        return $return;
		}

		/**
		* register_shortcode
		*/
		function register_shortcode(){
			add_shortcode($this->shortcode_tag, array($this, 'shortcode_handler'));
		}

		}
		new altabsy_SHORTCODE();
}



// Return all shortcodes from the post
function _get_shortcodes( $the_content ) {

    $shortcode = "";
    $pattern = get_shortcode_regex();
    preg_match_all('/'.$pattern.'/uis', $the_content, $matches);

    for ( $i=0; $i < 40; $i++ ) {

        if ( isset( $matches[0][$i] ) ) {
           $shortcode .= $matches[0][$i];
        }

    }

    return $shortcode;

}
