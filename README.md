# Slugable

This package will automatic figure out what the slug is going to be based on the `title` by default  
or specified with the `slugableColumn` variable value that you can specify on your model.

> Note: This package will try to never use a old slug, because of SEO friendliness and old links that will link to wrong results.

## Usage

Add `use Slugable` to your model, like the example below:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intothesource\Slugable\Slugable;

class Page extends Model
{
    use Slugable;
    
    ...
```

This trait contains a `setSlugAttribute` method with you only need to trigger from the controller or with a eventListener.  
But thats all up to you.

## Example

```php
'This is a title' => 'this-is-a-title'
```

And if you submit the same title agean it will return:

```php
'This is a title' => 'this-is-a-title-2'
```

If a title ends with a number it will just add the suffix to the existing slug.
Example:

```php
'This is my post number 20' => 'this-is-my-post-number-20'
```

Second time:

```php
'This is my post number 20' => 'this-is-my-post-number-20-2'
```

## Credits

- [Gertjan Roke](http://composer.intothesource.com/#intothesource/laravel-slugable)
- [All contributors](http://composer.intothesource.com/#intothesource/laravel-slugable)
