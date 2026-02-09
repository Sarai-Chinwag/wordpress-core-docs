# Taxonomy API Hooks

Actions and filters for the Taxonomy API.

---

## Taxonomy Registration

### registered_taxonomy

Fires after a taxonomy is registered.

```php
do_action( 'registered_taxonomy', string $taxonomy, array|string $object_type, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy slug |
| `$object_type` | array\|string | Object type(s) |
| `$args` | array | Registration arguments |

**Example:**

```php
add_action( 'registered_taxonomy', function( $taxonomy, $object_type, $args ) {
    error_log( "Taxonomy registered: {$taxonomy}" );
}, 10, 3 );
```

---

### registered_taxonomy_{$taxonomy}

Fires after a specific taxonomy is registered.

```php
do_action( "registered_taxonomy_{$taxonomy}", string $taxonomy, array|string $object_type, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy slug |
| `$object_type` | array\|string | Object type(s) |
| `$args` | array | Registration arguments |

**Possible hook names:** `registered_taxonomy_category`, `registered_taxonomy_post_tag`

---

### unregistered_taxonomy

Fires after a taxonomy is unregistered.

```php
do_action( 'unregistered_taxonomy', string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |

---

### registered_taxonomy_for_object_type

Fires after a taxonomy is registered for an object type.

```php
do_action( 'registered_taxonomy_for_object_type', string $taxonomy, string $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |
| `$object_type` | string | Object type name |

---

### unregistered_taxonomy_for_object_type

Fires after a taxonomy is unregistered for an object type.

```php
do_action( 'unregistered_taxonomy_for_object_type', string $taxonomy, string $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |
| `$object_type` | string | Object type name |

---

### register_taxonomy_args

Filters the arguments for registering a taxonomy.

```php
apply_filters( 'register_taxonomy_args', array $args, string $taxonomy, string[] $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments |
| `$taxonomy` | string | Taxonomy key |
| `$object_type` | string[] | Object type names |

**Returns:** Modified arguments array.

**Example:**

```php
add_filter( 'register_taxonomy_args', function( $args, $taxonomy, $object_type ) {
    // Force all taxonomies to show in REST
    $args['show_in_rest'] = true;
    return $args;
}, 10, 3 );
```

---

### register_{$taxonomy}_taxonomy_args

Filters the arguments for registering a specific taxonomy.

```php
apply_filters( "register_{$taxonomy}_taxonomy_args", array $args, string $taxonomy, string[] $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments |
| `$taxonomy` | string | Taxonomy key |
| `$object_type` | string[] | Object type names |

**Possible hook names:** `register_category_taxonomy_args`, `register_post_tag_taxonomy_args`

**Returns:** Modified arguments array.

---

### taxonomy_labels_{$taxonomy}

Filters the labels of a specific taxonomy.

```php
apply_filters( "taxonomy_labels_{$taxonomy}", object $labels )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$labels` | object | Labels object |

**Returns:** Modified labels object.

---

## Term Retrieval

### get_terms_defaults

Filters the terms query default arguments.

```php
apply_filters( 'get_terms_defaults', array $defaults, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$defaults` | array | Default get_terms() arguments |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified defaults array.

---

### get_terms_args

Filters the terms query arguments.

```php
apply_filters( 'get_terms_args', array $args, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Query arguments |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified arguments array.

---

### get_terms_fields

Filters the fields to select in the terms query.

```php
apply_filters( 'get_terms_fields', string[] $selects, array $args, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$selects` | string[] | Fields to select |
| `$args` | array | Query arguments |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified selects array.

---

### get_terms_orderby

Filters the ORDERBY clause of the terms query.

```php
apply_filters( 'get_terms_orderby', string $orderby, array $args, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$orderby` | string | ORDERBY clause |
| `$args` | array | Query arguments |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified ORDERBY clause.

---

### list_terms_exclusions

Filters the terms to exclude from the terms query.

```php
apply_filters( 'list_terms_exclusions', string $exclusions, array $args, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exclusions` | string | NOT IN clause |
| `$args` | array | Query arguments |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified exclusions SQL.

---

### terms_clauses

Filters the terms query SQL clauses.

```php
apply_filters( 'terms_clauses', string[] $clauses, string[] $taxonomies, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$clauses` | string[] | SQL clauses (fields, join, where, distinct, orderby, order, limits) |
| `$taxonomies` | string[] | Taxonomy names |
| `$args` | array | Query arguments |

**Returns:** Modified clauses array.

---

### terms_pre_query

Filters the terms array before the query takes place.

```php
apply_filters_ref_array( 'terms_pre_query', array $terms, WP_Term_Query &$query )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | array\|null | Return array to short-circuit, null to continue |
| `$query` | WP_Term_Query | Query instance (by reference) |

**Returns:** Array to short-circuit or null.

---

### get_terms

Filters the found terms.

```php
apply_filters( 'get_terms', array $terms, array|null $taxonomies, array $args, WP_Term_Query $term_query )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | array | Found terms |
| `$taxonomies` | array\|null | Taxonomy names |
| `$args` | array | Query arguments |
| `$term_query` | WP_Term_Query | Query object |

**Returns:** Modified terms array.

---

### get_term

Filters a taxonomy term object.

```php
apply_filters( 'get_term', WP_Term $_term, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$_term` | WP_Term | Term object |
| `$taxonomy` | string | Taxonomy slug |

**Returns:** Modified term object.

---

### get_{$taxonomy}

Filters a taxonomy term object for a specific taxonomy.

```php
apply_filters( "get_{$taxonomy}", WP_Term $_term, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$_term` | WP_Term | Term object |
| `$taxonomy` | string | Taxonomy slug |

**Possible hook names:** `get_category`, `get_post_tag`

**Returns:** Modified term object.

---

### parse_term_query

Fires after term query vars have been parsed.

```php
do_action( 'parse_term_query', WP_Term_Query $query )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | WP_Term_Query | Query instance |

---

### pre_get_terms

Fires before terms are retrieved.

```php
do_action_ref_array( 'pre_get_terms', array( WP_Term_Query &$query ) )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | WP_Term_Query | Query instance (by reference) |

---

## Term Creation

### pre_insert_term

Filters a term before it is sanitized and inserted into the database.

```php
apply_filters( 'pre_insert_term', string|WP_Error $term, string $taxonomy, array|string $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | string\|WP_Error | Term name or error |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array\|string | Arguments passed to wp_insert_term() |

**Returns:** Term name or WP_Error to abort.

---

### wp_insert_term_data

Filters term data before it is inserted into the database.

```php
apply_filters( 'wp_insert_term_data', array $data, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | array | Term data (name, slug, term_group) |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Arguments passed to wp_insert_term() |

**Returns:** Modified data array.

---

### wp_insert_term_duplicate_term_check

Filters the duplicate term check that takes place during term creation.

```php
apply_filters( 'wp_insert_term_duplicate_term_check', object $duplicate_term, string $term, string $taxonomy, array $args, int $tt_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$duplicate_term` | object | Duplicate term row from database |
| `$term` | string | Term being inserted |
| `$taxonomy` | string | Taxonomy name |
| `$args` | array | Insert arguments |
| `$tt_id` | int | Term taxonomy ID of new term |

**Returns:** Duplicate term object or null to skip check.

---

### create_term

Fires immediately after a new term is created, before the term cache is cleaned.

```php
do_action( 'create_term', int $term_id, int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Arguments passed to wp_insert_term() |

---

### create_{$taxonomy}

Fires after a new term is created for a specific taxonomy.

```php
do_action( "create_{$taxonomy}", int $term_id, int $tt_id, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$args` | array | Insert arguments |

**Possible hook names:** `create_category`, `create_post_tag`

---

### term_id_filter

Filters the term ID after a new term is created.

```php
apply_filters( 'term_id_filter', int $term_id, int $tt_id, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$args` | array | Insert/update arguments |

**Returns:** Modified term ID.

---

### created_term

Fires after a new term is created, and after the term cache has been cleaned.

```php
do_action( 'created_term', int $term_id, int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Insert arguments |

---

### created_{$taxonomy}

Fires after a new term in a specific taxonomy is created, and after the term cache has been cleaned.

```php
do_action( "created_{$taxonomy}", int $term_id, int $tt_id, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$args` | array | Insert arguments |

**Possible hook names:** `created_category`, `created_post_tag`

---

## Term Update

### edit_terms

Fires immediately before the given terms are edited.

```php
do_action( 'edit_terms', int $term_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Arguments passed to wp_update_term() |

---

### edited_terms

Fires immediately after a term is updated in the database, but before its term-taxonomy relationship is updated.

```php
do_action( 'edited_terms', int $term_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

---

### wp_update_term_parent

Filters the term parent.

```php
apply_filters( 'wp_update_term_parent', int $parent_term, int $term_id, string $taxonomy, array $parsed_args, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$parent_term` | int | Parent term ID |
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |
| `$parsed_args` | array | Parsed update arguments |
| `$args` | array | Original arguments |

**Returns:** Modified parent term ID.

---

### wp_update_term_data

Filters term data before it is updated in the database.

```php
apply_filters( 'wp_update_term_data', array $data, int $term_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | array | Term data to update |
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

**Returns:** Modified data array.

---

### edit_term_taxonomy

Fires immediately before a term-taxonomy relationship is updated.

```php
do_action( 'edit_term_taxonomy', int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

---

### edited_term_taxonomy

Fires immediately after a term-taxonomy relationship is updated.

```php
do_action( 'edited_term_taxonomy', int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

---

### edit_term

Fires after a term has been updated, but before the term cache has been cleaned.

```php
do_action( 'edit_term', int $term_id, int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

---

### edit_{$taxonomy}

Fires after a term in a specific taxonomy has been updated, but before the term cache has been cleaned.

```php
do_action( "edit_{$taxonomy}", int $term_id, int $tt_id, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$args` | array | Update arguments |

**Possible hook names:** `edit_category`, `edit_post_tag`

---

### edited_term

Fires after a term has been updated, and the term cache has been cleaned.

```php
do_action( 'edited_term', int $term_id, int $tt_id, string $taxonomy, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$args` | array | Update arguments |

---

### edited_{$taxonomy}

Fires after a term for a specific taxonomy has been updated, and the term cache has been cleaned.

```php
do_action( "edited_{$taxonomy}", int $term_id, int $tt_id, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$args` | array | Update arguments |

**Possible hook names:** `edited_category`, `edited_post_tag`

---

## Saved Term (Both Create and Update)

### saved_term

Fires after a term has been saved, and the term cache has been cleared.

```php
do_action( 'saved_term', int $term_id, int $tt_id, string $taxonomy, bool $update, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$update` | bool | Whether this is an update |
| `$args` | array | Insert/update arguments |

---

### saved_{$taxonomy}

Fires after a term in a specific taxonomy has been saved, and the term cache has been cleared.

```php
do_action( "saved_{$taxonomy}", int $term_id, int $tt_id, bool $update, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$update` | bool | Whether this is an update |
| `$args` | array | Insert/update arguments |

**Possible hook names:** `saved_category`, `saved_post_tag`

---

## Term Deletion

### pre_delete_term

Fires when deleting a term, before any modifications are made to posts or terms.

```php
do_action( 'pre_delete_term', int $term, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int | Term ID |
| `$taxonomy` | string | Taxonomy name |

---

### edit_term_taxonomies

Fires immediately before a term to delete's children are reassigned a parent.

```php
do_action( 'edit_term_taxonomies', array $edit_tt_ids )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$edit_tt_ids` | array | Term taxonomy IDs of children |

---

### edited_term_taxonomies

Fires immediately after a term to delete's children are reassigned a parent.

```php
do_action( 'edited_term_taxonomies', array $edit_tt_ids )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$edit_tt_ids` | array | Term taxonomy IDs of children |

---

### delete_term_taxonomy

Fires immediately before a term taxonomy ID is deleted.

```php
do_action( 'delete_term_taxonomy', int $tt_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tt_id` | int | Term taxonomy ID |

---

### deleted_term_taxonomy

Fires immediately after a term taxonomy ID is deleted.

```php
do_action( 'deleted_term_taxonomy', int $tt_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tt_id` | int | Term taxonomy ID |

---

### delete_term

Fires after a term is deleted from the database and the cache is cleaned.

```php
do_action( 'delete_term', int $term, int $tt_id, string $taxonomy, WP_Term $deleted_term, array $object_ids )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |
| `$deleted_term` | WP_Term | Deleted term object |
| `$object_ids` | array | Object IDs that were assigned to term |

---

### delete_{$taxonomy}

Fires after a term in a specific taxonomy is deleted.

```php
do_action( "delete_{$taxonomy}", int $term, int $tt_id, WP_Term $deleted_term, array $object_ids )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int | Term ID |
| `$tt_id` | int | Term taxonomy ID |
| `$deleted_term` | WP_Term | Deleted term object |
| `$object_ids` | array | Object IDs that were assigned |

**Possible hook names:** `delete_category`, `delete_post_tag`

---

## Object-Term Relationships

### add_term_relationship

Fires immediately before an object-term relationship is added.

```php
do_action( 'add_term_relationship', int $object_id, int $tt_id, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |

---

### added_term_relationship

Fires immediately after an object-term relationship is added.

```php
do_action( 'added_term_relationship', int $object_id, int $tt_id, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |

---

### delete_term_relationships

Fires immediately before an object-term relationship is deleted.

```php
do_action( 'delete_term_relationships', int $object_id, array $tt_ids, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$tt_ids` | array | Term taxonomy IDs |
| `$taxonomy` | string | Taxonomy slug |

---

### deleted_term_relationships

Fires immediately after an object-term relationship is deleted.

```php
do_action( 'deleted_term_relationships', int $object_id, array $tt_ids, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$tt_ids` | array | Term taxonomy IDs |
| `$taxonomy` | string | Taxonomy slug |

---

### set_object_terms

Fires after an object's terms have been set.

```php
do_action( 'set_object_terms', int $object_id, array $terms, array $tt_ids, string $taxonomy, bool $append, array $old_tt_ids )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$terms` | array | Term IDs or slugs |
| `$tt_ids` | array | Term taxonomy IDs |
| `$taxonomy` | string | Taxonomy slug |
| `$append` | bool | Whether appending to old terms |
| `$old_tt_ids` | array | Previous term taxonomy IDs |

---

### wp_get_object_terms_args

Filters arguments for retrieving object terms.

```php
apply_filters( 'wp_get_object_terms_args', array $args, int[] $object_ids, string[] $taxonomies )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Query arguments |
| `$object_ids` | int[] | Object IDs |
| `$taxonomies` | string[] | Taxonomy names |

**Returns:** Modified arguments array.

---

### get_object_terms

Filters the terms for a given object or objects.

```php
apply_filters( 'get_object_terms', WP_Term[]|int[]|string[]|string $terms, int[] $object_ids, string[] $taxonomies, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | array\|string | Terms or count |
| `$object_ids` | int[] | Object IDs |
| `$taxonomies` | string[] | Taxonomy names |
| `$args` | array | Query arguments |

**Returns:** Modified terms.

---

### wp_get_object_terms

Filters the terms for a given object or objects (legacy format).

```php
apply_filters( 'wp_get_object_terms', WP_Term[]|int[]|string[]|string $terms, string $object_ids, string $taxonomies, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | array\|string | Terms or count |
| `$object_ids` | string | Comma-separated object IDs |
| `$taxonomies` | string | SQL fragment of taxonomy names |
| `$args` | array | Query arguments |

**Returns:** Modified terms.

---

## Term Sanitization

### edit_term_{$field}

Filters a term field to edit before it is sanitized.

```php
apply_filters( "edit_term_{$field}", mixed $value, int $term_id, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |

**Returns:** Modified value.

---

### edit_{$taxonomy}_{$field}

Filters the taxonomy field to edit before it is sanitized.

```php
apply_filters( "edit_{$taxonomy}_{$field}", mixed $value, int $term_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |
| `$term_id` | int | Term ID |

**Returns:** Modified value.

---

### pre_term_{$field}

Filters a term field value before it is sanitized for database.

```php
apply_filters( "pre_term_{$field}", mixed $value, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |
| `$taxonomy` | string | Taxonomy slug |

**Returns:** Modified value.

---

### pre_{$taxonomy}_{$field}

Filters a taxonomy field before it is sanitized for database.

```php
apply_filters( "pre_{$taxonomy}_{$field}", mixed $value )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |

**Returns:** Modified value.

---

### term_{$field}

Filters the term field sanitized for display.

```php
apply_filters( "term_{$field}", mixed $value, int $term_id, string $taxonomy, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy slug |
| `$context` | string | Display context |

**Returns:** Modified value.

---

### {$taxonomy}_{$field}

Filters the taxonomy field sanitized for display.

```php
apply_filters( "{$taxonomy}_{$field}", mixed $value, int $term_id, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Field value |
| `$term_id` | int | Term ID |
| `$context` | string | Display context |

**Returns:** Modified value.

---

## Term Slugs

### wp_unique_term_slug_is_bad_slug

Filters whether the proposed unique term slug is bad.

```php
apply_filters( 'wp_unique_term_slug_is_bad_slug', bool $needs_suffix, string $slug, object $term )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$needs_suffix` | bool | Whether slug needs suffix |
| `$slug` | string | Proposed slug |
| `$term` | object | Term object |

**Returns:** Whether to add suffix.

---

### wp_unique_term_slug

Filters the unique term slug.

```php
apply_filters( 'wp_unique_term_slug', string $slug, object $term, string $original_slug )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Unique slug |
| `$term` | object | Term object |
| `$original_slug` | string | Original proposed slug |

**Returns:** Modified slug.

---

## Term Links

### pre_term_link

Filters the permalink structure for a term before token replacement occurs.

```php
apply_filters( 'pre_term_link', string $termlink, WP_Term $term )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$termlink` | string | Permalink structure |
| `$term` | WP_Term | Term object |

**Returns:** Modified permalink structure.

---

### term_link

Filters the term link.

```php
apply_filters( 'term_link', string $termlink, WP_Term $term, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$termlink` | string | Term link URL |
| `$term` | WP_Term | Term object |
| `$taxonomy` | string | Taxonomy slug |

**Returns:** Modified URL.

---

### tag_link

Filters the tag link (for post_tag taxonomy).

```php
apply_filters( 'tag_link', string $termlink, int $term_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$termlink` | string | Tag link URL |
| `$term_id` | int | Term ID |

**Returns:** Modified URL.

---

### category_link

Filters the category link.

```php
apply_filters( 'category_link', string $termlink, int $term_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$termlink` | string | Category link URL |
| `$term_id` | int | Term ID |

**Returns:** Modified URL.

---

## Term Counting

### update_term_count

Fires when a term count is calculated, before it is updated in the database.

```php
do_action( 'update_term_count', int $tt_id, string $taxonomy_name, int $count )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tt_id` | int | Term taxonomy ID |
| `$taxonomy_name` | string | Taxonomy slug |
| `$count` | int | Term count |

---

### update_post_term_count_statuses

Filters the post statuses for updating the term count.

```php
apply_filters( 'update_post_term_count_statuses', string[] $post_statuses, WP_Taxonomy $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_statuses` | string[] | Post statuses to include |
| `$taxonomy` | WP_Taxonomy | Taxonomy object |

**Returns:** Modified post statuses array.

---

## Caching

### clean_term_cache

Fires once after each taxonomy's term cache has been cleaned.

```php
do_action( 'clean_term_cache', array $ids, string $taxonomy, bool $clean_taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ids` | array | Term IDs |
| `$taxonomy` | string | Taxonomy slug |
| `$clean_taxonomy` | bool | Whether taxonomy-wide caches were cleaned |

---

### clean_object_term_cache

Fires after the object term cache has been cleaned.

```php
do_action( 'clean_object_term_cache', array $object_ids, string $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_ids` | array | Object IDs |
| `$object_type` | string | Object type |

---

### clean_taxonomy_cache

Fires after a taxonomy's caches have been cleaned.

```php
do_action( 'clean_taxonomy_cache', string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy slug |

---

## Hierarchy

### get_ancestors

Filters a given object's ancestors.

```php
apply_filters( 'get_ancestors', int[] $ancestors, int $object_id, string $object_type, string $resource_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ancestors` | int[] | Ancestor IDs |
| `$object_id` | int | Object ID |
| `$object_type` | string | Object type |
| `$resource_type` | string | `'post_type'` or `'taxonomy'` |

**Returns:** Modified ancestors array.

---

## Split Terms

### split_shared_term

Fires after a previously shared taxonomy term is split into two separate terms.

```php
do_action( 'split_shared_term', int $term_id, int $new_term_id, int $term_taxonomy_id, string $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Formerly shared term ID |
| `$new_term_id` | int | New term ID |
| `$term_taxonomy_id` | int | Term taxonomy ID |
| `$taxonomy` | string | Taxonomy slug |

---

## Term Exists

### term_exists_default_query_args

Filters default query arguments for checking if a term exists.

```php
apply_filters( 'term_exists_default_query_args', array $defaults, int|string $term, string $taxonomy, int|null $parent_term )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$defaults` | array | Default get_terms() arguments |
| `$term` | int\|string | Term to check |
| `$taxonomy` | string | Taxonomy name |
| `$parent_term` | int\|null | Parent term ID |

**Returns:** Modified defaults array.
