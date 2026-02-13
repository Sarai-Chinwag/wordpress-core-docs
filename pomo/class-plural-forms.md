# Plural_Forms

A gettext `Plural-Forms` expression parser and evaluator. Converts C-like plural expressions (e.g., `n != 1`, `n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2`) into executable form using the shunting-yard algorithm and a stack-based RPN evaluator.

**Source:** `wp-includes/pomo/plural-forms.php`
**Since:** 4.9.0

## Constants

| Constant | Type | Value | Description |
|----------|------|-------|-------------|
| `OP_CHARS` | string | `'\|&><!=%?:'` | Valid operator characters |
| `NUM_CHARS` | string | `'0123456789'` | Valid number characters |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$op_precedence` | array | protected static | Operator precedence map (higher = executed first) |
| `$tokens` | array | protected | RPN token list after parsing |
| `$cache` | array | protected | Memoization cache: `$n => $result` |

### Operator Precedence

| Operator | Precedence | Description |
|----------|-----------|-------------|
| `%` | 6 | Modulo |
| `<`, `<=`, `>`, `>=` | 5 | Comparison |
| `==`, `!=` | 4 | Equality |
| `&&` | 3 | Logical AND |
| `\|\|` | 2 | Logical OR |
| `?:`, `?` | 1 | Ternary |
| `(`, `)` | 0 | Grouping |

---

## Methods

### `__construct( $str )`

**Since:** 4.9.0

Parses the plural expression string (the part after `plural=` in the `Plural-Forms` header, without trailing semicolon).

**Throws:** `Exception` on syntax errors.

---

### `parse( $str )` *(protected)*

Converts an infix plural expression to Reverse Polish Notation using the shunting-yard algorithm.

**Since:** 4.9.0

**Throws:** `Exception` — On mismatched parentheses, unknown operators, unknown symbols, or missing ternary `?`.

**Token types produced:**
- `['var']` — The variable `n`
- `['value', int]` — A numeric literal
- `['op', string]` — An operator

**Ternary handling:** The `:` operator finds its matching `?` on the stack and replaces it with `?:` (a single ternary operator that pops 3 values).

---

### `get( $num )`

Returns the plural form index for a number, with caching.

**Since:** 4.9.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$num` | int | The count to evaluate |

**Returns:** `int` — Plural form index (0-based).

---

### `execute( $n )` *(public)*

Evaluates the RPN token list with variable `n` substituted.

**Since:** 4.9.0

**Throws:** `Exception` — On unknown operators or if the stack doesn't resolve to exactly one value.

**Returns:** `int` — Result cast to integer.

**Supported operations:**
| Operator | Stack effect | Behavior |
|----------|-------------|----------|
| `%` | pop 2, push 1 | `$v1 % $v2` |
| `\|\|` | pop 2, push 1 | `$v1 \|\| $v2` |
| `&&` | pop 2, push 1 | `$v1 && $v2` |
| `<` | pop 2, push 1 | `$v1 < $v2` |
| `<=` | pop 2, push 1 | `$v1 <= $v2` |
| `>` | pop 2, push 1 | `$v1 > $v2` |
| `>=` | pop 2, push 1 | `$v1 >= $v2` |
| `!=` | pop 2, push 1 | `$v1 !== $v2` (strict) |
| `==` | pop 2, push 1 | `$v1 === $v2` (strict) |
| `?:` | pop 3, push 1 | `$v1 ? $v2 : $v3` |
