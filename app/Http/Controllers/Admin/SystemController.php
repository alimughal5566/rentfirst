<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Admin;

use App\Helpers\DBTool;
use App\Http\Controllers\Install\Traits\Install\CheckerTrait;
use Larapen\Admin\app\Http\Controllers\PanelController;

class SystemController extends PanelController
{
	use CheckerTrait;
	
	public function systemInfo()
	{
		// System
		$system = [];
		
		$system[] = [
			'name'  => "Server Software",
			'value' => request()->server->get('SERVER_SOFTWARE'),
		];
		$system[] = [
			'name'  => "Document Root",
			'value' => relativeAppPath(request()->server->get('DOCUMENT_ROOT')),
		];
		$system[] = [
			'name'  => "PHP Version",
			'value' => PHP_VERSION,
		];
		$system[] = [
			'name'  => "MySQL Server Version",
			'value' => DBTool::getMySqlFullVersion(),
		];
		
		// Get Requirements & Permissions
		$requirements = array_merge($this->getRequirements(), $this->getAdvancedRequirements());
		$permissions = $this->getPermissions();
		
		$data = [
			'system'       => $system,
			'requirements' => $requirements,
			'permissions'  => $permissions,
		];
		
		$data['title'] = trans('admin.system_info');
		
		return view('admin::system', $data);
	}
	
	/**
	 * @return array[]
	 */
	protected function getAdvancedRequirements()
	{
		$requirements = [];
		
		// Database version
		$databaseCurrentVersion = DBTool::getMySqlVersion();
		if (!DBTool::isMariaDB()) {
			$databaseMinVersion = '5.6';
			$databaseRecommendedVersion = '5.7';
			$databaseIsMySqlDeprecatedVersion = (
				(version_compare($databaseCurrentVersion, $databaseMinVersion) >= 0)
				&& (version_compare($databaseCurrentVersion, $databaseMinVersion . '.9') <= 0)
			);
			$databaseIsMySqlRightVersion = DBTool::isMySqlMinVersion($databaseRecommendedVersion);
			$requirements[] = [
				'type'  => 'requirement',
				'name'  => 'Database Server Version',
				'check' => ($databaseIsMySqlDeprecatedVersion || $databaseIsMySqlRightVersion),
				'note'  => 'The minimum MySQL version required is: <code>' . $databaseMinVersion . '</code>, version <code>' . $databaseRecommendedVersion . '</code> or greater is recommended.',
				'ok'    => $databaseIsMySqlDeprecatedVersion
					? 'MySQL version <code>' . $databaseCurrentVersion . '</code> is not recommended. Upgrade your database to version <code>' . $databaseRecommendedVersion . '</code> or greater.'
					: 'MySQL version <code>' . $databaseCurrentVersion . '</code> is valid.',
			];
		} else {
			$databaseMinVersion = '10.2.3';
			$databaseIsMariaDbRightVersion = (DBTool::isMySqlMinVersion($databaseMinVersion));
			$requirements[] = [
				'type'  => 'requirement',
				'name'  => 'Database Server Version',
				'check' => ($databaseIsMariaDbRightVersion),
				'note'  => 'MariaDB version <code>' . $databaseMinVersion . '</code> or greater is required.',
				'ok'    => 'MySQL version <code>' . $databaseCurrentVersion . '</code> is valid.',
			];
		}
		
		// Server (Apache or Nginx) encoding
		$validCharset = 'UTF-8';
		$currentCharset = ini_get('default_charset');
		$requirements[] = [
			'type'  => 'requirement',
			'name'  => 'Server default_charset',
			'check' => (strtolower(ini_get('default_charset')) == 'utf-8'),
			'note'  => "The server <code>default_charset</code> is: <code>$currentCharset</code>. <code>$validCharset</code> is required.",
			'ok'    => "The server <code>default_charset</code> (<code>$validCharset</code>) is valid.",
		];
		
		// Database server character set & collation
		$defaultConnection = config('database.default');
		$databaseCharset = config("database.connections.{$defaultConnection}.charset");
		$databaseCollation = config("database.connections.{$defaultConnection}.collation");
		if (!in_array($databaseCharset, (array)config('larapen.core.database.charset.recommended'))) {
			$databaseCharset = config('larapen.core.database.charset.default', 'utf8mb4');
		}
		if (!in_array($databaseCollation, (array)config('larapen.core.database.collation.recommended'))) {
			$databaseCollation = config('larapen.core.database.collation.default', 'utf8mb4_unicode_ci');
		}
		
		$requirements[] = [
			'type'  => 'requirement',
			'name'  => 'Database Server Character Set & Collation',
			'check' => DBTool::isValidCharacterSet(),
			'note'  => "The database server variables: <span class=\"font-weight-bolder\">DEFAULT_CHARACTER_SET_NAME</span>, <span class=\"font-weight-bolder\">character_set_client</span>, <span class=\"font-weight-bolder\">character_set_connection</span>, <span class=\"font-weight-bolder\">character_set_database</span> and <span class=\"font-weight-bolder\">character_set_results</span> must to be <code>$databaseCharset</code>. <br>And the variables <span class=\"font-weight-bolder\">DEFAULT_COLLATION_NAME</span>, <span class=\"font-weight-bolder\">collation_connection</span> and <span class=\"font-weight-bolder\">collation_database</span> must to be <code>$databaseCollation</code>.",
			'ok'    => "The database server character set (<code>$databaseCharset</code>) and collation (<code>$databaseCollation</code>) are valid.",
		];
		
		return $requirements;
	}
}
