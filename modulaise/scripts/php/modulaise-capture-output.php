<?php

/**
 * Simple class for capturing output
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseCaptureOutput {

	// the captured output
	public $capturedOutput;

	function __construct(){

	}

	/**
	 * Starts capture
	 */
	function start(){
		ob_start();
	}

	/**
	 * Ends capture, and returns captured output
	 */
	function end(){
		$capturedOutput = ob_get_contents();
		ob_end_clean();
		return $capturedOutput;
	}
}

?>