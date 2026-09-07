# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Kirby CMS 5 site built on the `beebmx/kirby-starterkit`. It is Kirby at its core, but wired up with a set of Laravel-flavoured layers from the `beebmx/*` plugin family: Blade templating (with Laravel's view components and container), `.env` config, Vite/Tailwind asset pipeline, a task scheduler, and pluggable email transports. Expect Laravel idioms in the templating/config layer and Kirby idioms everywhere else (content, blueprints, panel, page/file APIs).

## Commands

```sh
composer install && npm install
npm run dev          # Vite dev server (writes public/hot)
npm run build        # production assets -> public/build
composer test        # patches Kirby helpers (tests/helpers.php) then runs Pest
vendor/bin/pest tests/Feature/ExampleTest.php          # single file
vendor/bin/pest --filter 'test name'                   # single test
vendor/bin/pest --testsuite Unit                       # one suite
vendor/bin/pint       # format PHP (Laravel preset + blade rule)
npx prettier --write <path>   # format JS/Vue/Blade
```

Never run `vendor/bin/pest` directly on a clean checkout — `composer test` first runs `php tests/helpers.php`, which renames Kirby's global `dump()`/`e()` helpers in `vendor/` so they don't collide with PHPUnit's. Re-run it after any `composer install/update`.

Panel plugin (`site/plugins/app`, Vue 2 + kirbyup) has its own npm project: `npm run app-setup` once, then `npm run app-dev` (watch) or `npm run app` (build).

Kirby CLI commands are registered by the plugins and require the global `kirby` binary: `kirby view:clear` (purge compiled Blade views), `kirby make:component Name`, `kirby key:generate --env`, `kirby schedule:run|work|list|test`.

## Architecture

**Entry point** is `public/index.php` — the document root is `public/`, and all Kirby roots (`content`, `site`, `storage`, plus `accounts`/`cache`/`logs`/`sessions`/`license` under `storage/`) are declared there. It also disables Kirby's `e()`, `dump()`, and `go()` helpers via `KIRBY_HELPER_*` constants so the Laravel-side equivalents win.

**Config** lives in `site/config/config.php`, which is only a manifest: it loads the `.env` (`KirbyEnv::load`), sets `Cookie::$key`, and `require`s one file per concern from the same directory (`app.php`, `auth.php`, `cache.php`, `email.php`, `panel.php`, `routes.php`, `session.php`, `thumbs.php`, `blade.php`, `courier.php`, `plus.php`, `tasks.php`). Add options to the topic file, not to `config.php`. Every value should come from `env()` with a sane default; add new keys to `.env.example` too. `KIRBY_KEY` is used as both the cookie key and the content salt — changing it invalidates sessions and content UUID salting.

**Templating.** `beebmx/kirby-blade` swaps Kirby's `template` and `snippet` components for Blade-aware ones. A page template may be `site/templates/<name>.blade.php` or plain `<name>.php`; the Blade variant wins when both exist (see `Beebmx\KirbyBlade\Template::getFilename`). Compiled views go to `storage/views` (set in `site/config/blade.php`).

The Blade view finder is rooted at `site/templates/`, so subdirectories are plain includes, not page templates. Each page template is only a shell that `@include`s one file per section from `site/templates/sections/`, wrapped in `<x-layout>`: `home.blade.php` pulls `hero`, `about`, `bootcamp`, `courses`, `testimonials`, `cta`; `about.blade.php` pulls `story`, `mentors`, `culture`. Shared chrome lives in `site/templates/partials/` (`header`, `footer`, `social-icon`, `mentor-card`, `culture-icon`). Each section reads its own fields off `$page` and has a tab of the same name in that page's blueprint — add a section by creating the tab, the partial, and one `@include`. Site-wide chrome (menu, footer columns, social) comes from `site/blueprints/site.yml`, not from the page.

Every page blueprint's SEO tab is one shared file: `site/blueprints/tabs/seo.yml`, pulled in with `seo: { extends: tabs/seo }` — edit metadata fields there, never per page. It holds `metaTitle`, `metaDescription`, `ogTitle`, `ogDescription`, `ogImage`, `noIndex` and a files section. `layout/index.blade.php` resolves each tag with a fallback chain (template prop -> page field -> site SEO tab in `site.yml`) and emits canonical, robots, Open Graph and Twitter tags; the `$title`/`$description`/`$image` props on `<x-layout>` are optional overrides, not the source of truth.

