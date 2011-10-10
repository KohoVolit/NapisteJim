<?php

// API_DIR constant must be defined here and point to your API installation directory when using ApiDirect class.
// The following check handles just internal usage of ApiDirect within the API itself.
if (!defined('API_DIR')) define("API_DIR", API_ROOT);

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
		$resource_class = $this->getApiResourceClass($resource);
		if (!method_exists($resource_class, 'read'))
			throw new Exception("The API resource <em>$resource</em> does not accept read requests.", 405);
		$full_params = (array)$params + (array)$this->default_params;
		return $resource_class->read($full_params);
	}

	/**
	 * ...
	 */
	public function readOne($resource, $params = null)
	{
		$result = $this->read($resource, array('_limit' => 1) + $params);
		return count($result) > 0 ? $result[0] : array();
	}

	/**
	 * ...
	 */
	public function create($resource, $data = null)
	{
		$resource_class = $this->getApiResourceClass($resource);
		if (!method_exists($resource_class, 'create'))
			throw new Exception("The API resource <em>$resource</em> does not accept create requests.", 405);
		$full_data = (array)$data + (array)$this->default_data;
		return $resource_class->create($full_data);
	}

	/**
	 * ...
	 */
	public function update($resource, $params = null, $data = null)
	{
		$resource_class = $this->getApiResourceClass($resource);
		if (!method_exists($resource_class, 'update'))
			throw new Exception("The API resource <em>$resource</em> does not accept update requests.", 405);
		$full_params = (array)$params + (array)$this->default_params;
		$full_data = (array)$data + (array)$this->default_data;
		return $resource_class->update($full_params, $full_data);
	}

	/**
	 * ...
	 */
	public function delete($resource, $params = null)
	{
		$resource_class = $this->getApiResourceClass($resource);
		if (!method_exists($resource_class, 'delete'))
			throw new Exception("The API resource <em>$resource</em> does not accept delete requests.", 405);
		$full_params = (array)$params + (array)$this->default_params;
		return $resource_class->delete($full_params);
	}

	/**
	 * ...
	 */
	private function getApiResourceClass($resource)
	{
		require_once  API_DIR . '/config/settings.php';
		require_once  API_DIR . '/setup.php';
		@include_once API_DIR . "/projects/{$this->project}/config/settings.php";
		@include_once API_DIR . "/projects/{$this->project}/setup.php";
		$ok = include_once API_DIR . "/projects/{$this->project}/resources/$resource.php";
		if (!$ok)
			throw new \Exception("There is no API resource <em>$resource</em> in <em>{$this->project}</em> project.", 404);
		return new $resource;
	}
}

?>
