<?php
include_once('metaModel.php');
class meta extends metaModel{
	public $metaDescription = '';
	public $metaKeywords = '';
	public $siteUrl ='';
	
	public function retreiveMetaDetails($siteUrl){
		
		$response = $this->curl(trim($siteUrl));
        
		$data = $this->parse_xml($response);
        $data['site_url'] = $siteUrl;
        
		$id = $this->findSite($siteUrl);
		if ($id !== false)
			$data['id'] = $id['id'];
		$this->updateMetaDetails($data);
	}
	
	public function validSiteUrl($siteUrl){
		// Remove all illegal characters from a url
		$siteUrl = filter_var($siteUrl, FILTER_SANITIZE_URL);

		// Validate url
		if (!filter_var($siteUrl, FILTER_VALIDATE_URL) === false) {
			echo("$siteUrl is a valid URL");
		} else {
			echo("$siteUrl is not a valid URL");
		}
	}
	public function curl($siteUrl)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $siteUrl);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
	public function parse_xml($data){
		//parsing begins here:
		$doc = new DOMDocument();
		$doc->loadHTML($data);
		$nodes = $doc->getElementsByTagName('title');
        
		//get and display what you need:
		$title = $nodes->item(0)->nodeValue;

		$metas = $doc->getElementsByTagName('meta');
        echo $title;
        die;
		for ($i = 0; $i < $metas->length; $i++)
		{
			$meta = $metas->item($i);
			if($meta->getAttribute('name') == 'description')
				$description = $meta->getAttribute('content');
			if($meta->getAttribute('name') == 'keywords')
				$keywords = $meta->getAttribute('content');
		}
		return array('meta_description'=>$description,'meta_keyword'=>$keywords);

	}
}