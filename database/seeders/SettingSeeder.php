<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$entries = [
			[
				'key'         => 'app',
				'name'        => 'Application',
				'value'       => null,
				'description' => 'Application Setup',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '2',
				'rgt'         => '3',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'style',
				'name'        => 'Style',
				'value'       => null,
				'description' => 'Style Customization',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '4',
				'rgt'         => '5',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'listing',
				'name'        => 'Listing & Search',
				'value'       => null,
				'description' => 'Listing & Search Options',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '6',
				'rgt'         => '7',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'single',
				'name'        => 'Ads (Form & Single Page)',
				'value'       => null,
				'description' => 'Ads (Form & Single Page) Options',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '8',
				'rgt'         => '9',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'mail',
				'name'        => 'Mail',
				'value'       => null,
				'description' => 'Mail Sending Configuration',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '10',
				'rgt'         => '11',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'sms',
				'name'        => 'SMS',
				'value'       => null,
				'description' => 'SMS Sending Configuration',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '12',
				'rgt'         => '13',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'upload',
				'name'        => 'Upload',
				'value'       => null,
				'description' => 'Upload Settings',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '14',
				'rgt'         => '15',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'geo_location',
				'name'        => 'Geo Location',
				'value'       => null,
				'description' => 'Geo Location Configuration',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '16',
				'rgt'         => '17',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'security',
				'name'        => 'Security',
				'value'       => null,
				'description' => 'Security Options',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '18',
				'rgt'         => '19',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'social_auth',
				'name'        => 'Social Login',
				'value'       => null,
				'description' => 'Social Network Login',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '20',
				'rgt'         => '21',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'social_link',
				'name'        => 'Social Network',
				'value'       => null,
				'description' => 'Social Network Profiles',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '22',
				'rgt'         => '23',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'optimization',
				'name'        => 'Optimization',
				'value'       => null,
				'description' => 'Optimization Tools',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '24',
				'rgt'         => '25',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'seo',
				'name'        => 'SEO',
				'value'       => null,
				'description' => 'SEO Tools',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '26',
				'rgt'         => '27',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'other',
				'name'        => 'Others',
				'value'       => null,
				'description' => 'Other Options',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '28',
				'rgt'         => '29',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'cron',
				'name'        => 'Cron',
				'value'       => null,
				'description' => 'Cron Job',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '30',
				'rgt'         => '31',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'footer',
				'name'        => 'Footer',
				'value'       => null,
				'description' => 'Pages Footer',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '32',
				'rgt'         => '33',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
			[
				'key'         => 'backup',
				'name'        => 'Backup',
				'value'       => null,
				'description' => 'Backup Configuration',
				'field'       => null,
				'parent_id'   => null,
				'lft'         => '34',
				'rgt'         => '35',
				'depth'       => '1',
				'active'      => '1',
				'created_at'  => null,
				'updated_at'  => null,
			],
		];
		
		$tableName = (new Setting())->getTable();
		foreach ($entries as $entry) {
			DB::table($tableName)->insert($entry);
		}
	}
}
