<?php

class Result{
	public $attributes = array();

	function add_attribute($name,$value)
	{
		array_push($this->attributes,array($name,$value));
	}
}

class Response{
	private $xml = null;
	private $results = array();

	public function __construct($child){
		$this->xml = new SimpleXMLElement("<$child></$child>");
	}

	function add_result()
	{		
		$result = new Result();
		array_push($this->results,$result);

		return $result;
	}

	function run()
	{

		foreach($this->results as $result)
		{
			$res = $this->xml->addChild('Result');

			foreach($result->attributes as $attribute)
			{
				$res->addAttribute($attribute[0],$attribute[1]);
			}
		}
		print($this->xml->asXML());
		$length = ob_get_length(); 
		header("Content-Length: $length");


		exit;
	}
};

?>