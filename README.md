# Submissions module

The Submissions module (`forms.submissions`) records the submissions made using the forms
managed by the Forms module (`forms`).





## Requirement

The package requires PHP 5.3 or later.  
The package also requires an installation of [Icybee](http://icybee.org).





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/).
Create a `composer.json` file and run `php composer.phar install` command to install it:

```json
{
	"minimum-stability": "dev",
	"require":
	{
		"icybee/module-forms-submission": "*"
	}
}
```





### Cloning the repository

The package is [available on GitHub](https://github.com/Icybee/module-forms-submission), its repository can be
cloned with the following command line:

	$ git clone git://github.com/Icybee/module-forms-submission.git forms.submissions





## Documentation

The documentation for the package and its dependencies can be generated with the `make doc`
command. The documentation is generated in the `docs` directory using [ApiGen](http://apigen.org/).
The package directory can later by cleaned with the `make clean` command.





## License

The module is licensed under the New BSD License - See the LICENSE file for details.





## Event hooks





### `ICanBoogie\ActiveRecord\Form::sent`

The event `ICanBoogie\ActiveRecord\Form::sent` is used to record the parameters submitted with
managed forms.

The parameters are filtered against the named elements of the forms.





### `ICanBoogie\Forms\ManageBlock::alter_columns`

The event `ICanBoogie\Forms\ManageBlock::alter_columns` is used to add a "Submissions" column to
the manage block of the Forms module (`forms`). The column displays the number of submissions
recorded for the form.





### `ICanBoogie\Forms\EditBlock::alter_children`

The event `ICanBoogie\Forms\EditBlock::alter_children` is used to add a checkbox to the edit block
of the Forms module (`forms`) in the `options` group. The checkbox is used to enable/disable
submissions saving. The meta property `save_submissions` of the form record is used to store
the state of the checkbox.





## Operations





### Export

The export operation (`forms.submissions/:nid/export`) exports the submissions associated with a
form managed by the Forms module (`forms`).

The submissions are streamed in the `text/csv` format. Also, a _classic_ response can be obtained
by using the `.json` or `.xml` extensions with the request.

The operation requires the `export submissions` permission.