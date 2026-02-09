# Abilities API

Framework for registering and executing discrete capabilities within WordPress.

**Since:** 6.9.0  
**Source:** `wp-includes/abilities-api.php`, `wp-includes/abilities-api/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration and retrieval functions |
| [class-wp-ability.md](./class-wp-ability.md) | Individual ability instance |
| [class-wp-abilities-registry.md](./class-wp-abilities-registry.md) | Ability registry singleton |
| [class-wp-ability-category.md](./class-wp-ability-category.md) | Ability category instance |
| [class-wp-ability-categories-registry.md](./class-wp-ability-categories-registry.md) | Category registry singleton |
| [hooks.md](./hooks.md) | Actions and filters |

## Registration Flow

```
wp_abilities_api_categories_init
    └── wp_register_ability_category()
            └── WP_Ability_Categories_Registry::register()
                    └── new WP_Ability_Category()

wp_abilities_api_init
    └── wp_register_ability()
            └── WP_Abilities_Registry::register()
                    └── new WP_Ability()
```

## Execution Flow

```
WP_Ability::execute()
    ├── normalize_input()
    ├── validate_input()
    ├── check_permissions()
    ├── do_action('wp_before_execute_ability')
    ├── do_execute()
    ├── validate_output()
    ├── do_action('wp_after_execute_ability')
    └── return result
```
