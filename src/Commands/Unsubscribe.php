<?php

namespace Autofactor\SNS\Commands;

use Illuminate\Console\Command;
use Autofactor\SNS\SNS;

/**
 * Class Unsubscribe
 * @package Autofactor\SNS\Commands
 */
class Unsubscribe extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sns:unsubscribe {topic?} {--delete}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Unsubscribes to the SNS topics listed in the "sns" config file.';

	/**
	 * @var \Autofactor\SNS\SNS
	 */
	private $sns;

	/**
	 * Unsubscribe constructor.
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

		$delete = $this->option('delete');

		foreach ($topics as $topic) {
			$this->sns->unsubscribe($topic);

			if ($delete) {
				$this->sns->deleteTopic($topic);
			}
		}
	}
}