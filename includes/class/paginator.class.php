<?php
/*
 * PHP Pagination Class
 * @author admin@catchmyfame.com - http://www.catchmyfame.com
 * @version 2.0.0
 * @date October 18, 2011
 * @copyright (c) admin@catchmyfame.com (www.catchmyfame.com)
 * @license CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) - http://creativecommons.org/licenses/by-sa/3.0/
 */
class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $limit;
	var $return;
	var $url;
	var $ipp_array;

	function __construct()
	{
		$this->current_page = 1;
		$this->mid_range = 5;
		$this->ipp_array = array(10,25,50,100);
		$this->items_per_page = 15;
	}

	function paginate()
	{
		global $config, $pageURL, $GET;
		$this->url = isset($this->url) ? $this->url : $pageURL;
		if($this->url[strlen($this->url)-1] == "/")
		  $this->url = substr($this->url,0,-1);
    
		$this->num_pages = ceil($this->items_total/$this->items_per_page);
		
		$this->current_page = isset($GET["page"]) ? (int) $GET["page"] : 1; 

		$prev_page = $this->current_page - 1;
		$next_page = $this->current_page + 1;

		$this->return = "<ul class='pagination'>";

		if($this->num_pages > 10)
		{
	
			if ($this->current_page > 1)
			{
				$this->return .= "<li ><a title='Go to page 1' href='$this->url/page/1'><span class='glyphicon glyphicon-fast-backward'></span></a></li>";
				$this->return .= "<li ><a title='Previous page ($prev_page)' href='$this->url/page/$prev_page'><span class='glyphicon glyphicon-backward'></span> &nbsp;&nbsp;Prev</a></li>";
			}
		

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "<li class='disabled'><a >..</a></li>";
				// loop through acersdc pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					if($this->current_page==$i)
					$this->return.=" <li class='disabled' title='Go to page $i'><a >$i</a></li>";
					else
					$this->return.= "<li><a href='$this->url/page/$i' title='Go to page $i'>$i</a></li>";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= "<li class='disabled'><a >..</a></li>";
			}
			
			if ($this->current_page < $this->num_pages)
			{
				$this->return .= "<li ><a title='Next page ($next_page)' href='$this->url/page/$next_page'>Next &nbsp;&nbsp;<span class='glyphicon glyphicon-forward'></span></a></li>";
				$this->return .= "<li ><a title='Go to page $this->num_pages' href='$this->url/page/$this->num_pages'><span class='glyphicon glyphicon-fast-forward'></span></a></li>";
			}
		}
		elseif($this->num_pages>1)
		{
			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->current_page==$i)
					$this->return .= "<li class='active disabled'><a >$i</a></li>";
				else
					$this->return .= sprintf(" <li><a href='%s/page/%s'>%s</a></li>", $this->url, $i, $i);
			}
		}
		$this->low = ($this->current_page <= 0) ? 0:($this->current_page-1) * $this->items_per_page;
	
	
		if($this->low+$this->items_per_page < $this->items_total)
			$this->items_total = $this->items_per_page;
			
		$this->limit = " LIMIT $this->low,$this->items_total";
		
		$this->return.="</ul>";
	}
	

	function display_pages()
	{
		return $this->return;
	}
}