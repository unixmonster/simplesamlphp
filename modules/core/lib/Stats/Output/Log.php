<?php

/**
 * Statistics logger that writes to the default logging handler.
 *
 * @package SimpleSAMLphp
 */

class sspmod_core_Stats_Output_Log extends \SimpleSAML\Stats\Output
{
	/**
	 * The logging function we should call.
	 * @var callback
	 */
	private $logger;


	/**
	 * Initialize the output.
	 *
	 * @param \SimpleSAML\Configuration $config  The configuration for this output.
	 */
	public function __construct(\SimpleSAML\Configuration $config) {
		$logLevel = $config->getString('level', 'notice');
		$this->logger = array('\SimpleSAML\Logger', $logLevel);
		if (!is_callable($this->logger)) {
			throw new \Exception('Invalid log level: ' . var_export($logLevel, TRUE));
		}
	}


	/**
	 * Write a stats event.
	 *
	 * @param string $data  The event (as a JSON string).
	 */
	public function emit(array $data) {
		$str_data = json_encode($data);
		call_user_func($this->logger, 'EVENT ' . $str_data);
	}
}
