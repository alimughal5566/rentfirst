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

namespace App\Http\Controllers\Install\Traits\Install;

use App\Helpers\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait CheckerTrait
{
	/**
	 * Is Manual Checking Allowed
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return bool
	 */
	protected function isManualCheckingAllowed(Request $request)
	{
		if ($request->has('mode') && $request->get('mode') == 'manual') {
			return true;
		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	protected function checkRequirements()
	{
		$requirements = $this->getRequirements();
		
		$success = true;
		foreach ($requirements as $requirement) {
			if (!$requirement['check']) {
				$success = false;
			}
		}
		
		return $success;
	}
	
	/**
	 * @return bool
	 */
	protected function checkPermissions()
	{
		$permissions = $this->getPermissions();
		
		$success = true;
		foreach ($permissions as $permission) {
			if (!$permission['check']) {
				$success = false;
			}
		}
		
		return $success;
	}
	
	/**
	 * @return bool
	 */
	private function checkStoragePermissions()
	{
		$permissions = $this->getStoragePermissions();
		
		$success = true;
		foreach ($permissions as $path => $permission) {
			if (!$permission) {
				$success = false;
			}
		}
		
		return $success;
	}
	
	/**
	 * @return array[]
	 */
	protected function getRequirements()
	{
		$requiredPhpVersion = $this->getComposerRequiredPhpVersion();
		
		return [
			[
				'type'  => 'requirement',
				'name'  => 'PHP version',
				'check' => version_compare(PHP_VERSION, $requiredPhpVersion, '>='),
				'note'  => 'PHP <code>' . $requiredPhpVersion . '</code> or higher is required.',
				'ok'    => 'The PHP version <code>' . PHP_VERSION . '</code> is valid.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'OpenSSL Extension',
				'check' => extension_loaded('openssl'),
				'note'  => 'OpenSSL PHP Extension is required.',
				'ok'    => 'OpenSSL PHP Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'Mbstring PHP Extension',
				'check' => extension_loaded('mbstring'),
				'note'  => 'Mbstring PHP Extension is required.',
				'ok'    => 'Mbstring PHP Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PDO PHP Extension',
				'check' => extension_loaded('pdo'),
				'note'  => 'PDO PHP Extension is required.',
				'ok'    => 'PDO PHP Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'MySQL driver for PDO',
				'check' => extension_loaded('pdo_mysql'),
				'note'  => 'MySQL driver for PDO is required.',
				'ok'    => 'MySQL driver for PDO is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'Tokenizer PHP Extension',
				'check' => extension_loaded('tokenizer'),
				'note'  => 'Tokenizer PHP Extension is required.',
				'ok'    => 'Tokenizer PHP Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'XML PHP Extension',
				'check' => extension_loaded('xml'),
				'note'  => 'XML PHP Extension is required.',
				'ok'    => 'XML PHP Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PHP Fileinfo Extension',
				'check' => extension_loaded('fileinfo'),
				'note'  => 'PHP Fileinfo Extension is required.',
				'ok'    => 'PHP Fileinfo Extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PHP CURL extension',
				'check' => extension_loaded('curl'),
				'note'  => 'PHP CURL extension is required.',
				'ok'    => 'PHP CURL extension is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'PHP GD Library',
				'check' => (extension_loaded('gd') && function_exists('gd_info')),
				'note'  => 'PHP GD Library is required.',
				'ok'    => 'PHP GD Library is installed.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'escapeshellarg()',
				'check' => func_enabled('escapeshellarg'),
				'note'  => 'The PHP <code>escapeshellarg()</code> function must be enabled.',
				'ok'    => 'The PHP <code>escapeshellarg()</code> function is enabled.',
			],
			[
				'type'  => 'requirement',
				'name'  => 'exec()',
				'check' => func_enabled('exec'),
				'note'  => 'The PHP <code>exec()</code> function must be enabled.',
				'ok'    => 'The PHP <code>exec()</code> function is enabled.',
			],
		];
	}
	
	/**
	 * @return array[]
	 */
	protected function getPermissions()
	{
		$message = 'The directory must be writable by the web server (0755).';
		$rMessage = 'The directory must be writable (recursively) by the web server (0755).';
		$okMessage = 'The directory is writable with the right permissions.';
		$rOkMessage = 'The directory is writable (recursively) with the right permissions.';
		
		return [
			[
				'type'  => 'permission',
				'name'  => base_path('bootstrap/cache'),
				'check' => file_exists(base_path('bootstrap/cache'))
					&& is_dir(base_path('bootstrap/cache'))
					&& (is_writable(base_path('bootstrap/cache')))
					&& getPerms(base_path('bootstrap/cache')) >= 755,
				'note'  => $message,
				'ok'    => $okMessage,
			],
			[
				'type'  => 'permission',
				'name'  => config_path(),
				'check' => file_exists(config_path())
					&& is_dir(config_path())
					&& (is_writable(config_path()))
					&& getPerms(config_path()) >= 755,
				'note'  => $message,
				'ok'    => $okMessage,
			],
			[
				'type'  => 'permission',
				'name'  => public_path(),
				'check' => file_exists(public_path())
					&& is_dir(public_path())
					&& (is_writable(public_path()))
					&& getPerms(public_path()) >= 755,
				'note'  => $message,
				'ok'    => $okMessage,
			],
			[
				'type'  => 'permission',
				'name'  => storage_path(),
				'check' => $this->checkStoragePermissions(),
				'note'  => $rMessage,
				'ok'    => $rOkMessage,
			],
		];
	}
	
	/**
	 * @return array
	 */
	private function getStoragePermissions()
	{
		$paths = [
			'/',
			'app/public/app',
			'app/public/app/categories/custom',
			'app/public/app/logo',
			'app/public/app/page',
			'app/public/files',
			'framework',
			'framework/cache',
			'framework/plugins',
			'framework/sessions',
			'framework/views',
			'logs',
		];
		
		$permissions = [];
		
		foreach ($paths as $path) {
			$fullPath = storage_path($path);
			
			// Create path if it does not exist
			if (!File::exists($fullPath)) {
				try {
					File::makeDirectory($fullPath, 0777, true);
				} catch (\Exception $e) {
				}
			}
			
			// Get the path permission
			$permissions[$fullPath] = (file_exists($fullPath)
				&& is_dir($fullPath)
				&& (is_writable($fullPath))
				&& getPerms($fullPath) >= 755);
		}
		
		return $permissions;
	}
	
	/**
	 * Get the composer.json required PHP version
	 *
	 * @return int|mixed|string
	 */
	private function getComposerRequiredPhpVersion()
	{
		$filePath = base_path('composer.json');
		
		$content = file_get_contents($filePath);
		$array = json_decode($content, true);
		
		if (!isset($array['require']) || !isset($array['require']['php'])) {
			echo "<pre><strong>ERROR:</strong> Impossible to get the composer.json's required PHP version value.</pre>";
			exit();
		}
		
		return Number::getFloatRawFormat($array['require']['php']);
	}
}
