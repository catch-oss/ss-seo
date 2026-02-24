# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [6.0.0] - Unreleased

### Breaking
- Extensions are no longer auto-applied to framework classes (SiteConfig, SiteTree). Projects must opt in by adding the desired extensions to their own YAML config. See README.md for setup instructions.

### Changed
- Upgraded to Silverstripe 6 compatibility
- Updated PHP requirement to ^8.5
- Migrated test suite to PHPUnit 11
- `DataExtension` base class replaced with `Extension` (3 files)
- Added return type declarations to all methods
- Replaced `array()` syntax with `[]`
- Replaced `strpos()` with `str_contains()`
- Replaced `is_a()` string check with `instanceof` operator
- Extension hooks now typed as `void` return
- Named extension keys in YAML config (SS6 requirement)
- Fixed PSR-4 autoload mapping (`Catch\SS_SEO` → `CatchDesign\SS\SEO`)
- Moved project-level deps to `suggest` (abc-silverstripe, abc-silverstripe-social, googlesitemaps, queuedjobs)
- Added `silverstripe/cms` and `silverstripe/siteconfig` as explicit dependencies

### Added
- Full test suite (19 tests, 81% line coverage)
- phpunit.xml.dist with SS framework bootstrap
- MIGRATION-PLAN.md documenting all changes
- composer.lock for reproducible builds

### Fixed
- `strpos($url, 'index.php') == false` bug (loose comparison always true for position 0)
- `RedirectorPage_Controller` SS3-era string reference updated to FQCN instanceof check
- Null safety for `Controller::curr()` (returns null in SS6)
- Null coalescing for `$_SERVER['REQUEST_URI']` access
