# WordPress JavaScript Coding Standards

## Naming Conventions

### Variables and Functions

```javascript
// ✅ camelCase for variables and functions
let postId = 123;
const userName = 'admin';
function getUserData() {}

// ❌ Wrong
let post_id = 123;      // snake_case
let PostId = 123;       // PascalCase for non-classes
```

### Classes and Constructors

```javascript
// ✅ PascalCase for classes
class PostEditor {
	constructor( postId ) {
		this.postId = postId;
	}
}

const editor = new PostEditor( 123 );
```

### Constants

```javascript
// ✅ SCREAMING_SNAKE_CASE for true constants
const MAX_POSTS_PER_PAGE = 10;
const API_ENDPOINT = '/wp-json/wp/v2/';

// camelCase OK for const references that could change
const currentUser = wp.data.select( 'core' ).getCurrentUser();
```

### Private Members

```javascript
// ✅ Underscore prefix for private (convention)
class MyClass {
	constructor() {
		this._privateData = {};
	}
	
	_privateMethod() {}
	
	publicMethod() {}
}

// ✅ ES2022 private fields (if supported)
class MyClass {
	#privateField = 'secret';
	
	#privateMethod() {}
}
```

### jQuery Variables

```javascript
// ✅ Prefix jQuery objects with $
const $container = jQuery( '.container' );
const $buttons = jQuery( 'button' );

// ❌ Wrong
const container = jQuery( '.container' );  // Unclear it's jQuery
```

---

## Formatting

### Indentation

- **Use TABS** (consistent with PHP standards)

```javascript
// ✅ Tabs
function example() {
	if ( condition ) {
		doSomething();
	}
}
```

### Spacing

**Inside parentheses and brackets:**
```javascript
// ✅ Spaces inside parentheses (WP style)
if ( condition ) {}
for ( let i = 0; i < 10; i++ ) {}
myFunction( arg1, arg2 );
const arr = [ 1, 2, 3 ];
const obj = { key: 'value' };

// Exception: Empty constructs
const empty = {};
const emptyArr = [];
```

**Around operators:**
```javascript
// ✅ Spaces around operators
const sum = a + b;
const result = condition ? 'yes' : 'no';
const combined = obj1 && obj2;
```

### Semicolons

**Always use semicolons:**
```javascript
// ✅ Semicolons required
const value = 123;
doSomething();

// ❌ Wrong (ASI can cause bugs)
const value = 123
doSomething()
```

### Quotes

**Use single quotes** (except to avoid escaping):
```javascript
// ✅ Single quotes
const message = 'Hello, world!';
const html = '<div class="container">Content</div>';

// ✅ Double quotes to avoid escaping
const quote = "It's a nice day";
```

### Line Length

- Target **80 characters** max
- Hard limit at **100 characters**

```javascript
// ✅ Break long lines
const result = someLongFunctionName(
	firstArgument,
	secondArgument,
	thirdArgument
);

// ✅ Method chaining
jQuery( '.element' )
	.addClass( 'active' )
	.find( 'span' )
	.text( 'Updated' );
```

---

## Objects and Arrays

### Object Literal Shorthand

```javascript
// ✅ Use shorthand when variable name matches key
const name = 'John';
const age = 30;

const user = { name, age };  // Same as { name: name, age: age }
```

### Trailing Commas

```javascript
// ✅ Trailing commas in multi-line
const config = {
	setting1: true,
	setting2: false,
	setting3: 'value',  // Trailing comma
};

const items = [
	'one',
	'two',
	'three',  // Trailing comma
];
```

### Destructuring

```javascript
// ✅ Use destructuring for cleaner code
const { postId, title, content } = postData;
const [ first, second, ...rest ] = items;

// Function parameters
function processPost( { id, title, status = 'draft' } ) {
	// Use id, title, status directly
}
```

---

## Functions

### Arrow Functions

```javascript
// ✅ Use arrow functions for callbacks
const doubled = numbers.map( ( num ) => num * 2 );

// ✅ Parentheses always for parameters (WP style)
items.forEach( ( item ) => {
	console.log( item );
} );

// ❌ Avoid arrow functions for methods that need `this`
const obj = {
	value: 42,
	getValue: () => this.value,  // Wrong! `this` is lexical
};
```

### Default Parameters

```javascript
// ✅ Use default parameters
function createPost( title, status = 'draft', author = null ) {
	// ...
}

// ❌ Old pattern
function createPost( title, status, author ) {
	status = status || 'draft';  // Fails for falsy values
}
```

### Rest and Spread

```javascript
// ✅ Rest parameters
function logAll( first, ...rest ) {
	console.log( first );
	rest.forEach( ( item ) => console.log( item ) );
}

// ✅ Spread operator
const merged = { ...defaults, ...userOptions };
const combined = [ ...arr1, ...arr2 ];
```

---

## Asynchronous Code

### Promises Over Callbacks

```javascript
// ✅ Use Promises
function fetchPost( id ) {
	return fetch( `/wp-json/wp/v2/posts/${ id }` )
		.then( ( response ) => response.json() );
}

// ✅ async/await for cleaner code
async function fetchPost( id ) {
	const response = await fetch( `/wp-json/wp/v2/posts/${ id }` );
	return response.json();
}
```

### Error Handling

