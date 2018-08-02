<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Laravel\Lumen\Application;

	class ResponseService
	{

		public $app;

		public $helpers;

		public function __construct(Application $app)
		{
			$this->app = $app;
			$this->helpers = app('HelpersService');
		}

		/*
		 * @param $content => message to send with response
		 * @param $status => status response
		 * @param $header => array of headers to add to response
		 * @param $options
		 *
		 * @response json
		 */
		public function custom($content, $status = 200, array $headers = [], $options = 0)
		{
			if (empty($content))
				$this->custom(["message" => null]);

			return response()->json($content, $status, $headers, $options);
		}

		/*
		 * generic success response
		 *
		 * @param $content => message to send with response
		 *
		 * @response with custom method
		 */
		public function success($content = "")
		{
			return $this->custom(['message' => $content ? $content : "success"], 200);
		}

		/*
		 * error response
		 *
		 * @param $type => type of error(use Dingo response)
		 * @param $content => message to send with response
		 *
		 * @response with dingo method or custom
		 */
		public function error($type = "generic", $content = "")
		{
			switch ($type) {
				case "error":
					// A generic error with custom message and status code.
					return $this->helpers->response->error($content ? $content : 'This is an error.', 404);
					break;

				case "notFound":
					// A not found error with an optional message as the first parameter.
					return $this->helpers->response->errorNotFound();
					break;

				case "badRequest":
					// A bad request error with an optional message as the first parameter.
					return $this->helpers->response->errorBadRequest();
					break;

				case "forbidden":
					// A forbidden error with an optional message as the first parameter.
					return $this->helpers->response->errorForbidden();
					break;

				case "internal":
					// An internal error with an optional message as the first parameter.
					return $this->helpers->response->errorInternal();
					break;

				case "unauthorized":
					// An unauthorized error with an optional message as the first parameter.
					return $this->helpers->response->errorUnauthorized();
					break;

				case "generic":
					return $this->custom(['message' => $content ? $content : "generic error"], 400);
					break;
			}
		}
	}