<?php

namespace Autofactor\SNS\Commands;

use Illuminate\Console\Command;
use Autofactor\SNS\SNS;

/**
 * Class Subscribe
 * @package Autofactor\SNS\Commands
 */
class Subscribe extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sns:subscribe {topic?} {--create}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Subscribes to the SNS topics listed in the "sns" config file.';

	/**
	 * @var \Autofactor\SNS\SNS
	 */
	private $sns;

	/**
	 * Subscribe constructor.
	 *
	 * @param \Autofactor\SNS\SNS $sns
	 */
	public function __construct(SNS $sns)
	{
		parent::__construct();

		$this->sns = $sns;
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		if ($this->argument('topic') !== NULL) {
			$topics = [
				$this->argument('topic'),
			];
		} else {
			$topics = array_keys($this->sns->getSubscriptions());
		}

		$create = $this->option('create');

		foreach ($topics as $topic) {
			if ($create) {
				$this->sns->createTopic($topic);
			}

			$this->sns->subscribe($topic);
		}
	}
}