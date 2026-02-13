# Customize Classes

WordPress Customizer class files providing controls, settings, sections, panels, and selective refresh for the Customizer (Theme Customization API).

**Source:** `wp-includes/customize/`

## Class Hierarchy

```
WP_Customize_Setting (base, defined in class-wp-customize-setting.php)
├── WP_Customize_Filter_Setting
├── WP_Customize_Background_Image_Setting (final)
├── WP_Customize_Header_Image_Setting (final)
├── WP_Customize_Custom_CSS_Setting (final)
├── WP_Customize_Nav_Menu_Item_Setting
└── WP_Customize_Nav_Menu_Setting

WP_Customize_Control (base, defined in class-wp-customize-control.php)
├── WP_Customize_Color_Control
├── WP_Customize_Media_Control
│   └── WP_Customize_Upload_Control
│       └── WP_Customize_Image_Control
│           ├── WP_Customize_Background_Image_Control
│           ├── WP_Customize_Cropped_Image_Control
│           │   └── WP_Customize_Site_Icon_Control
│           └── WP_Customize_Header_Image_Control
├── WP_Customize_Background_Position_Control
├── WP_Customize_Code_Editor_Control
├── WP_Customize_Date_Time_Control
├── WP_Customize_Theme_Control
├── WP_Customize_Nav_Menu_Control
├── WP_Customize_Nav_Menu_Item_Control
├── WP_Customize_Nav_Menu_Auto_Add_Control
├── WP_Customize_Nav_Menu_Location_Control
├── WP_Customize_Nav_Menu_Locations_Control
├── WP_Customize_Nav_Menu_Name_Control
├── WP_Customize_New_Menu_Control (deprecated 4.9.0)
├── WP_Widget_Area_Customize_Control
├── WP_Widget_Form_Customize_Control
└── WP_Sidebar_Block_Editor_Control

WP_Customize_Section (base, defined in class-wp-customize-section.php)
├── WP_Customize_Themes_Section
├── WP_Customize_Sidebar_Section
├── WP_Customize_Nav_Menu_Section
└── WP_Customize_New_Menu_Section (deprecated 4.9.0)

WP_Customize_Panel (base, defined in class-wp-customize-panel.php)
├── WP_Customize_Themes_Panel
└── WP_Customize_Nav_Menus_Panel

WP_Customize_Selective_Refresh (standalone, final)
WP_Customize_Partial (standalone)
```

## Documentation Files

### Controls

| File | Description |
|------|-------------|
| [controls-media.md](./controls-media.md) | Media, Upload, Image, Background Image, Cropped Image, Site Icon, Header Image controls |
| [controls-input.md](./controls-input.md) | Color, Code Editor, Date/Time, Background Position controls |
| [controls-theme.md](./controls-theme.md) | Theme control |
| [controls-nav-menu.md](./controls-nav-menu.md) | Nav Menu controls (menu, item, name, auto-add, location, locations) |
| [controls-widget.md](./controls-widget.md) | Widget Area, Widget Form, Sidebar Block Editor controls |

### Settings

| File | Description |
|------|-------------|
| [settings.md](./settings.md) | Filter, Background Image, Header Image, Custom CSS, Nav Menu, Nav Menu Item settings |

### Sections

| File | Description |
|------|-------------|
| [sections.md](./sections.md) | Themes, Sidebar, Nav Menu, New Menu sections |

### Panels

| File | Description |
|------|-------------|
| [panels.md](./panels.md) | Themes and Nav Menus panels |

### Selective Refresh

| File | Description |
|------|-------------|
| [selective-refresh.md](./selective-refresh.md) | WP_Customize_Selective_Refresh and WP_Customize_Partial |
