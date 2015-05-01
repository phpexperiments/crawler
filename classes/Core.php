<?php 

class Core 
{ 
	
	var $mode;
	var $crawlerUrl;
	var $domDocument;
	var $crawledData;
	var $execution;
	
	public function __construct()
	{		
		$this->setMode();
	}
	
	//Set mode
	public function setMode()
	{
		$this->mode = php_sapi_name();
	}	
	
	//Check for CLI
	public function isCommandLineInterface()
	{
		return ($this->mode === 'cli');
	}
	
	//Parse CLI arguments
	public function parseCliArguments($argv = array())
	{
		parse_str(implode('&', array_slice($argv, 1)), $_GET);
		$this->setCrawlerUrl();
	}
	
	//Set Crawler Url	
	public function setCrawlerUrl()
	{
		$this->crawlerUrl = isset($_GET['url']) ? $_GET['url'] : '';
	}
	
	//Check Valid Url
	public function validateUrl()
	{
		return (!filter_var($this->crawlerUrl, FILTER_VALIDATE_URL) === false);
	}	
	
	//set Crawler Data
	public function serCrawlerData($dom)
	{
		$this->domDocument = new DOMDocument();
		@$this->domDocument->loadHTML($dom);
		$this->getCrawledUrls();
		$this->getCrawledImages();
	}	
	
	//Get Crawled URLs
	public function getCrawledUrls()
	{
		$documentLinks = $this->domDocument->getElementsByTagName("a");
		for($i=0;$i<$documentLinks->length;$i++) 
		{
			$documentLink = $documentLinks->item($i);
			$this->crawledData['urls'][] = $documentLink->getAttribute("href");
		}
		$this->sortCrawledUrls();
	}
	
	//Get Crawled Images
	public function getCrawledImages()
	{
		$documentImages = $this->domDocument->getElementsByTagName("img");
		for($i=0;$i<$documentImages->length;$i++) 
		{
			$documentImage = $documentImages->item($i);
			$this->crawledData['images'][] = $documentImage->getAttribute("src");
		}
	}
	
	//Sort Crawled Urls
	public function sortCrawledUrls()
	{
		asort($this->crawledData['urls']);
	}	
	
	//Init Execution Time
	public function initExecutionTime()
	{
		$this->execution['startTime'] = microtime(true);
	}	
	
	//Stop Execution Time
	public function stopExecutionTime()
	{
		$this->execution['endTime'] = microtime(true);
	}
	
	//Show Execution Time
	public function showExecutionTime()
	{
		$this->stopExecutionTime();
		$execution_time = ($this->execution['endTime'] - $this->execution['startTime'])/60;
		//execution time of the script
		echo "\n------------------------------------------------------------------\n";
		echo "Total Execution Time : " . $execution_time . " Mins\n\n";
	}
	
	//Show Crawler Result
	public function showCrawlerResult()
	{
		$crawledUrls = isset($this->crawledData['urls']) ? $this->crawledData['urls'] : array();
		$crawledImages = isset($this->crawledData['images']) ? $this->crawledData['images'] : array();
		
		$crawledUrlCount = count($crawledUrls);
		$crawledImageCount = count($crawledImages);
		
		echo "\n\n##################################################################\n";
		echo "Web Page : " . $this->crawlerUrl . " \n";
		echo "##################################################################\n";
		
		echo "\nTotal Urls Found : " . $crawledUrlCount . " \n";
		echo "Total Images Found : " . $crawledImageCount . " \n";
		echo "------------------------------------------------------------------\n\n";
		
		if($crawledUrlCount > 0){
			echo "Report : URLS\n\n";
			$mask = "|%5s |%-30s\n";
			printf($mask, 'No:', 'URL');
			$i = 1;
			foreach($crawledUrls as $urls)
			{
				printf($mask, $i, $urls);
				$i++;
			}	
		}
		if($crawledImageCount > 0){
			echo "\n------------------------------------------------------------------\n";
			echo "Report : Images\n\n";
			$mask = "|%5s |%-30s\n";
			printf($mask, 'No:', 'Image');
			$i = 1;
			foreach($this->crawledData['images'] as $images)
			{
				printf($mask, $i, $images);
				$i++;
			}
		}			
	}
}
