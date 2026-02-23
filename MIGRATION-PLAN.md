# Migration Plan: ss-seo

## Summary

- **Package**: catch/ss-seo
- **Type**: B (Silverstripe module)
- **Tier**: 7 (highest — depends on abc-silverstripe, abc-silverstripe-social)
- **Risk Level**: Low
- **Estimated Scope**: 5 files, 4 classes (+ 2 YAML configs)
- **Source directory**: `code/` (PSR-4 mapped in composer.json)

## Change Inventory

### Namespace Renames Required

| Old Namespace | New Namespace | Files Affected |
|---|---|---|
| `SilverStripe\ORM\DataExtension` | `SilverStripe\Core\Extension` | CanonicalExtension.php, SSRobotsConfigExtension.php, SiteTreeRobotsExtension.php |

### Composer Dependency Changes

| Package | Current Version | Target Version | Notes |
|---|---|---|---|
| `php` | `>=8.1` | `^8.5` | |
| `silverstripe/framework` | `*` | `^6.0` | |
| `silverstripe/googlesitemaps` | `*` | `^4.0` | Package may be `wilr/silverstripe-googlesitemaps` — verify actual SS6 package name |
| `symbiote/silverstripe-queuedjobs` | `*` | `^6.0` | |
| `azt3k/abc-silverstripe` | `*` | `dev-release/6` | Tier 4, PR_OPEN |
| `azt3k/abc-silverstripe-social` | `*` | `dev-release/6` | Tier 6, CI_READY — must complete first |
| `composer/installers` | `*` | `^2.0` | |
| `silverstripe/vendor-plugin` | _(missing)_ | `^3.0` | **Add** — required for SS6 vendormodule type |
| `phpunit/phpunit` | `~9@stable` | `^11.0` | Move to require-dev |
| `silverstripe/recipe-cms` | _(missing)_ | `^6.0` | **Add** to require-dev — provides Page/PageController for tests |

### Autoload Fix

The current `composer.json` maps `Catch\\SS_SEO\\` to `code/` but all source files use namespace `CatchDesign\SS\SEO`. This mismatch must be corrected:

| Current | Corrected |
|---|---|
| `"Catch\\SS_SEO\\": "code/"` | `"CatchDesign\\SS\\SEO\\": "code/"` |

### API Changes Required

| Pattern | Migration | Files Affected |
|---|---|---|
| `extends DataExtension` | `extends Extension` | CanonicalExtension.php, SSRobotsConfigExtension.php, SiteTreeRobotsExtension.php |
| `is_a($controller, 'RedirectorPage_Controller')` | `$controller instanceof \SilverStripe\CMS\Controllers\RedirectorPageController` | CanonicalExtension.php:80 |
| `strpos($url, 'index.php') == false` | `!str_contains($url, 'index.php')` | CanonicalExtension.php:59 (also fixes existing bug — `==` should be `===`) |

### PHP 8.5 Compatibility Fixes

| Issue | Fix | Files Affected |
|---|---|---|
| Missing return type on `index()` | Add `: \SilverStripe\Control\HTTPResponse` | SSRobotsController.php |
| Missing return types on extension methods | Add `: void` or appropriate types | All 3 extension files |
| Missing return types on protected helpers | Add return types (`bool`, `string`, `?string`) | CanonicalExtension.php (6 methods) |
| `array()` syntax | Replace with `[]` | SSRobotsController.php, SSRobotsConfigExtension.php, SiteTreeRobotsExtension.php |
| Missing parameter types | Add types where missing | CanonicalExtension.php (`$controller` params) |

### PHPUnit Migration

| Issue | Fix | Files Affected |
|---|---|---|
| No phpunit.xml.dist | Create from template with SS framework bootstrap | _(new file)_ |
| No test suite | Write tests for all 4 classes from scratch | _(new directory `tests/`)_ |

### Config Changes

| File | Change Required |
|---|---|
| `_config/config.yml` | Add named keys to all 3 extension registrations (SS6 requirement) |
| `_config/routes.yml` | No changes needed (uses FQCN already) |
| `_config.php` | No changes needed (empty) |

#### config.yml — Before:
```yaml
SilverStripe\SiteConfig\SiteConfig:
  extensions:
    - CatchDesign\SS\SEO\Extensions\SSRobotsConfigExtension

SilverStripe\CMS\Model\SiteTree:
  extensions:
    - CatchDesign\SS\SEO\Extensions\CanonicalExtension
    - CatchDesign\SS\SEO\Extensions\SiteTreeRobotsExtension
```

#### config.yml — After:
```yaml
SilverStripe\SiteConfig\SiteConfig:
  extensions:
    ss-robots-config: CatchDesign\SS\SEO\Extensions\SSRobotsConfigExtension

SilverStripe\CMS\Model\SiteTree:
  extensions:
    ss-canonical: CatchDesign\SS\SEO\Extensions\CanonicalExtension
    ss-site-tree-robots: CatchDesign\SS\SEO\Extensions\SiteTreeRobotsExtension
```

## Risk Assessment

