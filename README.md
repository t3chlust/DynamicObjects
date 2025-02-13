# DynamicObjects
Danil Belikov (danil.belikov@urfu.me)

# Overview

DynamicObjects Library is a library for creating and managing objects using reflection. It includes functions for object creation, serialization, deserialization, cloning and validation.

## Features

* Creating and initializing objects

```php
use shusha\ObjectFactory;

class User{

    public string $name;
    public int $age;

    public function __construct(string $name = '', int $age = 0){
        $this->name = $name;
        $this->age = $age;
    }
}

$user = ObjectFactory::dehydrate(User::class, ['name' => 'Ivan', 'age' => 30]);
var_dump($user);
```

* Serialization and deserialization of objects
```php
use shusha\Serializer;

$serialized = Serializer::serialize($user);
$deserialized = Serializer::deserialize(User::class, $serialized);

var_dump($serialized, $deserialized);
```

* Object validation
```php
use shusha\Validator;

$isValid = Validator::validate($user, ['age' => fn($age) => $age > 18]);
var_dump($isValid);
```

* Object cloning
```php
use shusha\Cloner;

$clonedUser = Cloner::clone($user);
var_dump($clonedUser);
```

## MySQL Object Mapping

```php
use shusha\ObjectFactory;
use shusha\Serializer;
use shusha\Validator;
use shusha\Cloner;
use PDO;

class User{

    public string $name;
    public int $age;

    public function __construct(string $name = '', int $age = 0){
        $this->name = $name;
        $this->age = $age;
    }
}

$pdo = new PDO($dsn, $username, $password, $options);

$stmt = $pdo->prepare('SELECT name, age FROM users WHERE id = :id');
$stmt->execute(['id' => 1]);
$userData = $stmt->fetch();

if($userData){
    $user = ObjectFactory::dehydrate(User::class, $userData);
    var_dump($user);
    var_dump($user->name);
    var_dump($user->age);
}else{
    // User not found, etc.
}
```