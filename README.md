Module: Submissions
===================

The Submissions module (`forms.submissions`) provides backup of the submissions made using the
forms managed by the Forms module (`forms`).


Event hook: ICanBoogie\ActiveRecord\Form::sent
----------------------------------------------

A hook is attached to the `ICanBoogie\ActiveRecord\Form::sent` event and is used to save the
parameters submitted with forms.

The parameters are filtered against the named elements of the forms.