# Laravel Trovit XML Feed Generator

Laravel Trovit XML Feed Generator is a package designed to help you easily create XML feeds for Trovit from your Laravel application's data.

## What is Trovit?

[Trovit](https://help.trovit.com/hc/en-gb/articles/212152605-What-exactly-is-Trovit) is a popular online classifieds search engine that allows users to search for real estate, jobs, cars, and other classified ads in various categories. It aggregates listings from thousands of websites across the globe, making it a convenient platform for users to find what they're looking for.

# Installation
1.**Install the package via Composer:**

```bash
composer require devzkhalil/laravel-trovit-xml-feed
```
2.**Publish the configuration file:**

After installing the package, publish the configuration file using the command:

```bash
php artisan vendor:publish --provider="Devzkhalil\TrovitXmlFeed\TrovitXmlFeedServiceProvider"
```
This will create a **config/trovit.php** file where you can customize the fields and field mappings for your Trovit XML feed.

3.**Configuration:**

In the **config/trovit.php** file, define the fields and field mappings. The default configuration includes mandatory fields and other optional fields as per Trovit's specifications:

```php 
return [
    /*
    |--------------------------------------------------------------------------
    | Trovit XML Feed Format Fields
    |--------------------------------------------------------------------------
    | Here is the list of fields obtained from
    | https://help.thribee.com/hc/en-us/articles/7920567396124-UK-Jobs-feed
    |
    |--------------------------------------------------------------------------
    | Mandatory Fields
    |--------------------------------------------------------------------------
    | id
    | url
    | title
    | content
    |
    | Other fields are optional.
    | You can comment out fields if you don't need them.
    |
    */
    'fields' => [
        'id',
        'title',
        'url',
        'content',
        'city',
        'city_area',
        'region',
        'postcode',
        'salary',
        'working_hours',
        'company',
        'experience',
        'requirements',
        'contract',
        'category',
        'date',
        'studies'
    ],

    'field_mapping' => [
        // Example mapping: 'model_column_name' => 'trovit_field'
        'id' => 'id',
        'post_url' => 'url',
        'title' => 'title',
        'content' => 'content',
        // Add more mappings as needed
    ]
];
```

# Basic Usage
1.**Generate XML Feed:**
To generate a Trovit XML feed, fetch the data from your model and call the **generate** method on the **TrovitXmlFeed** class. Here's an example using a **Post** model:

```php
use App\Models\Post;
use Devzkhalil\TrovitXmlFeed\TrovitXmlFeed;

public function generateTrovitFeed()
{
    $posts = Post::latest()->select(['id', 'title', 'post_url', 'content'])->take(100)->get();

    $feed = (new TrovitXmlFeed())->generate($posts, 'trovit-feed');

    if ($feed['status']) {
        return response()->json(['message' => 'Feed generated successfully'], 200);
    } else {
        return response()->json(['message' => $feed['message']], 500);
    }
}
```
This code snippet fetches the latest 100 posts from the **posts** table, generates an XML feed named **trovit-feed.xml**, and saves it to the **public** directory.

2.**Access the Generated Feed:**

The generated XML feed will be saved in the **public** directory of your Laravel application. You can access it via a URL like **http://your-domain.com/trovit-feed.xml**.

# Example Controller Method
Here's a complete example of a controller method that generates the Trovit XML feed:

```php
namespace App\Http\Controllers;

use App\Models\Post;
use Devzkhalil\TrovitXmlFeed\TrovitXmlFeed;
use Illuminate\Http\JsonResponse;

class FeedController extends Controller
{
    /**
     * Generate Trovit XML Feed.
     *
     * @return JsonResponse
     */
    public function generateTrovitFeed(): JsonResponse
    {
        $posts = Post::latest()->select(['id', 'title', 'post_url', 'content'])->take(100)->get();

        $feed = (new TrovitXmlFeed())->generate($posts, 'trovit-feed');

        if ($feed['status']) {
            return response()->json(['message' => 'Feed generated successfully'], 200);
        } else {
            return response()->json(['message' => $feed['message']], 500);
        }
    }
}
```
# Summary

With **Laravel Trovit XML Feed Generator**, you can easily create and manage XML feeds for Trovit, ensuring your listings are always up-to-date and accessible. This package handles the heavy lifting, allowing you to focus on your core application logic.
