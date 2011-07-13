<?php

// constant API_DIR must be defined

/**
 * ...
 */
class ApiDirect
{
	/// KohoVolit.eu project to access through this API client
	private $project;

	/// default search params - parameters to include to each API resource request
	private $default_params;

	/// default data - data to include to each API resource request
	private $default_data;

	/**
	 * ...
	 */
	public function __construct($project, $default_params = null, $default_data = null)
	{
		$this->project = $project;
		$this->default_params = $default_params;
		$this->default_data = $default_data;
	}

	/**
	 * ...
	 */
	public function read($resource, $params = null)
	{
		$this->includeApiResourceClass($resource);
		$full_params = (array)$params + (array)$this->default_params;
		return $resource::read($full_params);
	}

	/**
	 * ...
	 */
	public function create($resource, $data = null)
	{
		$this->includeApiResourceClass($resource);
		$full_data = (array)$data + (array)$this->default_data;
		return $resource::create($full_data);
	}

	/**
	 * ...
	 */
	public function update($resource, $params = null, $data = null)
	{
		$this->includeApiResourceClass($resource);
		$full_params = (array)$params + (array)$this->default_params;
		$full_data = (array)$data + (array)$this->default_data;
		return $resource::update($full_params, $full_data);
	}

	/**
	 * ...
	 */
	public function delete($resource, $params = null)
	{
		$this->includeApiResourceClass($resource);
		$full_params = (array)$params + (array)$this->default_params;
		return $resource::delete($full_params);
	}

	/**
	 * ...
	 */
	private function includeApiResourceClass($resource)
	{
		require_once  API_DIR . '/config/settings.php';
		require_once  API_DIR . '/setup.php';
		@include_once API_DIR . "/projects/{$this->project}/config/settings.php";
		@include_once API_DIR . "/projects/{$this->project}/setup.php";
		$ok = @include_once API_DIR . "/projects/{$this->project}/resources/$resource.php";
		if (!$ok)
			throw new \Exception("There is no API resource <em>$resource</em> in <em>{$this->project}</em> project.", 404);
	}
}

?>
