<?php declare(strict_types=1);
/**
 * @package MerchiPlugin
 */

namespace Inc\Base;

class Deactivate {
	public function __construct() {
		flush_rewrite_rules();
	}
}
