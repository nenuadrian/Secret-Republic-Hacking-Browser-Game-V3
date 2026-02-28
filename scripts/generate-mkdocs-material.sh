#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

mkdir -p docs/reference docs/architecture docs/project

modules_count="$(find includes/modules -type f -name '*.php' | wc -l | tr -d '[:space:]')"
classes_count="$(find includes/class -type f -name '*.php' | wc -l | tr -d '[:space:]')"
constants_count="$(find includes/constants -type f -name '*.php' | wc -l | tr -d '[:space:]')"
tests_count="$(find tests -type f -name '*Test.php' | wc -l | tr -d '[:space:]')"

cat > docs/index.md <<EOF_INDEX
# Secret Republic V3 Documentation

This documentation is generated from project sources, with material extracted from \`README.md\`, \`includes/\`, and \`tests/\`.

## Repository Snapshot

- PHP modules discovered: **${modules_count}**
- PHP class files discovered: **${classes_count}**
- Constants/config files discovered: **${constants_count}**
- PHPUnit test files discovered: **${tests_count}**

## What Is Included

- README-based project documentation and setup notes
- Routing and request lifecycle notes from \`public_html/index.php\`
- Auto-generated module/class/constants/test inventories

## Next Steps

- Use the navigation sidebar to explore generated references.
- Update code and rerun \`./scripts/generate-mkdocs-material.sh\`.
EOF_INDEX

cat > docs/project/readme.md <<'EOF_README'
# README Snapshot

> This page is generated from `README.md` with image-heavy lines removed so it renders cleanly in MkDocs.

EOF_README

sed \
  -e '/^!\[/d' \
  -e '/<img /Id' \
  -e '/<p align="center">/Id' \
  -e '/<\/p>/Id' \
  README.md >> docs/project/readme.md

cat > docs/project/setup.md <<'EOF_SETUP'
# Setup

The canonical setup instructions live in `README.md` under **Simple-Setup** and **Cron jobs**.

## Fast Path

1. Install PHP + Composer + MySQL.
2. Run `composer install`.
3. Create a MySQL database.
4. Finish setup via `/public_html/setup` or manual SQL import + config file.

## Manual Essentials

- Import `includes/install/DB.sql`.
- Create `includes/database_info.php` from `includes/database_info.php.template`.
- Promote your first user to admin (`user_credentials.group_id = 1`).

## Cron Endpoints

The app expects periodic cron invocations (attacks, hourly, daily, rankings, resources). See README for exact URLs and schedules.
EOF_SETUP

cat > docs/project/testing-ci.md <<'EOF_TESTING'
# Testing And CI

## Local

- Install dependencies: `composer install`
- Run tests: `composer test`

## CI Workflows

- `.github/workflows/php.yml` runs unit tests on pushes and pull requests against `master`.
- `.github/workflows/docs.yml` builds and deploys MkDocs to GitHub Pages on `master`.

## Notes

If dependency installation fails locally, verify network access to Packagist and a supported PHP version.
EOF_TESTING

cat > docs/architecture/routing.md <<'EOF_ROUTING'
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
EOF_ROUTING

{
  echo "# Module Reference"
  echo
  echo "Generated from includes/modules/**/*.php."
  echo
  echo "| Route | Source file |"
  echo "| --- | --- |"

  find includes/modules -type f -name '*.php' | sort | while read -r file; do
    rel="${file#includes/modules/}"
    dir="$(dirname "$rel")"
    base="$(basename "$rel" .php)"

    if [[ "$rel" == "main/main.php" ]]; then
      route="/ (default), /main"
    elif [[ "$dir" == "." ]]; then
      route="/${base}"
    elif [[ "$base" == "$(basename "$dir")" ]]; then
      route="/${dir}"
    else
      route="/${rel%.php}"
    fi

    printf '| %s | %s |\n' "$route" "$file"
  done
} > docs/reference/modules.md

{
  echo "# Class Reference"
  echo
  echo "Generated from includes/class/**/*.php."
  echo
  echo "| Class name(s) | Method lines* | Source file |"
  echo "| --- | ---: | --- |"

  find includes/class -type f -name '*.php' | sort | while read -r file; do
    class_names="$({
      grep -Eho 'class[[:space:]]+[A-Za-z_][A-Za-z0-9_]*' "$file" \
        | awk '{print $2}' \
        | sort -u \
        | awk 'NF {if (seen++) printf(", "); printf("%s", $0)} END {print ""}'
    } || true)"

    method_lines="$(grep -Ehc 'function[[:space:]]+[A-Za-z_][A-Za-z0-9_]*[[:space:]]*\(' "$file" || true)"

    if [[ -z "$class_names" ]]; then
      class_names="(none detected)"
    fi

    printf '| `%s` | %s | `%s` |\n' "$class_names" "$method_lines" "$file"
  done

  echo
  echo "\\*Method lines are counted by static pattern matching."
} > docs/reference/classes.md

{
  echo "# Constants And Config Reference"
  echo
  echo "Generated from includes/constants/*.php."
  echo

  find includes/constants -type f -name '*.php' | sort | while read -r file; do
    vars="$({
      grep -Eho '^[[:space:]]*\$[A-Za-z_][A-Za-z0-9_]*[[:space:]]*=' "$file" \
        | sed -E 's/^[[:space:]]*//' \
        | sed -E 's/[[:space:]]*=//' \
        | sort -u \
        | awk 'NF {if (seen++) printf(", "); printf("%s", $0)} END {print ""}'
    } || true)"

    funcs="$({
      grep -Eho 'function[[:space:]]+[A-Za-z_][A-Za-z0-9_]*[[:space:]]*\(' "$file" \
        | sed -E 's/function[[:space:]]+([^\(]+).*/\1/' \
        | sort -u \
        | awk 'NF {if (seen++) printf(", "); printf("%s", $0)} END {print ""}'
    } || true)"

    if [[ -z "$vars" ]]; then
      vars="none"
    fi

    if [[ -z "$funcs" ]]; then
      funcs="none"
    fi

    echo "## $file"
    echo
    echo "- Global assignments: $vars"
    echo "- Functions: $funcs"
    echo
  done
} > docs/reference/constants.md

{
  echo "# Test Reference"
  echo
  echo "Generated from tests/*Test.php."
  echo
  echo "| Test file | Test method lines* | Assertion lines* |"
  echo "| --- | ---: | ---: |"

  find tests -type f -name '*Test.php' | sort | while read -r file; do
    method_lines="$(grep -Ehc 'public[[:space:]]+function[[:space:]]+test[A-Za-z0-9_]*[[:space:]]*\(' "$file" || true)"
    assert_lines="$(grep -Ehc '\$this->assert[A-Za-z0-9_]*[[:space:]]*\(' "$file" || true)"

    printf '| `%s` | %s | %s |\n' "$file" "$method_lines" "$assert_lines"
  done

  echo
  echo "\\*Counts are based on static pattern matching."
} > docs/reference/tests.md

echo "MkDocs material generated under docs/."
