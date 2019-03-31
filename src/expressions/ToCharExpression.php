<?php

declare(strict_types=1);

namespace zalatov\yii2\pgsql\expressions;

use yii\db\Expression;

/**
 * Выражение для получение данных в виде: to_char(TIMESTAMP, FORMAT).
 *
 * @author Zalatov Alexander <zalatov.ao@gmail.com>
 */
class ToCharExpression extends Expression {
	/**
	 * @param string $column Название столбца
	 * @param string $format Формат данных
	 *
	 * @author Zalatov Alexander <zalatov.ao@gmail.com>
	 */
	public function __construct(string $column, string $format) {
		parent::__construct(
<<<SQL
			to_char($column, '$format')
SQL
		);
	}
}
