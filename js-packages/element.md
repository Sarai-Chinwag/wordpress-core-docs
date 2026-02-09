# @wordpress/element

React-compatible element abstraction used throughout WordPress.

## Core APIs

### `createElement( type, props, ...children )`
Creates a React element. Equivalent to `React.createElement`.

### `render( element, domNode )`
Renders an element into a DOM node.

### Hooks

- `useState( initialState )`
- `useEffect( effect, deps? )`
- `useMemo( factory, deps )`
- `useCallback( fn, deps )`
- `useRef( initialValue )`
- `useReducer( reducer, initialArg, init? )`
- `useContext( context )`

## Component Base Classes

- `Component`
- `PureComponent`
