# Larvel 5.4 default json field

## 原理
1. 数据库里有json字段
2. 创建记录、查询记录的时候，若json字段里面为空，则自动补上对应的信息

## 安装
1. 通过composer安装
~~2. 注册服务~~

## 使用
```php
<?php

namespace App\Form;

use Goodwong\LaravelDefaultJsonField\Traits\DefaultJsonField;

class Form
{
    use SoftDeletes;
    use DefaultJsonField;
}
```