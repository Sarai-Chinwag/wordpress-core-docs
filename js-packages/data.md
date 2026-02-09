# @wordpress/data

State management for WordPress applications. Provides a registry of stores with actions, selectors, resolvers, and controls.

## Core Concepts

- **Store**: A named namespace with reducers, actions, selectors, controls, and resolvers.
- **Selectors**: Read state (sync or async via resolvers).
- **Actions**: Dispatch state changes or control side effects.
- **Resolvers**: Async data resolution tied to selectors.
- **Registry**: Holds multiple stores and exposes select/dispatch.

## Key APIs

### `createReduxStore( storeName, config )`
Creates a store definition that can be registered.

- `storeName` `string`
- `config` `object`
  - `reducer( state, action )`
  - `actions`: action creators
  - `selectors`: selector functions
  - `controls`: generator action handlers
  - `resolvers`: selector resolvers
  - `initialState`

### `registerStore( storeName, config )`
Registers a store directly into the default registry. Returns a store descriptor.

### `select( storeName )`
Returns the selectors for a store.

### `dispatch( storeName )`
Returns the action creators for a store.

### `useSelect( mapSelect, deps? )`
React hook to access selectors.

- `mapSelect( select )` receives `select` function.
- `deps` optional dependency array.

### `useDispatch( storeName? )`
React hook to get action creators from a store. If no store name, returns `dispatch` function for custom usage.

### `subscribe( listener )`
Subscribes to registry changes. Returns unsubscribe function.

### `createRegistry()` / `createRegistryControl`
Create isolated registries and custom controls for advanced data flow.

## Store Shape (Config)

- **actions**: `{ actionName: ( ...args ) => ( { type, ...payload } ) }`
- **selectors**: `{ selectorName: ( state, ...args ) => value }`
- **resolvers**: `{ selectorName: ( ...args ) => function* resolver() { ... } }`
- **controls**: `{ actionType: ( action ) => Promise | any }`
