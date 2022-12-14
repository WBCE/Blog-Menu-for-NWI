<?php
/*
 -----------------------------------------------------------------------------------------
  Code snippet BlogMenu 
  Licencsed under GNU, written by Erik Coenjaerts (Eki)
  portet for NwI by florian
 -----------------------------------------------------------------------------------------
*/

// function to display a Blog Menu on every page via (invoke function from template or code page)

if (!function_exists('display_blog_menu')) {
	function display_blog_menu($page_id,$date_option = 0,$group_header = '<h1>Categories</h1>' ,$history_header = '<h1>History</h1>',$display_option = 0) {
		
		// register outside object
		global $database;

		//get link to the page
		$query = "SELECT `link` FROM `" .TABLE_PREFIX ."pages` WHERE `page_id`=$page_id;";
		$result = $database->query($query);
		if(is_object($result) && $result->numRows() > 0){
			$link = $result->fetchRow();
            $page_link = $link['link'];
		}
		
		// get NWI Section
		$query = "SELECT `section_id` FROM `".TABLE_PREFIX."sections` WHERE `page_id`=$page_id AND `module`='news_img'";
		$result = $database->query($query);
		if(is_object($result) && $result->numRows() > 0){
			$section_id_array = $result->fetchRow();
            $section_id = $section_id_array['section_id'];
		}
		
		// convert all numeric inputs to integer variables
		$page_id = (int) $page_id;
		$output = "";
		if($display_option==0 or $display_option==2){ //show categories

			// query to obtain categories for the selected page
	  		$query = "SELECT * FROM `" .TABLE_PREFIX ."mod_news_img_groups` WHERE `section_id`=$section_id";

			// make database query and obtain active groups and amount of posts per group
			$result = $database->query($query);
			if(is_object($result) && $result->numRows() > 0){
				if ($group_header != "") {
					echo $group_header;
				}				
				while($group = $result->fetchRow()){
	                $id = $group['group_id'];
					$query_detail = "SELECT * FROM `" .TABLE_PREFIX ."mod_news_img_posts` WHERE `section_id`=$section_id AND `active`=1 AND `group_id`=$id;";
					$detail_result = $database->query($query_detail);
					$num = $detail_result->numRows();
					$output .=	"<li><a href=\"" .WB_URL.PAGES_DIRECTORY .$page_link .PAGE_EXTENSION ."?g=".$group['group_id']."\">" .$group['title'] ."</a> (".$num.")</li>\n";
	      		}
			}			
			$output = "<ul>".$output."</ul>";
	        echo $output;
		}
		if($display_option==0 or $display_option==1){ //show history

	        //determine sorting method
	        switch($date_option){
	            case 0:
	                $date = "posted_when";
	                break;
	            case 1:
	                $date = "published_when";
	                break;
	        }

			$output = "";
	        //query to obtain history per month for the selected page
	        $query = "SELECT MONTHNAME(FROM_UNIXTIME(".$date.")) as mo,MONTH(FROM_UNIXTIME(".$date.")) as m,FROM_UNIXTIME(".$date.",'%Y') as y,COUNT(*) as total FROM `" .TABLE_PREFIX ."mod_news_img_posts` WHERE `section_id`=$section_id AND `active`=true GROUP BY y,m ORDER BY y DESC,m DESC;";
	        $result = $database->query($query);
			if(is_object($result) && $result->numRows() > 0){
				if ($history_header != "") {
					echo $history_header;
				}
				while($history = $result->fetchRow()){
					if (LANGUAGE=="DE") {
						$array_1 = array ( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 
						'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
						'1st','2nd','3rd','4th','5th','6th', '7th', '8th', '9th', '0th'  );
						$array_2 = array ( 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag',
						'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember',
						'1.', '2.', '3.', '4.', '5.', '6.', '7.', '8.', '9.', '0.'
						 );

						for ( $x = 0; $x < sizeof($array_1); $x++ )
						{							
						  $history['mo']= str_replace ( $array_1[$x], $array_2[$x], $history['mo']);
						}
					}
	                $output .= "<li><a href=\"" .WB_URL.PAGES_DIRECTORY .$page_link .PAGE_EXTENSION ."?y=".$history['y']."&m=".$history['m']."&method=".$date_option."\">" .$history['mo']." ".$history['y']."</a> (".$history['total'].")</li>\n";
	            	}
	        	}
			$output = "<ul>".$output."</ul>";
	        echo $output;
		}

	}
}
?>