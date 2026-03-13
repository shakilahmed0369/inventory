<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.12
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- laravel/breeze (BREEZE) - v2
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- alpinejs (ALPINEJS) - v3
- tailwindcss (TAILWINDCSS) - v3

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `pest-testing` — Tests applications using the Pest 4 PHP framework. Activates when writing tests, creating unit or feature tests, adding assertions, testing Livewire components, browser testing, debugging test failures, working with datasets or mocking; or when the user mentions test, spec, TDD, expects, assertion, coverage, or needs to verify functionality works.
- `tailwindcss-development` — Styles applications using Tailwind CSS v3 utilities. Activates when adding styles, restyling components, working with gradients, spacing, layout, flex, grid, responsive design, dark mode, colors, typography, or borders; or when the user mentions CSS, styling, classes, Tailwind, restyle, hero section, cards, buttons, or any visual/UI changes.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan

- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging

- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.

=== herd rules ===

# Laravel Herd

- The application is served by Laravel Herd and will be available at: `https?://[kebab-case-project-dir].test`. Use the `get-absolute-url` tool to generate valid URLs for the user.
- You must not run any commands to make the site available via HTTP(S). It is always available through Laravel Herd.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

## Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

## Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- CRITICAL: ALWAYS use `search-docs` tool for version-specific Laravel documentation and updated code examples.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 12 Structure

- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app\Console\Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pint/core rules ===

# Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.
- CRITICAL: ALWAYS use `search-docs` tool for version-specific Pest documentation and updated code examples.
- IMPORTANT: Activate `pest-testing` every time you're working with a Pest or testing-related task.

=== tailwindcss/core rules ===

# Tailwind CSS

- Always use existing Tailwind conventions; check project patterns before adding new ones.
- IMPORTANT: Always use `search-docs` tool for version-specific Tailwind CSS documentation and updated code examples. Never rely on training data.
- IMPORTANT: Activate `tailwindcss-development` every time you're working with a Tailwind CSS or styling-related task.
</laravel-boost-guidelines>

=== project rules ===

# Admin Panel Conventions

This application has a custom admin panel. All admin-facing views MUST follow the conventions below  check `resources/views/customers/` as the reference implementation before creating anything new.

## Layout

- Always use `<x-admin-layout>` as the page wrapper.
- Always provide `<x-slot name="heading">` and `<x-slot name="breadcrumbs">` slots.

```blade
<x-admin-layout>
    <x-slot name="heading">Page Title</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Page Title</span>
    </x-slot>

    {{-- page content --}}
</x-admin-layout>
```

## Admin Components

Always use the admin component library located at `resources/views/components/admin/`. Never roll your own buttons, inputs, labels, or cards  always prefer these:

| Component | Tag | Purpose |
|---|---|---|
| Button (primary, black) | `<x-admin.button>` | Primary form submit / CTA |
| Secondary button | `<x-admin.secondary-button>` | Cancel, back, secondary actions |
| Danger button | `<x-admin.danger-button>` | Destructive actions (delete, etc.) |
| Text input | `<x-admin.input>` | All text/email/tel/number inputs |
| Label | `<x-admin.label>` | Field labels; pass `required` prop for required fields |
| Input error | `<x-admin.input-error :messages="$errors->get('field')" />` | Validation errors below inputs |
| Card | `<x-admin.card title="..." description="...">` | Form / content card wrapper |

## Icons

- All SVG icon files live in `public/assets/icons/`. Check this folder before adding a new icon.
- When adding a new icon, place the `.svg` file in `public/assets/icons/`. The SVG paths must use `stroke="currentColor"` (or `fill="currentColor"` for solid icons) so color inheritance works.
- Always render icons as `<img>` tags with the `injectable` class. SVGInject (already wired in `public/assets/admin.js`) will replace them with inline `<svg>` elements at runtime, enabling `currentColor` to inherit the parent element's text color.
- Never use `invert`, `opacity-*` hacks, or inline `style="filter: ..."` for icon coloring. Use Tailwind `text-{color}` classes instead; they are inherited by the injected SVG via `currentColor`.
- Do NOT use `opacity-*` or CSS filters to color or dim icons  use `text-{color}` utilities.

### Icon color guide

| Context | Class to add to the `<img>` |
|---|---|
| Icon on a dark / black background (`bg-zinc-900`) | Add `text-white` to the parent OR the `<img>`  inherited automatically |
| Icon on a white/light background (muted) | `text-zinc-400` or `text-zinc-500` |
| Red / danger icons (trash, warning, error) | `text-red-600` |
| Green trend / success icons | `text-emerald-600` |
| Icon inherits parent nav link color (active/inactive) | No text class needed  just `injectable` |

### Icon `<img>` template

```blade
<img src="{{ asset('assets/icons/icon-name.svg') }}" class="size-4 injectable" alt="">
```

For explicitly colored icons:

```blade
<img src="{{ asset('assets/icons/trash.svg') }}" class="size-3.5 text-red-600 injectable" alt="">
```

## CRUD Structure

Follow the Customers module as the reference pattern for all new CRUD resources:

### Files to create

| File | Notes |
|---|---|
| `app/Models/ModelName.php` | Eloquent model via `php artisan make:model ModelName -m` |
| `database/migrations/_create_table.php` | Created alongside model |
| `database/factories/ModelNameFactory.php` | Create with `php artisan make:model --factory` |
| `app/Http/Controllers/ModelNameController.php` | Resource controller via `php artisan make:controller --resource` |
| `app/Http/Requests/StoreModelNameRequest.php` | Form request for store |
| `app/Http/Requests/UpdateModelNameRequest.php` | Form request for update |
| `resources/views/model-names/index.blade.php` | Table list view |
| `resources/views/model-names/create.blade.php` | Create form |
| `resources/views/model-names/edit.blade.php` | Edit form |

- Do NOT create a `show` view/route  this project uses index + edit only.
- Register as a resource route with `->except(['show'])`.
- Always use Form Request classes for validation  never validate inline in the controller.
- Paginate index queries; pass the paginator to the view.

### Index view conventions

- Header row: title/count on the left, "New X" primary button (with `injectable` arrow-right icon) on the right.
- Table inside a `rounded-lg border border-zinc-200 bg-white` card.
- Actions column: Edit link (`<x-admin.secondary-button>`-styled anchor) + Delete form button (`<x-admin.danger-button>`-styled).
- Empty state: centered icon (`text-zinc-300 injectable`) + message + create link.
- Delete confirmation: JS modal (see `customers/index.blade.php` for the pattern).

### Form view conventions (create & edit)

- Wrap the form in `<x-admin.card title="..." description="...">`.
- Use `<x-admin.label>`, `<x-admin.input>`, `<x-admin.input-error>` for every field.
- Footer row: `<x-admin.button type="submit">` + `<x-admin.secondary-button>` cancel link.


## Flash Notifications

- This project uses **PHP Flasher** with the **Notyf** adapter for all user-facing flash notifications.
- Always use the `notyf()` helper  never use `session()->flash()`, `->with('success', ...)`, or any Blade `@if(session(...))` flash blocks.
- Call `notyf()` before the `return redirect()` statement.

```php
// Success
notyf()->success('Customer created successfully.');
return redirect()->route('customers.index');

// Error
notyf()->error('Something went wrong.');
return redirect()->back();
```

- Use `notyf()->success()` for create, update, and delete confirmations.
- Use `notyf()->error()` for failure cases.
