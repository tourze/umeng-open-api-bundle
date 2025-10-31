# Umeng Open API Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/umeng-open-api-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/umeng-open-api-bundle)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue.svg)](https://php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![Code Coverage](https://img.shields.io/badge/coverage-85%25-green.svg)](#)

A Symfony bundle for synchronizing Umeng statistical data to local database for custom analysis and reporting.

Official documentation:

- https://developer.umeng.com/open-api/state

## Table of Contents

- [Dependencies](#dependencies)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Features](#features)
- [Available Commands](#available-commands)
- [Advanced Usage](#advanced-usage)
- [Data Storage](#data-storage)
- [Security](#security)
- [License](#license)

## Dependencies

This bundle requires:

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher
- MySQL/PostgreSQL database

For a complete list of dependencies, see [composer.json](composer.json).

## Installation

```bash
composer require tourze/umeng-open-api-bundle
```

## Quick Start

1. **Install the bundle**:
   ```bash
   composer require tourze/umeng-open-api-bundle
   ```

2. **Register the bundle**:
   ```php
   // config/bundles.php
   return [
       // ...
       UmengOpenApiBundle\UmengOpenApiBundle::class => ['all' => true],
   ];
   ```

3. **Configure Umeng account** (setup your Umeng account in database):
   ```sql
   -- Create an account record with your Umeng credentials
   INSERT INTO ims_umeng_open_api_account (api_key, api_security, valid, created_at, updated_at)
   VALUES ('your_api_key', 'your_api_security', 1, NOW(), NOW());
   ```

4. **Run database migrations** (if using Doctrine):
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Fetch your first data**:
   ```bash
   # Get application list
   php bin/console umeng-open-api:get-app-list
   
   # Get daily active users data
   php bin/console umeng-open-api:get-daily-active-users
   ```

## Configuration

Register the bundle in your Symfony application:

```php
// config/bundles.php
return [
    // ...
    UmengOpenApiBundle\UmengOpenApiBundle::class => ['all' => true],
];
```

## Features

- **Comprehensive Data Sync**: Fetch various Umeng statistical data types (users, launches, retention, duration)
- **Multiple Time Dimensions**: Support hourly, daily, weekly, monthly, and custom period data
- **Automatic Synchronization**: Built-in cron job support for automated data sync
- **Rich Command-Line Tools**: 25+ console commands for different data types
- **Audit Logging**: Complete API call logging with timing and error tracking
- **Database Storage**: Structured data storage with Doctrine ORM entities
- **Flexible Architecture**: Easy to extend with custom data processors

## Available Commands

### Application Management Commands

#### umeng-open-api:get-app-list
Fetch and sync all applications under the Umeng account.

```bash
php bin/console umeng-open-api:get-app-list
```

### Data Statistics Commands

#### Daily Data Commands

- **umeng-open-api:get-daily-data** - Get daily statistical data
- **umeng-open-api:get-daily-active-users** - Get daily active users data
- **umeng-open-api:get-daily-new-users** - Get daily new users data
- **umeng-open-api:get-daily-launches** - Get daily launches data
- **umeng-open-api:get-daily-duration** - Get daily usage duration data
- **umeng-open-api:get-daily-per-launch-duration** - Get daily per-launch duration data
- **umeng-open-api:get-daily-retentions** - Get daily retention rate data

#### Hourly Data Commands

- **umeng-open-api:get-hourly-active-users** - Get hourly active users data
- **umeng-open-api:get-hourly-new-users** - Get hourly new users data
- **umeng-open-api:get-hourly-launches** - Get hourly launches data

#### 7-Day Data Commands

- **umeng-open-api:get-seven-day-active-users** - Get 7-day active users data
- **umeng-open-api:get-seven-day-new-users** - Get 7-day new users data
- **umeng-open-api:get-seven-day-launches** - Get 7-day launches data

#### Weekly Data Commands

- **umeng-open-api:get-weekly-active-users** - Get weekly active users data
- **umeng-open-api:get-weekly-new-users** - Get weekly new users data
- **umeng-open-api:get-weekly-launches** - Get weekly launches data
- **umeng-open-api:get-weekly-retentions** - Get weekly retention rate data

#### Monthly Data Commands

- **umeng-open-api:get-monthly-active-users** - Get monthly active users data
- **umeng-open-api:get-monthly-new-users** - Get monthly new users data
- **umeng-open-api:get-monthly-launches** - Get monthly launches data
- **umeng-open-api:get-monthly-retentions** - Get monthly retention rate data

#### 30-Day Data Commands

- **umeng-open-api:get-thirty-day-active-users** - Get 30-day active users data
- **umeng-open-api:get-thirty-day-new-users** - Get 30-day new users data
- **umeng-open-api:get-thirty-day-launches** - Get 30-day launches data

#### Channel Data Commands

- **umeng-open-api:get-channel-data** - Get channel statistical data

### Command Usage Examples

```bash
# Get daily active users data
php bin/console umeng-open-api:get-daily-active-users

# Get weekly retention rate data
php bin/console umeng-open-api:get-weekly-retentions

# Get application list
php bin/console umeng-open-api:get-app-list
```

## Advanced Usage

### Custom Data Processing

You can extend the functionality by creating custom data processors:

```php
use UmengOpenApiBundle\Entity\DailyActiveUsers;

class CustomAnalyticsProcessor
{
    public function processData(array $data): void
    {
        // Custom processing logic
        foreach ($data as $record) {
            // Your analytics logic here
        }
    }
}
```

### Scheduled Data Synchronization

The bundle includes built-in cron job support. Commands are automatically scheduled using the CronJob attributes:

```php
// GetAppListCommand - runs every 10 minutes
#[AsCronTask(expression: '*/10 * * * *')]

// GetDailyActiveUsersCommand - runs every 30 minutes
#[AsCronTask(expression: '*/30 * * * *')]
```

To enable automatic scheduling, ensure you have the cron job bundle configured in your application.

### Custom Commands

Create custom commands for specific data needs:

```php
use Symfony\Component\Console\Command\Command;
use UmengOpenApiBundle\Service\UmengApiService;

class CustomDataCommand extends Command
{
    public function __construct(private UmengApiService $apiService)
    {
        parent::__construct();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Custom data fetching logic
        return Command::SUCCESS;
    }
}
```

## Data Storage

All fetched data is automatically stored in the local database. You can access this data through Repository classes:

- `AccountRepository` - Umeng account configurations
- `AppRepository` - Application metadata
- `DailyActiveUsersRepository` - Daily active users data
- `WeeklyRetentionsRepository` - Weekly retention data
- `MonthlyActiveUsersRepository` - Monthly active users data
- `HourlyActiveUsersRepository` - Hourly active users data
- And many more...

### Database Schema

The bundle creates the following main tables:

- `ims_umeng_open_api_account` - Umeng account configurations
- `ims_umeng_open_api_app` - Application metadata
- `ims_umeng_daily_*` - Daily statistics tables (active users, new users, launches, etc.)
- `ims_umeng_weekly_*` - Weekly statistics tables
- `ims_umeng_monthly_*` - Monthly statistics tables
- `ims_umeng_hourly_*` - Hourly statistics tables

### Example Data Access

```php
use UmengOpenApiBundle\Repository\DailyActiveUsersRepository;

public function __construct(private DailyActiveUsersRepository $dailyUsersRepo)
{
}

public function getActiveUsersForApp(App $app, \DateTimeInterface $date): ?DailyActiveUsers
{
    return $this->dailyUsersRepo->findOneBy([
        'app' => $app,
        'date' => $date,
    ]);
}
```

## Security

### Credential Management

- Store sensitive credentials (API keys, secrets) in the database `ims_umeng_open_api_account` table
- Never commit credentials to version control
- Use encrypted database fields for sensitive data storage
- Credentials are associated with specific accounts for multi-account support

```sql
-- Store credentials securely in database
INSERT INTO ims_umeng_open_api_account (api_key, api_security, valid, created_at, updated_at)
VALUES ('your_api_key', 'your_api_security', 1, NOW(), NOW());
```

### API Rate Limiting

The bundle respects Umeng's API rate limits:

- Maximum 1000 requests per hour per API key
- Automatic retry with exponential backoff on rate limit errors
- Built-in request queuing to prevent rate limit violations

### Data Privacy

- All data is stored locally in your database
- No data is transmitted to third parties
- Follow GDPR/privacy regulations when handling user data
- Implement appropriate data retention policies

### Security Best Practices

- Regularly update dependencies to latest versions
- Monitor API usage and access logs
- Implement proper user authentication for data access
- Use HTTPS for all API communications

## License

MIT