```javascript
// ✅ Always handle errors in async code
async function loadData() {
	try {
		const data = await fetchData();
		processData( data );
	} catch ( error ) {
		console.error( 'Failed to load data:', error );
		showErrorMessage();
	}
}

// ✅ Promise error handling
fetchData()
	.then( ( data ) => processData( data ) )
	.catch( ( error ) => handleError( error ) );
```

---

## DOM Manipulation

### Use WordPress APIs When Available

```javascript
// ✅ Use wp.element for React-based admin
import { createElement } from '@wordpress/element';
import { Button } from '@wordpress/components';

// ✅ Use wp.dom utilities
import { focus } from '@wordpress/dom';
```

### jQuery Best Practices

```javascript
// ✅ Cache jQuery selections
const $container = jQuery( '.container' );
$container.find( '.item' ).addClass( 'active' );
$container.find( '.other' ).hide();

// ❌ Repeated selections
jQuery( '.container' ).find( '.item' ).addClass( 'active' );
jQuery( '.container' ).find( '.other' ).hide();

// ✅ Use event delegation
jQuery( document ).on( 'click', '.dynamic-button', function() {
	// Handle click
} );

// ✅ Document ready
jQuery( document ).ready( function( $ ) {
	// $ is available locally without conflict
} );

// Or shorter:
jQuery( function( $ ) {
	// Same as document ready
} );
```

---

## WordPress-Specific Patterns

### Localization (wp_localize_script)

```javascript
// Data passed from PHP via wp_localize_script
// PHP: wp_localize_script( 'my-script', 'myPluginData', array( ... ) );

// ✅ Access localized data
const apiUrl = myPluginData.apiUrl;
const nonce = myPluginData.nonce;

// ✅ Check if data exists
if ( typeof myPluginData !== 'undefined' ) {
	// Safe to use
}
```

### AJAX with WordPress

```javascript
// ✅ Using jQuery AJAX with WP
jQuery.ajax( {
	url: ajaxurl,  // Defined in admin
	type: 'POST',
	data: {
		action: 'my_plugin_action',
		nonce: myPluginData.nonce,
		post_id: postId,
	},
	success: function( response ) {
		if ( response.success ) {
			// Handle success
		} else {
			// Handle error
		}
	},
	error: function( xhr, status, error ) {
		console.error( 'AJAX error:', error );
	},
} );

// ✅ Using apiFetch (modern)
import apiFetch from '@wordpress/api-fetch';

apiFetch( {
	path: '/wp/v2/posts/123',
	method: 'POST',
	data: { title: 'New Title' },
} ).then( ( post ) => {
	console.log( post );
} );
```

### Gutenberg/Block Editor

```javascript
// ✅ Use @wordpress packages
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

registerBlockType( 'my-plugin/my-block', {
	title: __( 'My Block', 'my-plugin' ),
	edit: function Edit() {
		const blockProps = useBlockProps();
		return (
			<div { ...blockProps }>
				<p>{ __( 'Hello from the editor!', 'my-plugin' ) }</p>
			</div>
		);
	},
	save: function Save() {
		const blockProps = useBlockProps.save();
		return (
			<div { ...blockProps }>
				<p>Hello from the frontend!</p>
			</div>
		);
	},
} );
```

---

## Module Patterns

### IIFE for Isolation

```javascript
// ✅ IIFE prevents global scope pollution
( function( $ ) {
	'use strict';
	
	const privateVar = 'secret';
	
	function privateFunction() {}
	
	// Expose public API
	window.MyPlugin = {
		init: function() {},
		doSomething: function() {},
	};
} )( jQuery );
```

### ES Modules (with build tools)

```javascript
// ✅ Named exports
export function processData( data ) {}
export const CONFIG = { ... };

// ✅ Default export
export default class MyPlugin {}

// ✅ Imports
import MyPlugin, { processData, CONFIG } from './my-plugin';
```

---

## Strict Mode

**Always use strict mode:**

```javascript
// ✅ At top of file or function
'use strict';

function example() {
	'use strict';
	// ...
}
```

ES modules are automatically in strict mode.

---

## Common Mistakes

### Variable Declaration

```javascript
// ❌ Never use var (hoisting issues)
var value = 123;

// ✅ Use const by default
const value = 123;

// ✅ Use let only when reassignment needed
let counter = 0;
counter++;
```

### Equality Comparisons

```javascript
// ❌ Loose equality (type coercion)
if ( value == null ) {}
if ( count == 0 ) {}

// ✅ Strict equality
if ( value === null ) {}
if ( count === 0 ) {}

// ✅ Exception: Check null OR undefined
if ( value == null ) {}  // OK, common idiom
```

### This Binding

```javascript
// ❌ Lost this context
class MyClass {
	constructor() {
		this.value = 42;
		jQuery( '.btn' ).on( 'click', this.handleClick );  // `this` is wrong
	}
	
	handleClick() {
		console.log( this.value );  // undefined or error
	}
}

// ✅ Bind this or use arrow function
class MyClass {
	constructor() {
		this.value = 42;
		jQuery( '.btn' ).on( 'click', this.handleClick.bind( this ) );
		// Or:
		jQuery( '.btn' ).on( 'click', ( e ) => this.handleClick( e ) );
	}
	
	handleClick() {
		console.log( this.value );  // 42
	}
}
```
