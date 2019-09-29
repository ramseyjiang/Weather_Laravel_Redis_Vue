
<p>If you want to install this project directly</p>
<p>Step1: git clone this project to your local</p>
<p>Step2: cd project_folder</p>
<p>Step3: composer install</p>
<p>Step4: cp .env.example .env</p>
<p>Step5: php artisan key:generate</p>
<p>Step6: npm install</p>
<p>Step7: ./vendor/bin/phpunit (It is used to check backend unittests. It will be passed if you have installed redis in your local)</p>
<p>Step8: npm run test (It is used to check frontend unittests)</p>

--------------------------------------------------------------------------------------------------------
<p>If want to learn how to do this project step by step, please follow all the under below.</p>

<p>composer create-project --prefer-dist laravel/laravel weather "5.8.*"</p>
<p>composer require barryvdh/laravel-debugbar --dev</p>
<p>composer require barryvdh/laravel-ide-helper --dev</p>     
<p>composer require xethron/migrations-generator --dev</p>
<p>composer require mpociot/laravel-test-factory-helper --dev</p>
<p>composer require skyronic/laravel-file-generator --dev</p>

<p>php artisan app:name Weather</p>
<p>php artisan make:model Models/User</p>
<p>delete User.php under Models folder, and then move app/User.php into Models folder. After that, modify User.php namespace</p>
<p>change User namespace in config/auth.php, database/factories/UserFactory.php.</p>

<p>php artisan make:test Api/WeatherTest</p>

<p>composer require guzzlehttp/guzzle</p>
<p>composer require predis/predis</p>

<p>mkdir app/Contracts</p>
<p>mkdir app/Contracts/Services</p>
<p>Create a file named WeatherServiceContract.php in Services folder</p>
<p>mkdir app/Services</p>
<p>Create a file named WeatherService.php in Services folder</p>
<p>Bind WeatherServiceContract.php and WeatherService.php in the app/Providers/AppServiceProvider.php</p>

<p>php artisan make:controller Api/WeatherController --resource</p>
<p>Update routes/api.php</p>
<p>Add an expire time for redis in config/database.php, add redis default config into .env</p>>
<p>create an app/config/weather.php</p>

<p>command "./vendor/bin/phpunit" can be passed.</p>


<p>Step0: npm install</p>

<p>Step1: npm install --save-dev @babel/cli @babel/preset-env jest @vue/test-utils vue-template-compiler vue-jest axios-mock-adapter vue-router eslint@^5.0.0 eslint-plugin-vue babel-core@^7.0.0-bridge.0 lint-staged husky eslint-config-prettier eslint-plugin-prettier prettier @vue/cli-plugin-eslint@^3.10.0 vue-tailwind</p>

<p>Step2: create a file named ".babelrc"</p>

<p>Step3: create a file named "prettier.config.js"</p>

<p>Step4: eslint --init (Follow the "eslint --init" tips and do them step by step.)</p>

<p>Step5: Update .eslintrc.js  (After Step4, it will create a file named .eslintrc.js automatically.) </p>

<p>Step6: Update webpack.mix.js</p>  

<p>Step7: Update .gitignore</p> 

<p>Step8: Update package.json, add "watchtest", "lint", "test" and "format".</p>

<p>Step9: Update routes/web.php</p>
<p>Step10: Update resources/views/welcome.blade.php</p>
<p>Step11: add "MIX_APP_URL="${APP_URL}"" into .env and update APP_URL .env to your local url</p>
<p>Step12: copy .env content to .env.example, it is used as a backup for your .env</p>

<p>Step13: create resources/js/Index.vue</p>
<p>Step14: update resources/js/app.js</p>
<p>Step15: Within resources/js/tests folder, create Index.test.js</p>

<p>command "npm run test" can be passed.</p>