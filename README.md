# SwagModelTest Sample Plugin

Plugin for the new Shopware 5.2 Plugin System.

This example plugin creates a table name `swag_model_test_blog_entry`.
For every visit of a product detail page the entry named "My First entry" get's an updated view counter.

## Installation

Clone to `/custom/Plugin/SwagModelTest` and install via shopware CLI:

```
./bin/console sw:plugin:refresh
./bin/console sw:plugin:install --activate SwagModelTest
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
