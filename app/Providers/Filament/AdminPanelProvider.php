<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\App;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\MenuItem;
use Illuminate\Support\Facades\Session;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('')
            ->path('')
            ->login(\App\Filament\Auth\Login::class)
            ->font('CourierPrime')
            ->globalSearch(true)
            ->breadcrumbs(false)
            ->brandLogo(asset('storage/images/logo.png'))
            ->favicon(asset('storage/images/favicon.ico'))
            ->colors([
                'primary' => Color::Green,
            ])
            ->navigationGroups([
     
                NavigationGroup::make()
                ->label('Prodaja'),

                NavigationGroup::make()
                ->label('Nabava'),

                NavigationGroup::make()
                    ->label('Šifarnici'),
                
                NavigationGroup::make()
                    ->label('Evidencije'),

                NavigationGroup::make()
                    ->label('Postavke'),
            ])
            ->userMenuItems([

                MenuItem::make()
                    ->label(fn () => 'Aktivna godina: ' . (Session::get('selected_year') ?? 'N/A'))
                    ->icon('heroicon-s-calendar') 
            ])
            ->sidebarCollapsibleOnDesktop()
            ->topNavigation()
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([

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
            ]);
    }
}
