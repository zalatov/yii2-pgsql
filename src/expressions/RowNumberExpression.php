<?php

declare(strict_types=1);

namespace zalatov\yii2\pgsql\expressions;

use yii\db\Expression;

/**
 * Выражение для использования ROW_NUMBER() OVER ().
 *
 * @author Zalatov Alexander <zalatov.ao@gmail.com>
 */
class RowNumberExpression extends Expression {
	/**
	 * @param string   $fieldName   Название столбца
	 * @param string[] $partitionBy Столбцы, используемые в PARTITION BY
	 * @param string[] $orderBy     Столбцы для сортировки (ключ - название столбца, значение - SORT_ASC или SORT_DESC)
	 *
	 * @author Zalatov Alexander <zalatov.ao@gmail.com>
	 */
	public function __construct(string $fieldName, array $partitionBy, array $orderBy = []) {
		$expression = [];

		$expression[] = 'ROW_NUMBER() OVER (';

		if (0 !== count($partitionBy)) {
			$expression[] = 'PARTITION BY ' . implode(', ', $partitionBy);
		}

		if (0 !== count($orderBy)) {
			$orders = [];
			foreach ($orderBy as $k => $v) {
				if (is_string($v)) {
					$orders[] = $v;
				}
				else {
					$orders[] = $k . ' ' . (SORT_DESC === $v ? 'DESC' : 'ASC');
				}
			}
			$expression[] = 'ORDER BY ' . implode(', ', $orders);
		}

		$expression[] = ') AS ' . $fieldName;

		$expression = implode(' ', $expression);

		parent::__construct($expression);
	}
}