| Area | Risk | Notes |
|---|---|---|
| Namespace renames | Low | Only `DataExtension` → `Extension` (3 files) |
| API changes | Low | `RedirectorPage_Controller` string fix + `strpos` bug fix |
| PHP 8.5 compat | Low | Return type declarations, minor syntax |
| Test migration | Medium | No existing tests — full suite must be written from scratch |
| Config changes | Low | Named extension keys only |
| Dependencies | Medium | Blocked on abc-silverstripe (Tier 4) and abc-silverstripe-social (Tier 6) completing first |

## Migration Steps (Ordered)

### Phase 1: composer.json
- [ ] Fix PSR-4 autoload: `Catch\\SS_SEO\\` → `CatchDesign\\SS\\SEO\\`
- [ ] Update `php` to `^8.5`
- [ ] Update `silverstripe/framework` to `^6.0`
- [ ] Update `silverstripe/googlesitemaps` to `^4.0` (verify package name)
- [ ] Update `symbiote/silverstripe-queuedjobs` to `^6.0`
- [ ] Update `azt3k/abc-silverstripe` to `dev-release/6`
- [ ] Update `azt3k/abc-silverstripe-social` to `dev-release/6`
- [ ] Update `composer/installers` to `^2.0`
- [ ] Add `silverstripe/vendor-plugin: ^3.0` to require
- [ ] Update `phpunit/phpunit` to `^11.0`
- [ ] Add `silverstripe/recipe-cms: ^6.0` to require-dev
- [ ] Add `silverstripe/recipe-plugin: true` to allow-plugins
- [ ] Add `silverstripe/vendor-plugin: true` to allow-plugins
- [ ] Add autoload-dev with classmap for Page/PageController and test PSR-4
- [ ] Run `composer validate`

### Phase 2: Namespace Renames
- [ ] Replace `use SilverStripe\ORM\DataExtension` with `use SilverStripe\Core\Extension` (3 files)
- [ ] Replace `extends DataExtension` with `extends Extension` (3 files)

### Phase 3: API Changes
- [ ] Replace `is_a($controller, 'RedirectorPage_Controller')` with `$controller instanceof \SilverStripe\CMS\Controllers\RedirectorPageController` (CanonicalExtension.php:80)
- [ ] Replace `strpos($url, 'index.php') == false` with `!str_contains($url, 'index.php')` (CanonicalExtension.php:59)

### Phase 4: PHP 8.5 Compatibility
- [ ] Add return type declarations to all methods (4 files, ~15 methods)
- [ ] Add parameter type declarations where missing
- [ ] Replace `array()` with `[]` (3 files)
- [ ] Verify no implicit nullable parameters

### Phase 5: Logging Integration
- [ ] _Not applicable_ — this module has no logging. No Monolog integration needed.

### Phase 6: Config Updates
- [ ] Add named keys to extension registrations in `_config/config.yml` (3 extensions)

### Phase 7: Test Suite (Silverstripe Best Practices)
- [ ] Add `silverstripe/recipe-cms: ^6.0` to require-dev (provides Page/PageController)
- [ ] Add `silverstripe/recipe-plugin: true` to allow-plugins
- [ ] Create `phpunit.xml.dist` with bootstrap `vendor/silverstripe/framework/tests/bootstrap.php`
- [ ] Add recipe-generated files to .gitignore: `app/`, `public/`, `.htaccess`, `index.php`, `web.config`
- [ ] Add autoload-dev classmap for `app/src/Page.php`, `app/src/PageController.php`
- [ ] Add autoload-dev PSR-4 for `CatchDesign\\SS\\SEO\\Tests\\: tests/`
- [ ] Write `tests/Controllers/SSRobotsControllerTest.php` — FunctionalTest for robots.txt route
- [ ] Write `tests/Extensions/CanonicalExtensionTest.php` — FunctionalTest for redirect behavior
- [ ] Write `tests/Extensions/SSRobotsConfigExtensionTest.php` — SapphireTest for CMS field addition
- [ ] Write `tests/Extensions/SiteTreeRobotsExtensionTest.php` — SapphireTest/FunctionalTest for X-Robots-Tag header
- [ ] Use GIVEN/WHEN/THEN comment convention in all test methods
- [ ] Use `$usesDatabase = false` where possible, fixtures where needed
- [ ] Achieve 80% line coverage target

## Test Plan Detail

### SSRobotsControllerTest (FunctionalTest)
- Test that GET `/robots.txt` returns 200 with text/plain content type
- Test that response body matches SiteConfig `SSRobotsRobotTXT` value

### CanonicalExtensionTest (FunctionalTest)
- Test that `/home` redirects 301 to `/`
- Test that non-canonical URL redirects 301 to canonical
- Test that POST requests are not redirected
- Test that correct canonical URL is already served without redirect
- Test `hasIndex()` strips `index.php` from URLs

### SSRobotsConfigExtensionTest (SapphireTest)
- Test that `SSRobotsRobotTXT` field is added to SiteConfig CMS fields
- Test that the field is a TextareaField on the Robots tab

### SiteTreeRobotsExtensionTest (FunctionalTest)
- Test that X-Robots-Tag header is set on page responses
- Test that RobotsTag field appears in Settings tab
- Test default value is `all` when no tag set
- Test that custom tag values are sanitized (non-alpha/comma stripped)

## Dependencies

- **Depends on**: abc-silverstripe (Tier 4, PR_OPEN), abc-silverstripe-social (Tier 6, CI_READY)
- **Blocks**: nothing (highest tier — final repo in migration chain)
