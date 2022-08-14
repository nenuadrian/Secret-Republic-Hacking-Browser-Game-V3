<?php

	

if (!$GET["page"])
  $cardinal->show_404();
else
{
  if(ctype_alnum(str_replace(array("-", "_"), "", $GET["page"])))
  {
    if(file_exists("../templates/pages/".$GET["page"].".tpl"))
    { 
		if ($GET["page"] == "typography")
			{
			$pages = new Paginator();
			$pages->items_total = 1000;
				
			$pages->paginate();
			
			$cardinal->addMessenger("EAAf141 13513eg$#^ !#%145");
			$cardinal->addMessenger("EAAf141 13513eg$#^ !#%145", "success");
			$cardinal->addMessenger("EAAf141 13513eg$#^ !#%145", "error");
		}
		elseif ($GET['page'] == "media")
		{
			require("../includes/constants/abilities.php");
			$tVars['abilities'] = abilities(null, null);
		}
      $tVars["display"] = "pages/".$GET["page"].".tpl";
		
    } else $cardinal->show_404();
  
  } else $cardinal->show_404();


}
	

?>
