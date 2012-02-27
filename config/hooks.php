<?php

namespace ICanBoogie\Modules\Forms\Submissions\Hooks;

return array
(
	'events' => array
	(
		'ICanBoogie\ActiveRecord\Form::sent' => __NAMESPACE__ . '::on_form_sent'
	)
);