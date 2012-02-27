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

use Brickrouge\A;
use Brickrouge\Element;

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

	/**
	 * Alters the "manage" block of the Forms module (`forms`) to add the "Submitted" column.
	 *
	 * @param Event $event
	 * @param \ICanBoogie\Modules\Forms\ManageBlock $block
	 */
	public static function on_forms_manageblock_alter_columns(Event $event, \ICanBoogie\Modules\Forms\ManageBlock $block)
	{
		global $core;

		$ids = array();

		foreach ($event->records as $record)
		{
			$ids[] = $record->nid;
		}

		if (!$ids)
		{
			return;
		}

		$core->document->css->add('public/admin.css');

		$counts = $core->models['forms.submissions']->where(array('form_id' => $ids))->count('form_id');

 		$event->columns = \ICanBoogie\array_insert
 		(
 			$event->columns, 'modelid', array
 			(
 				'label' => "Submissions",
 				'class' => null,
 				'hook' => function($record, $property) use($counts)
 				{
 					$nid = $record->nid;
 					$count = empty($counts[$nid]) ? 0 : $counts[$nid];
 					$label = t(':count submissions', array(':count' => $count));

 					if (!$count)
 					{
 						return '<em class="small">' . $label . '</em>';
 					}

 					return new A
 					(
 						$label, \ICanBoogie\Operation::encode("forms.submissions/$nid/export"), array
 						(
 							'title' => "Export the submissions of this form"
 						)
 					);
 				},

 				'filters' => null,
 				'filtering' => false,
 				'reset' => null,
 				'orderable' => false,
 				'order' => null,
 				'default_order' => 1,
 				'discreet' => true
 			),

 			'submissions_count'
 		);
	}

	/**
	 * Extends the edit block of the Forms module (`forms`) with a checkbox to enable/disable
	 * submissions saving. The checkbox is added to the `options` group.
	 *
	 * The meta property `save_submissions` of the form record is used to store the state of the
	 * checkbox.
	 *
	 * @param Event $event
	 */
	public static function on_forms_editblock_alter_children(Event $event, \ICanBoogie\Modules\Forms\EditBlock $block)
	{
		$event->children['metas[save_submissions]'] = new Element
		(
			Element::TYPE_CHECKBOX, array
			(
				Element::LABEL => 'save_submissions',
				Element::GROUP => 'options',
				Element::DESCRIPTION => 'save_submissions'
			)
		);
	}
}