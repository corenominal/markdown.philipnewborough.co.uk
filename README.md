# markdown.philipnewborough.co.uk

A Markdown-to-HTML converter web application built with [CodeIgniter 4](https://codeigniter.com/) and [league/commonmark](https://commonmark.thephpleague.com/) (GitHub Flavored Markdown).

## Features

- **Interactive editor** — paste or type Markdown and switch between Markdown, HTML, and rendered Preview tabs in real time.
- **GitHub Flavored Markdown** — conversion powered by `league/commonmark` GFM.
- **Keyboard shortcuts** — `Tab` / `Shift+Tab` to indent/outdent, `Ctrl/⌘+B` bold, `Ctrl/⌘+I` italic, backtick wrapping and fenced-code-block insertion.
- **Download** — save the current Markdown as a `.md` file directly from the browser.
- **REST API** — a JSON API endpoint for programmatic conversion, protected by API key authentication.
- **Session authentication** — optional per-route auth via an external authentication server.

## Requirements

- PHP 8.2+
- Composer
- Node.js / npm (for front-end assets)

## Getting Started

```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy the environment file and configure it
cp env .env
```

Edit `.env` and set at minimum:

```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
```

Start the development server:

```bash
php spark serve
```

The application will be available at `http://localhost:8080`.

## Configuration

| File | Purpose |
|---|---|
| `app/Config/App.php` | Base URL, session settings |
| `app/Config/ApiKeys.php` | Master API key (`masterKey`) |
| `app/Config/Urls.php` | External auth server URL |
| `app/Config/Filters.php` | Route-level auth / API filter assignments |

All sensitive values (`masterKey`, auth URLs, etc.) should be set in `.env` rather than committed to source control.

## API

### `POST /api/converter`

Converts Markdown to HTML. Requires an `apikey` header.

**Request**

```json
{ "markdown": "# Hello" }
```

**Response**

```json
{ "markdown": "# Hello", "html": "<h1>Hello</h1>\n" }
```

**Error responses** return a `4xx` status with `{ "error": "..." }`.

### `GET /api/test/ping`

Health-check endpoint. Returns a simple `pong` response.

## Web Endpoint

### `POST /convert`

Used by the front-end editor. Accepts `{ "markdown": "..." }` and returns `{ "html": "..." }`. Input is limited to 1 MB.

## Running Tests

```bash
composer test
# or
vendor/bin/phpunit
```

## License

MIT — see [LICENSE](LICENSE).

