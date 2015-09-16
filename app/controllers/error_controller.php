<?php

class ErrorController extends AppController
{
	public function denied()
	{
		$this->set(get_defined_vars());
	}
}
