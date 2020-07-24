# Validation test utilities for Laravel

Trait with some test utilities for testing up validation in your requests.

## Installation

Download and copy the TestUtilites.php trait into tests/ folder of your Laravel project.

## Usage

Use trait in your Test class

```php
class CreateAreaTest extends TestCase
{
    use RefreshDatabase, TestUtilities;
    
    // ..
}
```

## Examples

```php
/** @test */
public function should_validate_manager()
{
    $this->actingAs(factory(User::class)->create(), 'api');

    // Required
    $this->fieldIsPresent('manager');

    // Exists
    $this->fieldValueIsInvalid('manager', 9999);

    // Selected user has role => manager
    $this->fieldValueIsInvalid('manager', factory(User::class)->create([
        'role' => Role::CategoryManager
    ])->id);
}
```

## TODO

- [x] How to install
- [x] Examples
- [ ] Docs
- [ ] Convert to composer package
