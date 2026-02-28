# Testing And CI

## Local

- Install dependencies: `composer install`
- Run tests: `composer test`

## CI Workflows

- `.github/workflows/php.yml` runs unit tests on pushes and pull requests against `master`.
- `.github/workflows/docs.yml` builds and deploys MkDocs to GitHub Pages on `master`.

## Notes

If dependency installation fails locally, verify network access to Packagist and a supported PHP version.
