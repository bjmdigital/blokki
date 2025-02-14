# Changelog

**1.10.0**

*2025-01-20*

- Feature: Added Schema for DefinedTerm and Single CPT Schema
- Fix: Multiple Taxonomy Terms field compatibility with ACF PRO V6.3.11
- Dev: Version number bump to 1.10.0

**1.0.9**

*2024-09-18*

- Feature: Added padding and margin options to Blokki Grid and Blokki Grid Column
- Fix: Removed the auto addition of `image` in Post Type Config for Blokki Cards [Maybe a Breaking Change]
- Dev: Version number bump to 1.0.9

**1.0.8**

*2023-09-22*

- Feature: Added Card Block option to link_card 
- Fix: strip_tags for card block title when used in the link
- Fix: styling for link_card option
- Dev: Version number bump to 1.0.8

**1.0.7**

*2023-05-26*

- Feature: Option to toggle registered blocks and block controls (spacing, visibility etc.)
- Fix: Removed the reusable blocks integration with lightbox block control
- Dev: Packages update to the latest versions and version number bump to 1.0.7

**1.0.6**

*2023-05-19*

- Fix: WPGB integration fix for content exclude query in grid settings.
- Fix: ACF warning for function acf_get_value was called incorrectly
- Dev: Packages update to the latest versions and version number bump to 1.0.6
- Dev: Fixed plugin creation script to create the zip with a main directory instead of all plugin files

**1.0.5**

*2023-05-06*

- Feature: Option to disable WPGB integration.
- Dev: Packages update to the latest versions and version number bump to 1.0.5
- Fix: CSS grid compatibility with overflow-wrap and word-wrap

**1.0.4**

*2023-05-06*

- Feature: Ability to provide auto updates for the plguin from GitHub repo releases.
- Dev: Packages update to the latest versions and version number bump to 1.0.4

**1.0.3**

*2022-11-15*

- Feature: For Blokki Cards block, now, there is an option to show the `related` posts. There is also an option to select which taxonomies to use for getting the related taxonomies. This applies to both Blokki Cards and WPGB integration.
- Feature: A new block *Blokki Content Accordion* added that can be used for any custom content toggle. 
- Feature : Keyboard Tab key skip configuration added to `title`, `image` and `readmore`
- Dev: Code Cleanup and removed the WPGB block which was experimental and was not working.
- Dev: Some helper functions are added to get the block classes for ACF built blocks.
- Dev: Packages update to the latest versions and version number bump to 1.0.3


**1.0.2**

*2022-08-11*

- Fix: post type selection dropdown for cards query and case of specific posts
- Fix: blokki settings for wpgb grid integration for related and archive grid selection
- Fix: blokki acf block classes and helper function
- Dev: Updating npm command to create zip and readme updates
- Dev: Packages update to the latest versions and version number bump to 1.0.2

**1.0.1**

*2022-07-08*

- Dev: Updated npm packages to the latest versions
- Dev: Ability to create `.zip` file for plugin release
- Dev: Code Optimization and Refactoring
- Fix: Blokki block controls for spacing and visibility only to core, acf and blokki block types
- Fix: composer autoload path
- Fix: visibility and spacing controls not adding CSS classes
- Fix: Block alignment class added to social share block
- Schema Feature:
    - FAQPage Schema added for accordion block
    - Added ItemList schema for cards block
    - Option to turn off schema in plugin settings
    - Option to disable schema on Cards block
    - Caching System for Schema added by plugin for speed optimization

**1.0.0**

* Initial Release of plugin
