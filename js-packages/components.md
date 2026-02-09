# @wordpress/components

UI component library used across WordPress admin and editor.

## Common Components

### `Button`
Interactive button component.

Common props:
- `variant`: `primary | secondary | tertiary`
- `isPrimary`, `isSecondary`, `isTertiary` (legacy)
- `isBusy`, `isDestructive`, `isSmall`
- `icon`, `iconPosition`, `text`
- `onClick`

### `Panel` / `PanelBody`
Accordion-style panels for inspector controls.

Props:
- `title`, `initialOpen`, `opened`

### `Modal`
Dialog overlay.

Props:
- `title`, `onRequestClose`, `isDismissible`

### `Spinner`
Loading indicator.

Props:
- `size`

## Additional Common Components

- `CheckboxControl`, `ToggleControl`, `SelectControl`, `TextControl`, `TextareaControl`
- `RangeControl`, `ColorPicker`
- `Notice`, `SnackbarList`
- `TabPanel`, `MenuGroup`, `MenuItem`
- `Dropdown`, `Popover`, `Tooltip`
- `Flex`, `FlexItem`, `FlexBlock`
- `Card`, `CardHeader`, `CardBody`, `CardFooter`

## Icons

Use `icon` prop with `@wordpress/icons` exports.
