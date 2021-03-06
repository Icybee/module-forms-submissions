<?php

namespace Icybee\Modules\Forms\Submissions;

use ICanBoogie\Module;
use ICanBoogie\ActiveRecord\Model;

return array
(
	Module::T_CATEGORY => 'feedback',
	Module::T_DESCRIPTION => "Saves managed forms submissions",
	Module::T_MODELS => array
	(
		'primary' => array
		(
			Model::ACTIVERECORD_CLASS => 'ICanBoogie\ActiveRecord',
			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'submission_id' => 'serial',
					'form_id' => 'foreign',
					'submitted' => 'datetime',
					'ip' => array('varchar', 40)
				)
			),
		),

		'fields' => array
		(
			Model::ACTIVERECORD_CLASS => 'ICanBoogie\ActiveRecord',
			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'submission_id' => 'foreign',
					'name' => array('varchar', 80),
					'value' => 'text'
				)
			)
		)
	),

	Module::T_NAMESPACE => __NAMESPACE__,

	Module::T_PERMISSIONS => array
	(
		'export submissions'
	),

	Module::T_REQUIRES => array
	(
		'forms' => '1.0'
	),

	Module::T_TITLE => 'Submissions'
);