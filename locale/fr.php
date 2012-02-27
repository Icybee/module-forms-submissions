<?php

return array
(
	'forms.manage' => array
	(
		':count submissions' => array
		(
			'none' => 'Aucune',
			'one' => 'Un soumission',
			'other' => ':count soumissions'
		),

		'title.Submissions' => 'Soumissions'
	),

	'forms.edit.element' => array
	(
		'label.save_submissions' => "Enregistrer les soumissions à ce formulaire en base de données",
		'description.save_submissions' => "Cochez cette case pour que les soumissions à ce
		formulaire soient enregistrées en base de données. Les données collectées pourront ensuite
		être exportées au format CSV."
	),

	"Submissions for :title.csv" => "Soumissions pour :title.csv"
);
