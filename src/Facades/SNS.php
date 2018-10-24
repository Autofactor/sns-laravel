<?php

namespace Autofactor\SNS\Facades;

use Illuminate\Support\Facades\Facade;
use Autofactor\SNS\SNS as BaseSNS;

class SNS extends Facade
{
	protected static function getFacadeAccessor()
	{
		return BaseSNS::class;
	}
}