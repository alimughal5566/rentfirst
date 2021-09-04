<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
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
				'abbr'                  => 'en',
				'locale'                => 'en_US',
				'name'                  => 'English',
				'native'                => 'English',
				'flag'                  => null,
				'app_name'              => 'english',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'MMM Do, YYYY',
				'datetime_format'       => 'MMM Do, YYYY [at] HH:mm',
				'active'                => '1',
				'default'               => '1',
				'parent_id'             => null,
				'lft'                   => '2',
				'rgt'                   => '3',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'fr',
				'locale'                => 'fr_FR',
				'name'                  => 'French',
				'native'                => 'Français',
				'flag'                  => null,
				'app_name'              => 'french',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'Do MMM YYYY',
				'datetime_format'       => 'Do MMM YYYY [à] H[h]mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '4',
				'rgt'                   => '5',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'es',
				'locale'                => 'es_ES',
				'name'                  => 'Spanish',
				'native'                => 'Español',
				'flag'                  => '',
				'app_name'              => 'spanish',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D [de] MMMM [de] YYYY',
				'datetime_format'       => 'D [de] MMMM [de] YYYY HH:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '6',
				'rgt'                   => '7',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'ar',
				'locale'                => 'ar_SA',
				'name'                  => 'Arabic',
				'native'                => 'العربية',
				'flag'                  => null,
				'app_name'              => 'arabic',
				'script'                => 'Arab',
				'direction'             => 'rtl',
				'russian_pluralization' => '0',
				'date_format'           => 'DD/MMMM/YYYY',
				'datetime_format'       => 'DD/MMMM/YYYY HH:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '8',
				'rgt'                   => '9',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'pt',
				'locale'                => 'pt_PT',
				'name'                  => 'Portuguese',
				'native'                => 'Português',
				'flag'                  => null,
				'app_name'              => 'portuguese',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D [de] MMMM [de] YYYY',
				'datetime_format'       => 'D [de] MMMM [de] YYYY HH:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '10',
				'rgt'                   => '11',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'it',
				'locale'                => 'it_IT',
				'name'                  => 'Italian',
				'native'                => 'Italiano',
				'flag'                  => null,
				'app_name'              => 'italian',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY HH:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '12',
				'rgt'                   => '13',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'tr',
				'locale'                => 'tr_TR',
				'name'                  => 'Turkish',
				'native'                => 'Türk',
				'flag'                  => null,
				'app_name'              => 'turkish',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'DD MMMM YYYY dddd',
				'datetime_format'       => 'DD MMMM YYYY dddd HH:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '14',
				'rgt'                   => '15',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'ru',
				'locale'                => 'ru_RU',
				'name'                  => 'Russian',
				'native'                => 'русский',
				'flag'                  => null,
				'app_name'              => 'russian',
				'script'                => 'Cyrl',
				'direction'             => 'ltr',
				'russian_pluralization' => '1',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY [ г.] H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '16',
				'rgt'                   => '17',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'zh',
				'locale'                => 'zh_CN',
				'name'                  => 'Chinese',
				'native'                => '中文',
				'flag'                  => null,
				'app_name'              => 'chinese',
				'script'                => 'Hans',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '18',
				'rgt'                   => '19',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'ja',
				'locale'                => 'ja_JP',
				'name'                  => 'Japanese',
				'native'                => '日本人',
				'flag'                  => null,
				'app_name'              => 'japanese',
				'script'                => 'Jpan',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '20',
				'rgt'                   => '21',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'th',
				'locale'                => 'th_TH',
				'name'                  => 'Thai',
				'native'                => 'ไทย',
				'flag'                  => null,
				'app_name'              => 'thai',
				'script'                => 'Thai',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '22',
				'rgt'                   => '23',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'ro',
				'locale'                => 'ro_RO',
				'name'                  => 'Romanian',
				'native'                => 'Română',
				'flag'                  => null,
				'app_name'              => 'romanian',
				'script'                => 'Latn',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'D MMMM YYYY',
				'datetime_format'       => 'D MMMM YYYY H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '24',
				'rgt'                   => '25',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
			[
				'abbr'                  => 'ka',
				'locale'                => 'ka_GE',
				'name'                  => 'Georgian',
				'native'                => 'ქართული',
				'flag'                  => null,
				'app_name'              => 'georgian',
				'script'                => 'Geor',
				'direction'             => 'ltr',
				'russian_pluralization' => '0',
				'date_format'           => 'YYYY [წლის] DD MM',
				'datetime_format'       => 'YYYY [წლის] DD MMMM, dddd H:mm',
				'active'                => '1',
				'default'               => '0',
				'parent_id'             => null,
				'lft'                   => '26',
				'rgt'                   => '27',
				'depth'                 => '1',
				'deleted_at'            => null,
				'created_at'            => now()->format('Y-m-d H:i:s'),
				'updated_at'            => now()->format('Y-m-d H:i:s'),
			],
		];
		
		$tableName = (new Language())->getTable();
		foreach ($entries as $entry) {
			DB::table($tableName)->insert($entry);
		}
	}
}
