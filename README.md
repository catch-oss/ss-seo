# SS SEO

SEO enhancements for Silverstripe.

- Adds `Robots` tab to site settings with editable robots.txt content
- Serves `/robots.txt` via a controller that returns plain text from the database
- Handles canonical URL redirects (301) to prevent duplicate content
- Per-page `X-Robots-Tag` header control (noindex, nofollow, etc.)
- Reduces Silverstripe GD image quality to 70

## Compatibility

| Version | Silverstripe | PHP |
|---------|-------------|-----|
| 6.x | ^6.0 | ^8.5 |
| 5.x | ^5.1 | >=8.1 |

## Installation

```bash
composer require catch/ss-seo
```

## Usage

### Robots.txt

The module registers a route at `/robots.txt` that serves content from the `Robots` tab in **Settings > Site Configuration**. Edit the robots.txt content directly in the CMS.

### Canonical URLs

The `CanonicalExtension` automatically redirects (301) requests to the canonical URL for each page. It:
- Strips `index.php` from URLs
- Redirects `/home` to `/`
- Skips POST requests to avoid data loss

### Per-page Robots Meta Tag

The `SiteTreeRobotsExtension` adds an `X-Robots-Tag` HTTP header to every page response. Configure per-page directives (noindex, nofollow, etc.) under **Page > Settings > Robots**.

### Image Quality

Default image quality is set to 70 via Injector config. To override, add to your project config:

```yaml
SilverStripe\Core\Injector\Injector:
  SilverStripe\Assets\Image_Backend:
    properties:
      Quality: 85
```
