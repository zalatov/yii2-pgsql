<?php

declare(strict_types=1);

namespace zalatov\yii2\pgsql\expressions;

use InvalidArgumentException;
use yii\db\Expression;
use yii\db\Query;

/**
 * Выражение для получение данных в виде:
 * 1. ANY(ARRAY(SELECT guid FROM table_name)::UUID[])
 * 2. ANY(ARRAY[guid,guid,guid,guid]::UUID[])
 *
 * @author Zalatov Alexander <zalatov.ao@gmail.com>
 */
class AnyArrayExpression extends Expression {
	/**
	 * @param string      $type  Тип данных (INT, TEXT, UUID и т.п.)
	 * @param Query|array $query Запрос в виде объекта Query или списка значений
	 *
	 * @author Zalatov Alexander <zalatov.ao@gmail.com>
	 */
	public function __construct(string $type, $query) {
		if ($query instanceof Query) {
			$expression = 'ANY(ARRAY(' . $query->createCommand()->getRawSql() . ')::' . $type . '[])';
		}
		elseif (is_array($query)) {
			$expression = "'" . implode("','", $query) . "'";
			$expression  = 'ANY(ARRAY[' . $expression . ']::' . $type . '[])';
		}
		else {
			throw new InvalidArgumentException;
		}

		parent::__construct($expression);
	}
}
