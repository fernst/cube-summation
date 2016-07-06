# Cube Summation

Development exercise inspired by https://www.hackerrank.com/challenges/cube-summation using Laravel 5.2
 
The list of changes between the base Laravel installation and the final product can ve viewed [by clicking here](https://github.com/fernst/cube-summation/compare/f102269bae3c87e10316b5e5a0481058562ffed6...master) 

##Usage

This project is currently deployed in a Heroku instance.

To use the text input processing implementation, [click here](https://aqueous-peak-25449.herokuapp.com/) and submit a valid input for the problem described in [the Hackerrank challenge](https://www.hackerrank.com/challenges/cube-summation). If the input is incorrectly formatted or the instructions are invalid, you'll see an error message.

To use the database implementation, [click here](https://aqueous-peak-25449.herokuapp.com/db). You can use the UI to create a new Matrix, update cell values and query the matrix. Invalid instructions will show an error message.

## List of files and explanation of changes

###Business Logic Layer

####[app/Classes/DataMatrix.php](https://github.com/fernst/cube-summation/blob/master/app/Classes/DataMatrix.php)

This business logic class handles the creation of a new DataMatrix structure (for the text input processing implementation), along with cell value updates and queries. This structure is used for the regular input processing that can be viewed [clicking here](https://aqueous-peak-25449.herokuapp.com/)

####[app/Classes/InstructionHandler.php](https://github.com/fernst/cube-summation/blob/master/app/Classes/InstructionHandler.php)

This business logic class handles the decoding and processing of the instruction input (for the text input processing implementation), along with cell value updates and queries. This structure is used for the regular input processing that can be viewed [clicking here](https://aqueous-peak-25449.herokuapp.com/)

####[app/Exceptions/InstructionParseException.php](https://github.com/fernst/cube-summation/blob/master/app/Exceptions/InstructionParseException.php)

This exception is used when the instructions from the text input cannot be parsed correctly.

####[app/Exceptions/InvalidInstructionException.php](https://github.com/fernst/cube-summation/blob/master/app/Exceptions/InvalidInstructionException.php)

This exception is used when one of the instructions from the input is parsed correctly, but the instruction intself is invalid (out of range, for example) 

####[app/Http/routes.php](https://github.com/fernst/cube-summation/blob/master/app/Http/routes.php)

This file defines the URL routing and methods for the application.

###Web Layer (Controller in MVC)

####[app/Http/Controllers/CubeSummationController.php](https://github.com/fernst/cube-summation/blob/master/app/Http/Controllers/CubeSummationController.php)

This controller handles the display and instruction processing for the text input processing implementation.

####[app/Http/Controllers/CubeSummationDBController.php](https://github.com/fernst/cube-summation/blob/master/app/Http/Controllers/CubeSummationDBController.php)

This controller handles the display and instruction processing for the database implementation. In it's current implementation, only one instance of a matrix can exist (Meaning, each time a new matrix is created, the old one gets deleted). This is in order to overcome a 10k row limit Heroku has for free environments.

###Persistence Layer (Model in MVC)

####[app/Models/Cell.php](https://github.com/fernst/cube-summation/blob/master/app/Models/Cell.php)

Model for the 'cells' table (storing position and value of each cell)

####[app/Models/Matrix.php](https://github.com/fernst/cube-summation/blob/master/app/Models/Matrix.php)

Model for the 'matrices' table (storing the size of the matrix). This model is related to the Cell entity via a one-to-many association (meaning each cell belongs to one matrix, and a matrix can have N<sup>3</sup> cells)

####[app/Persistence/DataMatrixService.php](https://github.com/fernst/cube-summation/blob/master/app/Persistence/DataMatrixService.php)

This class handles the different database persistence operations (delete and create a new matrix, update a cell value and query the matrix).

####[database/seeds/DatabaseSeeder.php](https://github.com/fernst/cube-summation/blob/master/database/seeds/DatabaseSeeder.php)

Database seeds for the application tables.

####[database/migrations/2016_07_06_025353_create_tables.php](https://github.com/fernst/cube-summation/blob/master/database/migrations/2016_07_06_025353_create_tables.php)

Database migration that creates the matrices and cells tables.

###Presentation layer (View in MVC)

####[resources/views/layouts/master.blade.php](https://github.com/fernst/cube-summation/blob/master/resources/views/layouts/master.blade.php)

Main layout template for the application.

####[resources/views/cube-summation.blade.php](https://github.com/fernst/cube-summation/blob/master/resources/views/cube-summation.blade.php)

View template for the text input processing implementation.

####[resources/views/cube-summation-db.blade.php](https://github.com/fernst/cube-summation/blob/master/resources/views/cube-summation-db.blade.php)

View template for the database implementation.

###Configuration

####[app/Providers/AppServiceProvider.php](https://github.com/fernst/cube-summation/blob/master/app/Providers/AppServiceProvider.php)

This class defines the output format for the Blade template engine, allowing the display line breaks as an HTML `<br />`. 

This class also defines custom validators that are used in the database implementation UI.

####[config/app.php](https://github.com/fernst/cube-summation/blob/master/config/app.php)

In the app config file, providers and class aliases are defined. The HTML helper and FORM helper were added.

####[config/database.php](https://github.com/fernst/cube-summation/blob/master/config/database.php)

Database configuration. This file was changed in order to deploy the application in Heroku.

###Tests

####[tests/DataMatrixTest.php](https://github.com/fernst/cube-summation/blob/master/tests/DataMatrixTest.php)

Test for the Data Matrix business layer class (tests for matrix manipulation in memory and error handling). 

####[tests/InstructionHandlerTest.php](https://github.com/fernst/cube-summation/blob/master/tests/InstructionHandlerTest.php)

Test for the Instruction Handler business layer class (tests for instruction parsing and error handling). 

####[tests/WebTest.php](https://github.com/fernst/cube-summation/blob/master/tests/WebTest.php)

Tests for the CubeSummationController.

####[tests/WebDBTest.php](https://github.com/fernst/cube-summation/blob/master/tests/WebDBTest.php)

Tests for the CubeSummationDBController.

###Heroku Related

####[Procfile](https://github.com/fernst/cube-summation/blob/master/Procfile)

This file was added in order to enable support for the application using Heroku

###Other

####[composer.json](https://github.com/fernst/cube-summation/blob/master/composer.json) and [composer.lock](https://github.com/fernst/cube-summation/blob/master/composer.lock)

Composer files for dependency management.