Page/content pairs so far: `content/0_home/home.txt` -> `home.yml` + `home.blade.php` (the home folder is numbered so the page is *listed*, i.e. shows as published in the panel; `$site->homePage()` still resolves it by its `home` slug); `content/1_nosotros/about.txt` -> `about.yml` + `about.blade.php`; `content/2_cursos/courses.txt` -> `courses.yml` + `courses.blade.php`, whose children (`.../1_diseno-de-produccion-para-animacion/course.txt`) use `course.yml` + `course.blade.php`; `content/3_contacto/contact.txt` -> `contact.yml` + `contact.blade.php`; `content/4_privacidad/legal.txt` and `content/5_terminos/legal.txt` share `legal.yml` + `legal.blade.php` (one blueprint for every legal document: subtitle, date, intro and a `sections` structure rendered as a numbered list with a sticky index); mentor pages are children of Nosotros (`content/1_nosotros/1_ricardo-nino-mora/teacher.txt` -> `teacher.yml` + `teacher.blade.php`), created from the About page's "Fichas de mentores" tab. The nav marks the current page — and its parent, for child pages — server-side in `partials/header.blade.php` (`$isCurrent`), leaving same-page anchors to the scroll-spy.

**Focal point.** Kirby's panel focus picker is enabled for images by default (no file blueprint needed) and is applied automatically only to server-side crops — `crop()` passes `crop: true`, which falls back to the file's `focus` field (the value even lands in the thumb filename). Images that are merely resized and filled with CSS `object-cover` ignore it, so `partials/media.blade.php` translates `focus` into an inline `object-position` via `Kirby\Image\Focus::normalize()`. Any new full-bleed image must go through that partial (or emit `object-position` itself) or the focal point will be silently ignored.

**Media slots.** Every visual slot goes through `partials/media.blade.php`, called with `image`, `video`, `class`, `sizes`, `width`, `srcset`, `priority`, `placeholder`, `placeholderClass`. It renders a muted looping `<video>` when a video file is set (falling back to the image as its poster), otherwise a WebP `<img>` with srcset, otherwise the placeholder div. Never write a raw `<img src="{{ $file->url() }}">` in a template: `site/config/thumbs.php` sets `format: webp` globally, so a thumb (`thumb()`, `crop()`, `srcset()`) is WebP while the original file URL is not. Two named srcsets exist: `default` (full-bleed, 640–2400px) and `card` (400–1200px). `components/media.js` keeps videos muted/looping and pauses them under `prefers-reduced-motion`. Image fields that accept video have a `*Video` sibling field querying `page.files.filterBy("type", "video")`.

A course's instructor is likewise a `pages` field (`instructor`, single, queried from the mentor pages); the card in `sections/course-deliverables.blade.php` reads the photo, name, tagline and projects off that page and links to it. Only what is specific to *this* course stays on the course: `instructorBadge` (their role in it), `instructorLinkLabel` and `instructorProjectsLabel`.

Mentor pages under `nosotros` work the same way: each teacher page carries its own `card` type (destacado / perfil / foto), `badge` and `tagline`, and the About page's `mentorsList` `pages` field picks which ones the bento shows (falling back to all listed children). `partials/mentor-card.blade.php` takes a Page, and each card links to that mentor's own page.

Course pages under `cursos` are the single source of truth for course data. Both the `/cursos` listing and the home's Cursos section render them through the shared `partials/course-card.blade.php` partial (called with explicit `card*` variables). The home picks which ones to feature with a `pages` field (`coursesList`, max 3, queried from `site.find("cursos").children.listed`); when that field is empty the section falls back to the first three listed courses, so the home never renders an empty grid.

Inside Blade you get:
- Kirby directives compiled by `Template::setDirectives()` — `@kirbytext`/`@kt`, `@kti`, `@image`, `@svg`, `@page`, `@pages`, `@url`/`@u`, `@asset`, `@t`/`@tc`/`@tt`, `@csrf`, `@snippet`, `@vite`, `@ray`, etc. Prefer these over raw PHP.
- `@auth` / `@guest` if-statements, plus project-defined ones from `site/config/blade.php`: `@env('local')`, `@local`, `@production`, `@productionIf($cond)`, `@analytics($cond)` (production + no logged-in panel user).
- Helpers from `site/plugins/kirby-blade/helpers.php`: `base_path()`, `app_path()`, `public_path()`, `view()`, `vite()`.

