<?php
	/**
	 * Not much here, I know. But this code must be able to be called dynamically from javascipt, so the only option
	 * is to place it in it's own php file and call it in the background.
	 */

	session_start();

	session_destroy();
?>