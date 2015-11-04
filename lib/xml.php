<? 
$nadtytul='';
$tytul='';

$filename = './modules/menu.xml'; 
$obj->tree = '$obj->xml'; 
$obj->xml = ''; 


function startElement($parser, $name, $attrs) { 
   global $obj; 
   
   // If var already defined, make array 
   eval('$test=isset('.$obj->tree.'->'.$name.');'); 
   if ($test) { 
     eval('$tmp='.$obj->tree.'->'.$name.';'); 
     eval('$arr=is_array('.$obj->tree.'->'.$name.');'); 
     if (!$arr) { 
       eval('unset('.$obj->tree.'->'.$name.');'); 
       eval($obj->tree.'->'.$name.'[0]=$tmp;'); 
       $cnt = 1; 
     } 
     else { 
       eval('$cnt=count('.$obj->tree.'->'.$name.');'); 
     } 
     
     $obj->tree .= '->'.$name."[$cnt]"; 
   } 
   else { 
     $obj->tree .= '->'.$name; 
   } 
   if (count($attrs)) { 
       eval($obj->tree.'->attr=$attrs;'); 
   } 
} 

function endElement($parser, $name) { 
   global $obj; 
   // Strip off last -> 
   for($a=strlen($obj->tree);$a>0;$a--) { 
       if (substr($obj->tree, $a, 2) == '->') { 
           $obj->tree = substr($obj->tree, 0, $a); 
           break; 
       } 
   } 
} 

function characterData($parser, $data) { 
   global $obj; 

   eval($obj->tree.'->data=\''.$data.'\';'); 
} 

$xml_parser = xml_parser_create(); 
xml_set_element_handler($xml_parser, "startElement", "endElement"); 
xml_set_character_data_handler($xml_parser, "characterData"); 
if (!($fp = fopen($filename, "r"))) { 
   die("could not open XML input"); 
} 
while ($data = fread($fp, 4096)) { 
   if (!xml_parse($xml_parser, $data, feof($fp))) { 
      die(sprintf("XML error: %s at line %d", 
                  xml_error_string(xml_get_error_code($xml_parser)), 
                  xml_get_current_line_number($xml_parser))); 
	} 
} 
xml_parser_free($xml_parser); 

function generate_pullmenu($xml) {
$i=0;
$ret = 'menuBar(new Array(';

	foreach($xml->FINKAMENU->MENU as $menu) {
		if ($i>-1) {
			$ret.="menuBarItem($i,'','".$menu->NAME->data."',";
			$j=0;
			if (count($menu->MENU_PULLDOWN)>0) {
				$ret.='new Array(';
				foreach($menu->MENU_PULLDOWN as $pulldown){
					if ($j>-1) $ret.="menuItem('".$pulldown->NAME->data."','./index.php?m=$i&p=$j'),";
					$j++;
				}
				$ret=substr($ret,0,strlen($ret)-1);
				$ret.=')';
			} else $ret.="'./index.php?m=$i&p=-1'";
			$ret.='),';
		}
		$i++;
	}
	$ret=substr($ret,0,strlen($ret)-1);
	return $ret.'));';

}


function generate_leftmenu($xml, $lmenu, $lpullmenu) {
	global $nadtytul, $l, $tytul;
	$i=0;
	foreach($xml->FINKAMENU->MENU as $menu) {
		$j=0;
		if (count($menu->MENU_PULLDOWN)>0) {
			foreach($menu->MENU_PULLDOWN as $pulldown){
				if (($j==$lpullmenu)&&($i==$lmenu)) {
					$nadtytul=$pulldown->NAME->data;
					echo "<tr><td class=menu_left_group><b>".$menu->NAME->data."</b><BR>".$pulldown->NAME->data."</td><td class=menu_left_group_end>&nbsp;</td></tr>";
					$k=0;
					if (count($pulldown->MENU_LEFT)>0) {
						foreach($pulldown->MENU_LEFT as $left){
							echo "<tr><td class=menu_left_item ".menu_focus($i, $j, $k).">".$left->NAME->data."</td><td class=menu_left_item_end>&nbsp;</td></tr>";
							if ($k==$l) $tytul=$left->NAME->data;
							$k++;
						}
					}
				}
				$j++;
			}
		} else if (($i==$lmenu)) {
			echo "<tr><td class=menu_left_group><b>".$menu->NAME->data."<b></td><td class=menu_left_group_end>&nbsp;</td></tr>";
			$nadtytul=$menu->NAME->data;
			$k=0;
			$j=-1;		
			if (count($menu->MENU_LEFT)>0) {
				foreach($menu->MENU_LEFT as $left){
					echo "<tr><td class=menu_left_item ".menu_focus($i, $j, $k).">".$left->NAME->data."</td><td class=menu_left_item_end>&nbsp;</td></tr>";
					if ($k==$l) $tytul=$left->NAME->data;
					$k++;
				}
			}

		}
		
		$i++;
	}
}

//print_r($obj->xml->FINKAMENU->MENU[1]->MENU_PULLDOWN); 
return 0; 

?> 
