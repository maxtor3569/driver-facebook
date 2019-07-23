<?php

namespace BotMan\Drivers\Facebook\Providers;


class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->isRunningInBotManStudio()) {
            $this->loadDrivers();

            $this->publishes([
                __DIR__.'/../../stubs/facebook.php' => config_path('botman/facebook.php'),
            ]);

            $this->mergeConfigFrom(__DIR__.'/../../stubs/facebook.php', 'botman.facebook');

            if ($this->app->runningInConsole()) {
                $this->commands([
                    Nlp::class,
                    AddGreetingText::class,
                    AddPersistentMenu::class,
                    AddStartButtonPayload::class,
                    WhitelistDomains::class,
                ]);
            }
        }
    }

    /**
     * Load BotMan drivers.
     */
    protected function loadDrivers()
    {
        DriverManager::loadDriver(FacebookDriver::class);
        DriverManager::loadDriver(FacebookAudioDriver::class);
        DriverManager::loadDriver(FacebookFileDriver::class);
        DriverManager::loadDriver(FacebookImageDriver::class);
        DriverManager::loadDriver(FacebookLocationDriver::class);
        DriverManager::loadDriver(FacebookVideoDriver::class);
    }

    /**
     * @return bool
     */
    protected function isRunningInBotManStudio()
    {
        return class_exists(StudioServiceProvider::class);
    }
}
