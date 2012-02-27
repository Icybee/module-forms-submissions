<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Modules\Forms\Submissions;

use ICanBoogie\Event;

class Hooks
{
	/**
	 * Saves the parameters submited with a form to the database.
	 *
	 * Parameters are filtered against the named elements of the form. Also, parameters starting
	 * with an underscore ("_") or a sharp ("#") are discarted.
	 *
	 * This method is a callback for the `ICanBoogie\ActiveRecord\Form::sent` event.
	 *
	 * @param Event $event
	 * @param \ICanBoogie\ActiveRecord\Form $record
	 */
	public static function on_form_sent(Event $event, \ICanBoogie\ActiveRecord\Form $record)
	{
		global $core;

		$model = $core->models['forms.submissions'];
		$fields_model = $core->models['forms.submissions/fields'];

		$submission_id = $model->save
		(
			array
			(
				'form_id' => $record->nid,
				'submitted' => date('Y-m-d H:i:s'),
				'ip' => $event->request->ip
			)
		);

		$names = array();
		$iterator = new \RecursiveIteratorIterator($record->form, \RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $name => $element)
		{
			$names[$name] = true;
		}

		foreach ($event->request->params as $key => $value)
		{
			if ($key{0} == '#' || $key{0} == '_' || !isset($names[$key]))
			{
				continue;
			}

			$fields_model->save
			(
				array
				(
					'submission_id' => $submission_id,
					'name' => $key,
					'value' => $value
				)
			);
		}
	}
}