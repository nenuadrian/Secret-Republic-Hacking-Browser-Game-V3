# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

@AGENTS.md

The imported `AGENTS.md` is the primary reference (commands, DI wiring, game constants, cron, docs generation). The notes below are things it doesn't cover.

## Fixtures and request formats

- `includes/install/DB.sql` hardcodes `AUTO_INCREMENT=18150` for `users` (and similar high counters elsewhere), so the first account on a fresh MySQL install is id 18150. That's expected.
- Login is a POST to `/` with `username`, `password`, `process=1`; registration is a POST to `/register` with `username,password,email,zone(1-6),terms,process`.

## Gotchas when changing code

- **MysqliDb**: the vendored lib is `dev-master`. The old `where('col', array('>' => $v))` form is gone — use `where('col', $v, '>')`. Strict SQL mode is on: inserts must supply every NOT NULL column that lacks a default (e.g. `user_bank.amount`), and `UPDATE`s must not write NULL into NOT NULL columns (use `COALESCE`).
- **PHP 8.5**: type errors are fatal (e.g. `number_format()` with a string). Check string-vs-number handling when touching old code.
- **Includes**: modules run with CWD `public_html/`, so requires are `../includes/class/...`. A bare `class/...` path will fail.
- **Smarty 4.5**: templates call plain PHP functions as modifiers (`date_fashion`, `profile_link`, `sec2hms`, `romanic_number`, `ordinal` in `includes/functions.php`; `ucfirst` etc.). There is no `registerPlugin` anywhere. This works on Smarty 4 but is deprecated and would break on Smarty 5. To check templates compile, stub those functions and call `createTemplate($n)->compileTemplateSource()` for every `.tpl` — unknown-modifier errors appear at compile time.
- **Cron endpoints**: `cron.php` must `return` after `show_404()` (it only sets a flag).
- **Verification**: `composer test` doesn't render logged-in pages or run modules against MySQL. To check a change in the real app, log in over HTTP with curl and a cookie jar and grep responses for `CARDINAL SYSTEM ERROR` / `Uncaught`.
