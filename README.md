Module: Submissions
===================

The Submissions module (`forms.submissions`) provides backup of the submissions made using the
forms managed by the Forms module (`forms`).


Event hook: ICanBoogie\ActiveRecord\Form::sent
----------------------------------------------

A hook is attached to the `ICanBoogie\ActiveRecord\Form::sent` event and is used to save the
parameters submitted with forms.

The parameters are filtered against the named elements of the forms.


Event hook: ICanBoogie\Forms\ManageBlock::alter_columns
-------------------------------------------------------

A hook is attached to the `ICanBoogie\Forms\ManageBlock::alter_columns` event and is used to add
a "Submissions" column to the "manage" block of the Forms module (`forms`). The column displays the
number of submissions saved for the form.


Operation: Export (forms.submissions/:nid/export)
-------------------------------------------------

The export operation (`forms.submissions/:nid/export`) exports the submissions associated with a
form managed by the Forms module (`forms`).

The submissions are streamed in the `text/csv` format. Also, a _classic_ response can be obtained
by using the `.json` or `.xml` extensions with the request.

The operation requires the `export submissions` permission.