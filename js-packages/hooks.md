# @wordpress/hooks

Hook system for filters and actions in JavaScript.

## Filters

### `addFilter( hookName, namespace, callback, priority? )`
Registers a filter.

- `hookName` `string`
- `namespace` `string` (unique key)
- `callback( value, ...args )`
- `priority` `number` (default 10)

### `applyFilters( hookName, value, ...args )`
Applies filters to a value. Returns the filtered value.

### `removeFilter( hookName, namespace )`
Removes a previously registered filter.

## Actions

### `addAction( hookName, namespace, callback, priority? )`
Registers an action.

- `callback( ...args )`

### `doAction( hookName, ...args )`
Runs all callbacks for an action.

### `removeAction( hookName, namespace )`
Removes a previously registered action.

## Utilities

- `hasFilter( hookName, namespace? )`
- `hasAction( hookName, namespace? )`
