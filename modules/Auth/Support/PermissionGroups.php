<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

enum PermissionGroups: string
{
    case ACCESS_USERS = 'Acesso:Usuários';
    case ACCESS_ROLES = 'Acesso:Grupos';
    case ACCESS_AUTH = 'Acesso:Autenticação';
    case ACCESS_VERSA360 = 'Acesso:Versa 360';
    case ACCESS_LOGS = 'Acesso:Logs';

    case CONFIG_ADS = 'Configurações:Banners de Login';
    case CONFIG_THEMES = 'Configurações:Temas';

    case QUESTIONNAIRES_GROUPS = 'Questionários:Grupos de Questionários';
    case QUESTIONNAIRES = 'Questionários:Questionários';
    case QUESTIONNAIRES_RESPONSES = 'Questionários:Respostas';

    case OTHERS_MISC = 'Outros:Diversos';

    public static function fromPermission(string $permissionName): self
    {
        return match (true) {
            str_contains($permissionName, 'user') => self::ACCESS_USERS,
            str_contains($permissionName, 'versa360') => self::ACCESS_VERSA360,
            str_contains($permissionName, 'role') || str_contains($permissionName, 'permission') => self::ACCESS_ROLES,
            str_contains($permissionName, 'auth') => self::ACCESS_AUTH,
            str_contains($permissionName, 'logs') => self::ACCESS_LOGS,

            str_contains($permissionName, 'ads') => self::CONFIG_ADS,
            str_contains($permissionName, 'theme') => self::CONFIG_THEMES,

            str_contains($permissionName, 'questionnaires-group') => self::QUESTIONNAIRES_GROUPS,
            str_contains($permissionName, 'questionnaires-response') => self::QUESTIONNAIRES_RESPONSES,
            str_contains($permissionName, 'questionnaires') => self::QUESTIONNAIRES,

            default => self::OTHERS_MISC,
        };
    }

    public static function modules(): array
    {
        $modules = [];

        foreach (self::cases() as $case) {
            $module = $case->module();
            $group = $case->group();

            if (! isset($modules[$module])) {
                $modules[$module] = ['name' => $module, 'groups' => []];
            }

            $modules[$module]['groups'][] = $group;
        }

        return array_values($modules);
    }

    public function module(): string
    {
        return explode(':', $this->value)[0];
    }

    public function group(): string
    {
        return explode(':', $this->value)[1];
    }
}
