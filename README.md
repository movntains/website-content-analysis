# Website Content Analyzer

This is a Laravel-based web application for analyzing website content. It scans a given URL and provides insights into various aspects of the content, including scores and analyses for clarity, consistency, SEO, and tone. It also provides suggested headlines, CTAs, and content hierarchy.

## Project Status

|                                                                                   Build                                                                                   |                                                               Tests                                                                |                                                            Coverage                                                             |
| :-----------------------------------------------------------------------------------------------------------------------------------------------------------------------: | :--------------------------------------------------------------------------------------------------------------------------------: | :-----------------------------------------------------------------------------------------------------------------------------: |
| ![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/movntains/website-content-analysis/tests.yml?style=for-the-badge&logo=github) | ![GitHub Branch Check Runs](https://img.shields.io/github/check-runs/movntains/website-content-analysis/develop?style=for-the-badge&logo=github) | ![Code Coverage](https://img.shields.io/codecov/c/github/movntains/website-content-analysis?style=for-the-badge&logo=codecov&logoColor=white) |

## Tech Stack

- Laravel
- Inertia.js
- PostgreSQL
- React
- Tailwind CSS
- Google Gemini
- Prism PHP
- PHPStan
- Pest
- Rector
- Pint
- Prettier
- ESLint
- DDEV for local development
- GitHub Actions

## Local Development

This project is configured to use [DDEV](https://ddev.readthedocs.io/en/latest/). Once you have that installed (along with the necessary Docker installation, as detailed in the DDEV documentation), you can continue with local setup.

### Configuring Your Environment Variables

Create a `.env` file and copy over the contents of the `.env.example` file.

### Starting the Project Docker Container

In the terminal, from within the project directory, run `ddev start`. This will spin up the project and configure your database environment variables for you.

### Installing Dependencies

Run the following commands in the terminal:

```shell
# Install Composer dependencies
$ ddev composer install

# Install NPM dependencies and build assets
$ ddev npm install
$ ddev npm run build
```

### Generating an App Key

Create an `APP_KEY` value by running `ddev artisan key:generate`.

### Setting Up Your Databases

Run the following commands in the terminal to set up your local database:

```shell
# Run migrations
$ ddev artisan migrate

# Seed your local database
$ ddev artisan db:seed
```

You'll also need to add a testing database for running tests. The necessary environment variables and their values are included in the `.example.env` file.

These instructions will assume that you use [TablePlus](https://tableplus.com/) as your database GUI. It can be downloaded and used for free.

To create your testing database, run `ddev tableplus`. This will open the container's database (your local database) in TablePlus. Press `⌘K` to open the connection's list of databases, click `New...`, enter the name of the database (the value for the `DB_TESTING_DATABASE` environment variable), and click `OK`. You can then close TablePlus.

### Running Tests

#### With Coverage

To run the entire test suite with coverage, execute the following command in the terminal:

```shell
$ make test_with_coverage
```

This command will enable Xdebug in DDEV, run the tests, and then disable Xdebug again.

#### Without Coverage

To run the entire test suite without coverage, execute the following command in the terminal:

```shell
$ ddev artisan test
```

### Checking Code Quality and Formatting

There are multiple Composer commands for checking code quality and formatting.

#### Formatting and Linting

To check code formatting and linting with Rector, Pint, Prettier, and ESLint, run:

```shell
$ ddev composer lint:check
```

To automatically fix code formatting issues with Rector, Pint, Prettier, and ESLint, run:

```shell
$ ddev composer lint
```

#### Static Analysis

To check PHP types with PHPStan, run:

```shell
$ ddev composer types:check
```

To check PHP type coverage with Pest, run:

```shell
$ ddev composer type-coverage:check
```

#### All-in-One Test Command

To check code formatting and perform static analysis all in one go, run:

```shell
$ ddev composer test
```

## Google Gemini Setup

To use the Google Gemini API for content analysis, you need to set up a Google Cloud project and create an API key.

1. Go to the [Google AI Studio API keys page](https://aistudio.google.com/app/apikey) (log in if necessary).
2. Click on `Create API Key`.
3. Provide a name for the API key and select a project (create a new project if needed).
4. Click `Create key` to generate the API key.
5. Copy the generated API key.
6. Set the API key as the value for the `GEMINI_API_KEY` environment variable in your `.env` file.
