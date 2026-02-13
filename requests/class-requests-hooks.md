# WpOrg\Requests\HookManager & WpOrg\Requests\Hooks

Event dispatcher system for the Requests library. `HookManager` is the interface; `Hooks` is the concrete implementation.

**Source:** `wp-includes/Requests/src/HookManager.php`, `wp-includes/Requests/src/Hooks.php`  
**Namespace:** `WpOrg\Requests`

---

## HookManager (Interface)

```php
interface HookManager {
    public function register( string $hook, callable $callback, int $priority = 0 );
    public function dispatch( string $hook, array $parameters = [] ): bool;
}
```

### register()

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hook` | `string` | Hook name |
| `$callback` | `callable` | Callback to invoke |
| `$priority` | `int` | Priority number. Negative = earlier, positive = later |

### dispatch()

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hook` | `string` | Hook name |
| `$parameters` | `array` | Parameters passed to callbacks |

**Returns:** `bool` — Success status.

---

## Hooks (Implementation)

```php
class Hooks implements HookManager
```

### Properties

| Property | Type | Visibility | Description |
|----------|------|-----------|-------------|
| `$hooks` | `array` | `protected` | Registered callbacks: `[ hook_name => [ priority => [ callbacks ] ] ]` |

---

### register()

```php
public function register( string $hook, callable $callback, int $priority = 0 ): void
```

Register a callback for a hook. Multiple callbacks can be registered at the same priority.

**Throws:**
- `InvalidArgument` — When `$hook` is not a string
- `InvalidArgument` — When `$callback` is not callable
- `InvalidArgument` — When `$priority` is not an integer

**Storage structure:**

```php
$this->hooks['hook.name'][0][] = $callback;  // priority 0
$this->hooks['hook.name'][-5][] = $callback; // priority -5 (runs first)
```

---

### dispatch()

```php
public function dispatch( string $hook, array $parameters = [] ): bool
```

Dispatch a hook event. Callbacks are executed in **priority order** (sorted by `ksort`), then in registration order within the same priority.

Parameters are passed as positional arguments using the spread operator (`$callback(...$parameters)`). Array keys are stripped via `array_values()` to prevent them being interpreted as named parameters in PHP 8.0+.

**Returns:** `false` if no callbacks are registered for the hook, `true` after executing callbacks.

**Throws:**
- `InvalidArgument` — When `$hook` is not a string
- `InvalidArgument` — When `$parameters` is not an array (strict check — `Array*` objects are rejected)

---

### __wakeup()

```php
public function __wakeup(): void
```

Throws `\LogicException` — Hooks should never be unserialized.

---

## Dispatch Order Example

```php
$hooks = new Hooks();
$hooks->register('my.event', $callbackA, 10);   // runs third
$hooks->register('my.event', $callbackB, -5);   // runs first
$hooks->register('my.event', $callbackC, 0);    // runs second
$hooks->register('my.event', $callbackD, 10);   // runs fourth (same priority as A, registered after)

$hooks->dispatch('my.event', [&$data]);
// Execution order: B (-5) → C (0) → A (10) → D (10)
```

---

## Usage in the Library

`Hooks` is automatically instantiated in `Requests::set_defaults()` when `$options['hooks']` is empty. Auth handlers, proxy handlers, and cookie jars register themselves with the hooks system via their `register()` methods.

See [Hook Points](requests.md#hook-points) for all dispatched hooks.
