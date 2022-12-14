-----------------------------------------------------------------------------------------
 Code snippet NwI Blog Menu v0.3 
 Licencsed under GNU
 written by Erik Coenjaerts (Eki), updated by florian for WBCE / News with Images
-----------------------------------------------------------------------------------------

*****************************************************************************************
 SHORT INSTALLATION GUIDE:
*****************************************************************************************
 o download the Blog Menu zip file from the WBCE Addons repository
 o log into the backend and install the module as usual
 o Be sure to have the module News with Images (not "News") installed 
 
*****************************************************************************************
 USING THE SNIPPET FUNCTION:
*****************************************************************************************
Once the module is installed, it can be invoked either from the index.php file of your 
template or from any code module section.

From template index.php:
<?php display_blog_menu(8); ?>

From a code module:
display_blog_menu(8);

(8 = example, replace with actual page id of the News with Images section to display)

*****************************************************************************************
 ADDITIONAL PARAMETERS
*****************************************************************************************
For a more customised output, you can pass over serveral parameters to the function 
explained below.

display_blog_menu($page_id,$date_option,$group_header,$history_header)

Optional Parameters:
  page_id... 		the page_id of the news page you want to generate the Blog Menu from
  date_option... 	0:=count articles according the posted date (default); 
					1:= count articles according the published date
  group_header... 	header above the group menu (default: '<h1>Categories</h1>')
  history_header... header above the history menu (default: '<h1>History</h1>')
  display_option... 0:=show both history and categories (default); 
					1:=show only history; 
					2:=show only categories

Example for customised call:
<?php display_blog_menu(15,1,'<h2>categories</h2>','<h2>history</h2>',2);?>

*****************************************************************************************
 TROUBLE SHOOTING
*****************************************************************************************
 - pass over at least the first argument ($page_id)
 - make sure you use the page_id of the NWI page, not their section_id 
 - mask text with "your text " or 'your text '
 - within your template index.php file use: <?php display_blog_menu(); ?>
 - within a code2 module section use: display_blog_menu();
 - remind the ; at the end of the code line

*****************************************************************************************
 STYLE THE OUTPUTS ACCORDING YOUR NEEDS
*****************************************************************************************
The output can be customized to your needs without touching the code itself, by the 
use of CSS definitions. 
Open a code page and enter the following code:

echo "<div id=\"myblog\">";
display_blog_menu(12);
echo "</div>";

The additional div section can be used to restrict the style defintions to the blog 
menu only, without influencing the rest of your layout. 