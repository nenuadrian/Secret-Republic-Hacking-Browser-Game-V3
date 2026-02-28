# Request Routing

Routing is handled in `public_html/index.php` by mapping URL segments to files inside `includes/modules/`.

## Lifecycle Summary

1. Bootstrap Composer autoload and Smarty.
2. Parse request path into a module key and key/value parameters.
3. Resolve module file from `includes/modules/*.php`.
4. Include shared boot logic from `includes/header.php`.
5. Execute module and render Smarty templates.

## Route Resolution Rules

- Missing module defaults to `main/main`.
- If `includes/database_info.php` is missing, routing is forced to `setup`.
- If route points to a folder (example: `grid`), runtime attempts `includes/modules/grid/grid.php`.

## Data Passed To Modules

- Parsed path pairs are stored in `$GET`.
- Current module path is tracked in `$GET['currentPage']`.
- Template variables are assembled in `$tVars` and rendered at the end of the request.
