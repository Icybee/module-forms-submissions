<?php

namespace ICanBoogie\Modules\Forms\Submissions\Hooks;

return array
(
	'events' => array
	(
		'ICanBoogie\ActiveRecord\Form::sent' => __NAMESPACE__ . '::on_form_sent',
		'ICanBoogie\Modules\Forms\ManageBlock::alter_columns' => __NAMESPACE__ . '::on_forms_manageblock_alter_columns'
	)
);