# phpClassEditor

![build](https://travis-ci.org/elkaadka/phpClassEditor.svg?branch=master)


This library allows you to dynamically edit php class files by injecting code into them

# How it works

Important : unless you call the save method, the file won't be changed
Each function that edits the php class file return the new content of the file (after adding properties/methods)


## 1 Indentation

Before you create any property or method, you need to define what indentation to use.

<b>Default one is 4 spaces.</b>

If you want to change the default behaviour : 

```php
$classEditor = new ClassEditor('path_to_php_class_file');
$classEditor->useIndentation(Indentation::TABS, 1);
```

The example above means you want the default indentation to be 1 tab.

You can only use :

```
Indentation::TABS;
Indentation::SPACES;
```
	

## 2 Adding properties to a class

You can inject properties into a php class file.


```php
$classEditor = new ClassEditor('path_to_php_class_file');
$classEditor->addProperty(new Property('property1', Visibility::PROTECTED));
$classEditor->addProperty(new Property('property2', Visibility::PUBLIC));
$classEditor->addProperty(new Property('property3', Visibility::PRIVATE));

$classEditor->save();
```
The example above adds three properties to the class 


```php
class MyClass {
    
    protected $property1;
    public $property2;
    private $property3;
    ...

}
```

## 2.1 Property class

the "addProperty" method takes in a Property class.

A Property class must have at least a name (mandatory), defined in the construct

```php
$property = new Property('myProperty');
```

This will print in the class :

```php
class MyClass {
    
    $myProperty;
    ...

}
```

You can also set a "visibility" to your property in the construct (optional)

```php
$property = new Property('myProperty', Visibility::PROTECTED);
```

All the visibilities are defined in the Visibility class :

```
Visibility::PROTECTED
Visibility::PUBLIC
Visibility::PRIVATE
Visibility::NONE      //For when you don't want to write the visibility in the php class file
```

You can also define the property's default value (optional too)

```php
$property = new Property('myProperty', Visibility::PROTECTED, Value::NULL);
```

will print

```php
class MyClass {
    
    protected $myProperty = null;
    ...

}
```

You can write whatever value you want (as string), or use the ones predefined in the Value class:

```
Value::NULL;
Value::TRUE;
Value::FALSE;
Value::EMPTY_ARRAY;
Value::NO_DEFAULT_VALUE;  //The default behaviour of properties, when you property does not have a default value
```

Finally, the last construct parameter allows to choose if the property is static (true) or not (false):

```php
$property = new Property('myProperty', Visibility::PROTECTED, Value::NULL, true);
```

will print

```php
class MyClass {
    
    protected static $myProperty = null;
    ...

}
```

All the parameters in the constuct (except the name) have designated setters, you can use:

```php
$property = new Property('myProperty');
$property->setVisibility(Visibility::PUBLIC);
$property->setDefaultValue('1');
$property->setIsStatic(true);
```

will print :

```php
class MyClass {
    
    public static $myProperty = 1;
    ...

}
```

## 3 Adding methods to a class

You can inject methods into a php class file.


```php
$class = new ClassEditor($this->phpFileName);
$class->addMethod(new Method('bar', Visibility::PROTECTED));
$class->addMethod(new Method('foo', Visibility::PROTECTED));
$classEditor->save();
```
The example above adds two methods to the class 


```php
class MyClass {
    
    ....
    
    protected function bar()
    {
    
    }
    
    protected function foo()
    {
    
    }

}
```

The name and the visibility are both mandatory in the construct

All the visibilities are defined in the Visibility class :

```
Visibility::PROTECTED
Visibility::PUBLIC
Visibility::PRIVATE
Visibility::NONE      //For when you don't want to write the visibility in the php class file
```

You can define multiple things using the Method class : is it static? abstract? final ? does it have a return type? a doc comment? parameters ?

```php
$method = new Method('bar', Visibility::PUBLIC);
$method->setIsStatic(true);
$method->setIsFinal(true);
$method->setIsAbstract(true);
$method->setReturnType(Type::INT);
$method->setDocComment('This is my bar function');
```

Since a method can not be both final and abtract, it is the last one set to true that is taken.

so this will print:

```php
class MyClass {
    
    ....
    
    /**
     * This is my bar function
     * @return int
     */
    abstract public static function bar(): int
    {
    
    }

}
```

Note the the return type can be anything you send, you can also use the consts defined in Type class

```
Type::ARRAY
Type::MIXED
Type::BOOL
Type::CALLABLE
Type::FLOAT
Type::INT
Type::STDCLASS
Type::STRING
Type::NONE
```


You can also add parameters to your method.
The Method class has an "addParameter" function that allows to you add as many parameters as needed.
These are all the possible parameters classes you can use :

```
ArrayParameter
BoolParameter
CallableParameter
FloatParameter
IntParameter
MixedParameter   //When your parameter does not have a single type or none at all
StdClassParameter
StringParameter
ClassParameter
```
Each one of these parameters classes takes in a mandatory name in their construct

They also take in a default value as second parameter (except for ClassParameter, see below) when there is one 

You can use the predefined ones or add yours
```
Value::NULL;
Value::TRUE;
Value::FALSE;
Value::EMPTY_ARRAY;
Value::NO_DEFAULT_VALUE;  //The default behaviour of properties, when you property does not have a default value
```

The last parameter is a boolean that tells if the parameter is a splat or not
A splat is the ... annotation that allows to send multiple parameters


Please note also that each parameter 

The ClassParameter has a slightly different construct as it takes as a second parameter the full class name

```php
$method = new Method('bar', Visibility::PUBLIC);
$method->setDocComment('This is my bar function');
$method->setReturnType(Type::ARRAY);
$method->addParameter(new MixedParameter('param1'));
$method->addParameter(new IntParameter('param2', 1));
$method->addParameter(new ClassParameter('param3', MyClass::class, Value::NULL));
```

This will print :

```php
class MyClass {
    
    ....
    
    /**
     * This is my bar function
     * @param mixed $param1
     * @param int $param2
     * @param My\NAMESPACE\MyClass $param3
     * @return array
     */
    public function bar($param1, int $param2 = 1, My\NAMESPACE\MyClass $param3 = null): array
    {
    
    }

}
```

You must have noted that params and return type will always generate a docComment


