<?php
// page registering
	$regURL[0]		= 'home';						$regPage[0] = 'home.php';		// => also as default page
	
	$regURL[]		= 'karyawan';					$regPage[] = '../master-data/karyawan.php';
	$regURL[]		= 'agenda';						$regPage[] = 'agenda.php';
	$regURL[]		= 'galeri';						$regPage[] = 'galeri.php';
	$regURL[]		= 'artikel';					$regPage[] = 'artikel.php';
	
// page translation, $pg = dari URL 
class pageToLoad
{
	var $regURL;
	var $regPage;
	var $pg;
	
	function pageToLoad()
	{
		$this->pg = $_GET['pg'];
	}
	
	function loadPage()
	{
		if(in_array($this->pg, $this->regURL))
		{
			foreach($this->regURL as $key => $value)
			{
				if($value == $this->pg)
				{
					$pageIndex = $key;
				}
			}
			
			$loadPage = $this->regPage[$pageIndex];
		}
		else
		{
			$loadPage = $this->regPage[0];
		}
		
		return $loadPage;
	}
}

// instantiate
$page_to_load = new pageToLoad();
$page_to_load->regURL = $regURL;
$page_to_load->regPage = $regPage;
?>