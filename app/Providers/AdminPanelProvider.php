<?php

namespace App\Providers;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Auth\Login;
use Filament\Pages\Auth\Register;
use Awcodes\Curator\CuratorPlugin;
use Filament\Support\Colors\Color;
use Shanerbaner82\PanelRoles\PanelRoles;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Awcodes\FilamentGravatar\GravatarPlugin;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use Awcodes\FilamentGravatar\GravatarProvider;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->passwordReset()
            ->emailVerification()
            // ->registration(Register::class) 
            ->profile()
            ->spa()
            ->databaseNotifications()
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        hasAvatars: false
                    )
                    ->enableTwoFactorAuthentication(),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media Library')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Media')
                    ->navigationCountBadge(),
                // FilamentExceptionsPlugin::make(),
                // FilamentJobsMonitorPlugin::make()
                //     ->navigationCountBadge()
                //     ->navigationGroup('Settings'),
                FilamentPeekPlugin::make()
                    ->disablePluginStyles(),
                GravatarPlugin::make(),
                FilamentSpatieRolesPermissionsPlugin::make(),
                // PanelRoles::make()
                //     // ->roleToAssign('developer')
                //     ->restrictedRoles(['admin', 'developer'])


            ])
            ->defaultAvatarProvider(GravatarProvider::class)
            ->favicon(asset('/favicon-32x32.png'))
            ->brandLogo(fn () => view('components.logo'))
            ->navigationGroups([
                'Collections',
                'Media',
                'Settings',
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/admin.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop();
            // ->plugin(PanelRoles::make()
            //     ->roleToAssign('developer')
            //     ->restrictedRoles(['admin', 'developer']),
            // );
    }
}
