# Build a Product Review REST API with Laravel

https://dev.to/mr_steelze/build-a-product-review-rest-api-with-laravel-2ih8



```php
# app/Http/Controllers/AuthController.php
$token = auth()->login($user);
$token = auth()->attempt($credentials);
```
auth()->login() 과 auth()->attempt() 의 리턴값은 원래 boolean 인데 guard 를 api 로 
변경시 token 값으로 반환 (확실히 이해한 건 아님)


```php

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(1000, 20000),
        'user_id' => function() {
            return User::all()->random(); # random
        },
    ];
});

$product->load([
    'reviews' => function ($query) {
        $query->latest();
    },
    'user:id,name' // only id, name
]);

protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type'   => 'bearer',
        'expires_in'   => auth()->factory()->getTTL() * 60
    ]);
}

```