**View components** are Laravel `Illuminate\View\Component` classes in `app/` under the `App\` namespace (`App\View\Components\Layout` -> `<x-layout>`), rendering Blade views under `site/templates/` (`view('layout.index')` -> `site/templates/layout/index.blade.php`). This works because the Blade plugin boots a Laravel container (`KIRBY_BLADE_BOOTSTRAP=true`) at `system.loadPlugins:after`. `app/` is the only PSR-4 autoloaded application code; PHPUnit coverage is scoped to it.

**Front-end JS is vanilla**, no framework: `resources/js/app.js` boots one small module per behaviour from `resources/js/components/` (`header` — sticky state + mobile menu, `reveal` — IntersectionObserver fade-in for `[data-reveal]`, `scrollspy`, `copy`, `forms` — submits every `[data-ajax-form]` over fetch, using `[data-form-label]` and `[data-form-feedback]` inside or beside the form). Markup hooks are `data-*` attributes; the reveal transition itself is CSS in `app.css`. Note `[data-reveal]` starts at `opacity: 0`, so anything that must be visible without JS needs the `.no-js` escape hatch already in `app.css`.

**Theming.** The site ships light and dark, defaulting to the OS setting. `resources/css/app.css` defines brand colors as fixed `@theme` tokens and every surface/text color as a semantic token pointing at an `--fl-*` variable, redefined in three places: bare `:root` (light), `@media (prefers-color-scheme: dark) :root:not([data-theme="light"])`, and `:root[data-theme="dark"]`. **Never write `text-white`, `bg-ink-*`, `border-white/10` or a hardcoded hex in a template** — use `bg-bg`, `bg-bg-soft`, `bg-surface`, `bg-surface-2`, `bg-fill`, `border-line`, `border-line-strong`, `text-fg`, `text-fg-muted`, `text-fg-subtle`, `text-fg-faint`, `text-brand-text`, `text-brand-hover`, `text-violet-text`, `shadow-shade`, and the `art-placeholder` / `art-backdrop` utilities for empty-image states. Two deliberate exceptions stay dark in both themes: the newsletter band (`sections/cta.blade.php`) and the pink `.btn-primary`. Color classes toggled from JS (`components/header.js`) must use the same tokens.

The scroll-in reveal is a CSS **animation** (`@keyframes reveal`) that moves `translate`, not a transition on `transform` — a transition there would override each element's own `transition` shorthand (the unlayered `[data-reveal]` rule beats `@layer components`) and hover states would snap instead of animating. Keep hover motion on `transform` and reveal motion on `translate`. Shared easing lives in `--ease-soft` / `--ease-gentle` (`ease-soft` is also a Tailwind utility); `.card` and `.lift` carry the standard hover elevation.

**Contrast.** Text tokens are tuned to WCAG AA and verified in both themes: `fg` / `fg-muted` / `fg-subtle` and the three brand text tokens all clear 4.5:1; `fg-faint` sits at ~3.5:1 and is reserved for decorative `aria-hidden` icons — never body text, labels or input placeholders. `.btn-primary` and the skip link use `--color-pink-deep` (#d81f65, 4.88:1 with white) rather than `--color-pink-brand` (#ec4784, only 3.62:1); the lighter pink stays the accent/graphic color. When adding a color, compose the alpha over the actual background before measuring — reading `getComputedStyle().color` alone ignores the alpha and reports a falsely high ratio.

`components/theme.js` cycles the toggle system -> light -> dark, writing `fl-theme` to localStorage (nothing stored means system) and stamping `data-theme` on `<html>`; an inline script in `layout/index.blade.php` re-applies it before first paint, so don't move it below the stylesheet. The wordmark has two files (`frame-lab-logo.svg` white, `frame-lab-logo-ink.svg` dark) swapped by the `.logo-light` / `.logo-dark` rules.

**Fonts are self-hosted**, not loaded from Google Fonts: `public/fonts/{inter,archivo}-var.woff2` (variable, latin subset — covers Spanish) with `@font-face` + `font-display: swap` declared at the top of `app.css`, and `rel="preload"` tags in the layout. The `crossorigin` attribute on those preloads is required even same-origin — fonts are always fetched in CORS mode, and without it the browser downloads each file twice. Don't reintroduce a `fonts.googleapis.com` stylesheet: it was a render-blocking third-party request. `public/.htaccess` caches fonts/CSS/JS for a year (`immutable`) and images for six months.

**Assets.** `resources/css/app.css` and `resources/js/app.js` are the Vite entrypoints, aliased `@` -> `resources/js`. `resources/css/app.css` uses Tailwind v4 CSS-first config (`@import 'tailwindcss'`, `@theme { ... }`, `@source "../../site/templates"`) — there is no `tailwind.config.js`; add scanned paths with `@source` and design tokens inside `@theme`. `site/templates/layout/index.blade.php` only emits `@vite(...)` when `public/build/manifest.json` or `public/hot` exists, so the site renders unstyled until you run `npm run dev` or `npm run build`.

**Plugins.** `site/plugins/kirby-*` are vendored copies of the `beebmx` packages installed by Composer — they are gitignored, excluded from Pint, and must not be edited. Project-owned panel/backend extensions belong in `site/plugins/app` (`index.php` for PHP extensions, `resources/index.js` + `resources/components/` for the Vue 2 panel bundle). What each one provides: `kirby-blade` (templating), `kirby-env` (the `env()` helper), `kirby-courier` (transactional email + a `courier` auth challenge), `kirby-email-plus` (swaps the `email` component for Mailgun/Resend), `kirby-enum` (field methods + fields), `kirby-scheduler` (cron-style tasks), `kirby-sign` (page methods + `key:generate`).

**Scheduling.** Tasks are declared in `site/config/tasks.php` with `Schedule::call(...)->monthly()->name('...')` and driven by `kirby schedule:run` from cron (or `schedule:work` locally).

**Tests** use Pest 4. `tests/Feature` is bound to `Tests\TestCase` (plain PHPUnit — no Kirby app is booted for you; instantiate `Kirby\Cms\App` yourself if a test needs one); `tests/Unit` is not bound. Shared expectations and helpers go in `tests/Pest.php`.

## Conventions

- PHP: 4-space indent, Laravel Pint preset. Blade files are formatted by Prettier (`prettier-plugin-blade`, 4-space, 120 cols, single quotes), JS/Vue by Prettier at 2-space, 180 cols, single quotes, no semicolons.
- Templates start with a `@php` docblock declaring `$kirby`, `$page`, `$site` for IDE/type support — keep that pattern in new templates.
- Blueprints (`site/blueprints/`) use bilingual `es`/`en` labels.
- `site/controllers/` and `site/snippets/` exist but are empty; page logic can also live in a Blade view composer or a component class.
- Front-end copy is Spanish. Two-tone headings are two fields (`...Title` in white + `...TitleAccent` with the `text-gradient` utility), never markup inside one field.
- Custom routes live in `site/config/routes.php`. Do not prefix them with `api/` — Kirby's own API owns that namespace and strips it. Both public forms post there (`POST /suscripcion`, `POST /mensaje`), check CSRF plus a `website` honeypot, and store submissions through `framelab_store_submission()` in `site/config/helpers.php`, which appends to a structure field on a page (home -> `subscribers`, contacto -> `messages`) under `impersonate('kirby')`. Entries are then editable in that page's own panel tab; nothing is written outside `content/`.
- **Section names must be unique across a whole blueprint**, not just within a tab — Kirby silently merges same-named sections (so several tabs render the same fields and the panel shows errors). Name them `<tab><Column?><Purpose>`: `heroFields`, `heroSidebarFields`, `subscribersSubscribers`. A `fields:` key nested inside a structure field is not a section; don't rename it.
- Tailwind only ships classes it finds in the sources it scanned at build time, so **after adding or renaming a template you must re-run `npm run build`** (or keep `npm run dev` running) — otherwise the new file's utilities silently do nothing and the page renders unstyled.
- **Email templates live in `site/templates/emails/` and the Blade plugin inverts Kirby's convention.** `Beebmx\KirbyBlade\Extensions\Template::__invoke()` drops Kirby's third `$defaultType` argument, so `Cms\Email`'s `template('emails/x', $type, 'text')` resolves `<name>.php` as the **HTML** body and `<name>.text.php` as the plain-text one — the opposite of stock Kirby (`x.php` text, `x.html.php` html). Name new email templates accordingly, and check both bodies render with `$kirby->email(..., ['debug' => true])`.
- Notifications go through `framelab_notify()` (`site/config/helpers.php`), which uses the `notification` email preset from `site/config/email.php` for the `from` address and **never throws** — a failed send is logged and the submission still succeeds, because the record is already stored in `content/`. Recipients and an on/off switch live in the site blueprint's Notificaciones tab.
- Structure-field values in `content/*.txt` are YAML: any value containing `: ` must be quoted, or Spyc fails with "Too many keys" and the whole page 500s.
