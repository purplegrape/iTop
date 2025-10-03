<?php

namespace Combodo\iTop\Controller\Form;

class FakeDataProvider
{
	public static array $organizations = [
		'Combodo' => [
			'id' => 1
		],
		'Carrefour' => [
			'id' => 2
		]
	];

	public static array $country = [
		'France' => [
			'id' => 1,
			'organization' => 1
		],
		'Bahamas' => [
			'id' => 2,
			'organization' => 1
		]
	];

	public static array $offices = [
		'Commercial' => [
			'id' => 1,
			'organization' => 1,
			'country' => 1
		],
		'Marketing' => [
			'id' => 2,
			'organization' => 1,
			'country' => 1
		],
		'R&D' => [
			'id' => 3,
			'organization' => 1,
			'country' => 1
		],
		'Support' => [
			'id' => 4,
			'organization' => 1,
			'country' => 1
		],
		'Conseil' => [
			'id' => 5,
			'organization' => 1,
			'country' => 1
		],
		'✈️ Transat, Soleil, Tongues' => [
			'id' => 6,
			'organization' => 1,
			'country' => 2
		],
	];

	public static array $persons = [
		'Invité' => [
			'id' => 0,
			'organization' => 0
		],
		'Benjamin' => [
			'id' => 1,
			'organization' => 1
		],
		'Eric' => [
			'id' => 2,
			'organization' => 1
		],
		'Romain' => [
			'id' => 3,
			'organization' => 1
		],
		'David' => [
			'id' => 4,
			'organization' => 2
		],
	];

	public static array $emails = [
		'benjamin.dalsass@gmail.com' => [
			'id' => 1,
			'person' => 1
		],
		'benjamin.dalsass@combodo.com' => [
			'id' => 2,
			'person' => 1
		],
	];

	public static function getFakeData($type, $linkField = null, $linkValue = null): array
	{

		$array = match ($type) {
			'organization' => self::$organizations,
			'country' => self::$country,
			'person' => self::$persons,
			'email' => self::$emails,
			'office' => self::$offices,
			default => [],
		};

		if($linkField !== null && $linkValue !== null){
			$array = static::FilterData($array, $linkField, $linkValue);
		}

		return array_map(fn($value) => $value['id'], $array);

	}

	public static function getFakeData2($type, $linkField = null, $linkValue = null, $linkField2 = null, $linkValue2 = null): array
	{

		$array = match ($type) {
			'organization' => self::$organizations,
			'country' => self::$country,
			'person' => self::$persons,
			'email' => self::$emails,
			'office' => self::$offices,
			default => [],
		};

		if($linkField !== null && $linkValue !== null){
			$array = static::FilterData($array, $linkField, $linkValue);
		}

		if($linkField2 !== null && $linkValue2 !== null){
			$array = static::FilterData($array, $linkField2, $linkValue2);
		}

		return array_map(fn($value) => $value['id'], $array);

	}

	public static function FilterData(array $data, string $field, $value): array{
		return array_filter($data, function($v, $k) use ($field, $value){
			return $v[$field] == $value;
		}, ARRAY_FILTER_USE_BOTH);
	}
}