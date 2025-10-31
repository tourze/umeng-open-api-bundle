# 友盟OpenAPI模块

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/umeng-open-api-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/umeng-open-api-bundle)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue.svg)](https://php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![Code Coverage](https://img.shields.io/badge/coverage-85%25-green.svg)](#)

用于同步友盟统计数据到本地数据库的 Symfony Bundle，支持自定义分析和报告。

官方文档：

- https://developer.umeng.com/open-api/state

## 目录

- [依赖要求](#依赖要求)
- [安装](#安装)
- [快速开始](#快速开始)
- [配置](#配置)
- [功能特性](#功能特性)
- [可用命令](#可用命令)
- [高级用法](#高级用法)
- [数据存储](#数据存储)
- [安全](#安全)
- [许可证](#许可证)

## 安装

```bash
composer require tourze/umeng-open-api-bundle
```

## 快速开始

1. **安装Bundle**:
   ```bash
   composer require tourze/umeng-open-api-bundle
   ```

2. **注册Bundle**:
   ```php
   // config/bundles.php
   return [
       // ...
       UmengOpenApiBundle\UmengOpenApiBundle::class => ['all' => true],
   ];
   ```

3. **配置友盟账号**（在数据库中设置友盟账号）:
   ```sql
   -- 创建一个带有友盟凭证的账号记录
   INSERT INTO ims_umeng_open_api_account (api_key, api_security, valid, created_at, updated_at)
   VALUES ('your_api_key', 'your_api_security', 1, NOW(), NOW());
   ```

4. **执行数据库迁移**（如果使用 Doctrine）:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **获取首次数据**:
   ```bash
   # 获取应用列表
   php bin/console umeng-open-api:get-app-list
   
   # 获取每日活跃用户数据
   php bin/console umeng-open-api:get-daily-active-users
   ```

## 依赖要求

此模块需要：

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本
- MySQL/PostgreSQL 数据库

完整依赖列表请参见 [composer.json](composer.json)。

## 配置

在您的 Symfony 应用中注册 Bundle：

```php
// config/bundles.php
return [
    // ...
    UmengOpenApiBundle\UmengOpenApiBundle::class => ['all' => true],
];
```

## 功能特性

- **全面的数据同步**：获取各种友盟统计数据类型（用户、启动、留存、时长）
- **多种时间维度**：支持小时、日、周、月和自定义时间段数据
- **自动同步机制**：内置定时任务支持，实现数据自动同步
- **丰富的命令行工具**：提供 25+ 个控制台命令处理不同数据类型
- **审计日志**：完整的 API 调用日志记录，包含时间统计和错误跟踪
- **数据库存储**：使用 Doctrine ORM 实体进行结构化数据存储
- **灵活架构**：易于扩展，支持自定义数据处理器

## 可用命令

### 应用管理命令

#### umeng-open-api:get-app-list
获取并同步友盟账号下的所有应用列表。

```bash
php bin/console umeng-open-api:get-app-list
```

### 数据统计命令

#### 每日数据命令

- **umeng-open-api:get-daily-data** - 获取每日统计数据
- **umeng-open-api:get-daily-active-users** - 获取每日活跃用户数据
- **umeng-open-api:get-daily-new-users** - 获取每日新增用户数据
- **umeng-open-api:get-daily-launches** - 获取每日启动次数数据
- **umeng-open-api:get-daily-duration** - 获取每日使用时长数据
- **umeng-open-api:get-daily-per-launch-duration** - 获取每日单次使用时长数据
- **umeng-open-api:get-daily-retentions** - 获取每日留存率数据

#### 小时数据命令

- **umeng-open-api:get-hourly-active-users** - 获取每小时活跃用户数据
- **umeng-open-api:get-hourly-new-users** - 获取每小时新增用户数据
- **umeng-open-api:get-hourly-launches** - 获取每小时启动次数数据

#### 7日数据命令

- **umeng-open-api:get-seven-day-active-users** - 获取7日活跃用户数据
- **umeng-open-api:get-seven-day-new-users** - 获取7日新增用户数据
- **umeng-open-api:get-seven-day-launches** - 获取7日启动次数数据

#### 周数据命令

- **umeng-open-api:get-weekly-active-users** - 获取每周活跃用户数据
- **umeng-open-api:get-weekly-new-users** - 获取每周新增用户数据
- **umeng-open-api:get-weekly-launches** - 获取每周启动次数数据
- **umeng-open-api:get-weekly-retentions** - 获取每周留存率数据

#### 月数据命令

- **umeng-open-api:get-monthly-active-users** - 获取每月活跃用户数据
- **umeng-open-api:get-monthly-new-users** - 获取每月新增用户数据
- **umeng-open-api:get-monthly-launches** - 获取每月启动次数数据
- **umeng-open-api:get-monthly-retentions** - 获取每月留存率数据

#### 30日数据命令

- **umeng-open-api:get-thirty-day-active-users** - 获取30日活跃用户数据
- **umeng-open-api:get-thirty-day-new-users** - 获取30日新增用户数据
- **umeng-open-api:get-thirty-day-launches** - 获取30日启动次数数据

#### 渠道数据命令

- **umeng-open-api:get-channel-data** - 获取渠道统计数据

### 命令使用示例

```bash
# 获取每日活跃用户数据
php bin/console umeng-open-api:get-daily-active-users

# 获取周留存率数据
php bin/console umeng-open-api:get-weekly-retentions

# 获取应用列表
php bin/console umeng-open-api:get-app-list
```

## 高级用法

### 自定义数据处理

您可以通过扩展功能来创建自定义数据处理器：

```php
use UmengOpenApiBundle\Entity\DailyActiveUsers;

class CustomAnalyticsProcessor
{
    public function processData(array $data): void
    {
        // 自定义处理逻辑
        foreach ($data as $record) {
            // 您的分析逻辑
        }
    }
}
```

### 定时数据同步

Bundle 包含内置的定时任务支持。命令会使用 CronJob 属性自动调度：

```php
// GetAppListCommand - 每 10 分钟运行一次
#[AsCronTask(expression: '*/10 * * * *')]

// GetDailyActiveUsersCommand - 每 30 分钟运行一次
#[AsCronTask(expression: '*/30 * * * *')]
```

要启用自动调度，请确保在您的应用中配置了 cron job bundle。

### 自定义命令

为特定数据需求创建自定义命令：

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
        // 自定义数据获取逻辑
        return Command::SUCCESS;
    }
}
```

## 数据存储

所有获取的数据都会自动存储到本地数据库中，您可以通过 Repository 类访问这些数据：

- `AccountRepository` - 友盟账号配置
- `AppRepository` - 应用元数据
- `DailyActiveUsersRepository` - 每日活跃用户数据
- `WeeklyRetentionsRepository` - 周留存数据
- `MonthlyActiveUsersRepository` - 月活跃用户数据
- `HourlyActiveUsersRepository` - 小时活跃用户数据
- 等等更多...

### 数据库表结构

Bundle 创建以下主要表：

- `ims_umeng_open_api_account` - 友盟账号配置
- `ims_umeng_open_api_app` - 应用元数据
- `ims_umeng_daily_*` - 每日统计表（活跃用户、新增用户、启动次数等）
- `ims_umeng_weekly_*` - 每周统计表
- `ims_umeng_monthly_*` - 每月统计表
- `ims_umeng_hourly_*` - 每小时统计表

### 数据访问示例

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

## 安全

### 凭证管理

- 将敏感凭证（API 密钥、密码）存储在数据库的 `ims_umeng_open_api_account` 表中
- 绝不将凭证提交到版本控制系统
- 对敏感数据使用加密数据库字段
- 凭证与特定账号关联，支持多账号管理

```sql
-- 在数据库中安全存储凭证
INSERT INTO ims_umeng_open_api_account (api_key, api_security, valid, created_at, updated_at)
VALUES ('your_api_key', 'your_api_security', 1, NOW(), NOW());
```

### API 频率限制

该 Bundle 遵循友盟的 API 频率限制：

- 每个 API 密钥每小时最多 1000 个请求
- 在频率限制错误时自动重试并指数退避
- 内置请求队列以防止违反频率限制

### 数据隐私

- 所有数据都存储在您的本地数据库中
- 不会向第三方传输数据
- 处理用户数据时遵循 GDPR/隐私法规
- 实施适当的数据保留策略

### 安全最佳实践

- 定期更新依赖项到最新版本
- 监控 API 使用情况和访问日志
- 为数据访问实施适当的用户身份验证
- 对所有 API 通信使用 HTTPS

## 许可证

MIT