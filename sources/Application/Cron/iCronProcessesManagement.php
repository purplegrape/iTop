<?php

/*
 * @copyright   Copyright (C) 2010-2026 Combodo SAS
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

namespace Combodo\iTop\Application\Cron;

/**
 * Interface for managing cron processes, providing methods to retrieve and set
 * the number of allowed processes, as well as enabling or disabling cron functionality.
 *
 * @api
 * @since 3.x.0
 */
interface iCronProcessesManagement
{
	/**
	 * @return array
	 */
	public function GetRunningProcesses(): array;

	/**
	 * Get the current running cron processes count
	 *
	 * @return int Number of cron processes currently running
	 */
	public function GetRunningProcessesCount(): int;

	/**
	 * Get the maximum number of processes allowed in parallel
	 *
	 * @return int The maximum number of processes allowed in parallel
	 */
	public function GetMaxRunningProcesses(): int;

	/**
	 * Set the maximum number of processes allowed in parallel
	 *
	 * @param int $iMaxRunningProcesses The max number of parallel cron allowed
	 */
	public function SetMaxRunningProcesses(int $iMaxRunningProcesses): void;

	/**
	 * Stop the cron on all servers.
	 * The method only returns when all the processes are stopped even if
	 * multiple calls are done to this method on multiple servers.
	 *
	 * @param int $iWaitLimitInSec Max time in seconds to wait for termination
	 *
	 * @return void
	 * @throws \Combodo\iTop\Application\Cron\CronProcessesNotStoppedException when "wait time limit" is exceeded
	 */
	public function StopAndWaitCronTermination(int $iWaitLimitInSec): void;

	/**
	 * Enables the cron processes to run.
	 *
	 * @return void
	 */
	public function StartCron(): void;
}
