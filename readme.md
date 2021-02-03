# Symfony Form / Validator Bug

Error message with Symfony 5.2.1 (and as expected):

```
field_1: field_1 is empty
field_2: field_2 is empty
field_3: This value should satisfy at least one of the following constraints: [1] This value should be blank. [2] This value is too short. It should have 10 characters or more.
```

Error message with Symfony 5.2.3:

```
field_1: field_1 is empty
field_2: field_2 is empty
field_3: This value should satisfy at least one of the following constraints: [1] field_1 is empty [2] field_1 is empty
```

To run this demo app:

```
composer install

php run_test.php
```
