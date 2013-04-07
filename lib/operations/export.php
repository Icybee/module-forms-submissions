<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Submissions;

/**
 * Exports the submissions attached to a form.
 *
 * By default the export is streamed in the "text/cvs" format, but if the ".json" or ".xml"
 * extension is used in the request path the response is rendered using standard methods.
 */
class ExportOperation extends \ICanBoogie\Operation
{
	protected function get_controls()
	{
		return array
		(
			self::CONTROL_RECORD => true,
			self::CONTROL_PERMISSION => 'export submissions'
		)

		+ parent::get_controls();
	}

	/**
	 * Returns the form record which submissions should be exported.
	 *
	 * @see ICanBoogie.Operation::get_record()
	 */
	protected function get_record()
	{
		global $core;

		return $this->key ? $core->models['forms'][$this->key] : null;
	}

	protected function validate(\ICanBoogie\Errors $errors)
	{
		return true;
	}

	protected function process()
	{
		global $core;

		$dates = $core->models['forms.submissions']->select('submission_id, submitted')->filter_by_form_id($this->key)->pairs;

		if (!$dates)
		{
			return false;
		}

		$rows = $core->models['forms.submissions/fields']
		->joins(':forms.submissions')
		->select('submission_id, name, value')
		->filter_by_form_id($this->key)
		->mode(\PDO::FETCH_NUM);

		$names = array();
		$submissions = array();

		foreach ($rows as $row)
		{
			list($submission_id, $name, $value) = $row;

			$names[$name] = '';
			$submissions[$submission_id][$name] = $value;
		}

		$lines = array();

		foreach ($submissions as $submission_id => $values)
		{
			$lines[] = array('submitted-on' => $dates[$submission_id]) + array_intersect_key($values, $names);
		}

		if ($this->request->extension)
		{
			return $lines;
		}

		$filename = t
		(
			"Submissions for :title.csv", array
			(
				'title' => $this->record->title
			),

			array('language' => $core->user->language)
		);

		$response = $this->response;
		$response->type = 'text/csv';
		$response->headers['Content-Description'] = 'File Transfer';
		$response->headers['Content-Disposition'] = array('attachment', $filename);

		return function() use ($lines, $names)
		{
			$fh = fopen('php://output', 'w');

			array_unshift($lines, array_merge(array('submitted-on'), array_keys($names)));

			foreach ($lines as $line)
			{
				fputcsv($fh, $line);
			}

			fclose($fh);
		};
	}
}