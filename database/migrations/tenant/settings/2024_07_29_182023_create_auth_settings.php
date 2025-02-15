<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class() extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('auth.redirect_on_first_login', true);
        $this->migrator->add('auth.redirect_on_first_login_path', '/teste');
        $this->migrator->add('auth.force_change_password_on_first_login', true);
    }
};
