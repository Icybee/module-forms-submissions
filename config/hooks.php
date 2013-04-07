<?php

namespace Icybee\Modules\Forms\Submissions\Hooks;

return array
(
	'events' => array
	(
		'Icybee\Modules\Forms\Form::sent' => __NAMESPACE__ . '::on_form_sent',
		'Icybee\Modules\Forms\ManageBlock::alter_columns' => __NAMESPACE__ . '::on_forms_manageblock_alter_columns',
		'Icybee\Modules\Forms\EditBlock::alter_children' => __NAMESPACE__ . '::on_forms_editblock_alter_children'
	)
);