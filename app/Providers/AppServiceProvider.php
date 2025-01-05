<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Table::$defaultNumberLocale = 'bs';

        // Registracija polisa za upravljanje dokumentima
        Gate::policy(\App\Models\Documents\Category::class, \App\Policies\Documents\CategoryPolicy::class);
        Gate::policy(\App\Models\Documents\Core::class, \App\Policies\Documents\CorePolicy::class);

        // Registracija polisa za šifarnik partnera
        Gate::policy(\App\Models\Partners\City::class, \App\Policies\Partners\CityPolicy::class);
        Gate::policy(\App\Models\Partners\Core::class, \App\Policies\Partners\CorePolicy::class);
        Gate::policy(\App\Models\Partners\Country::class, \App\Policies\Partners\CountryPolicy::class);
        Gate::policy(\App\Models\Partners\Region::class, \App\Policies\Partners\RegionPolicy::class);

        // Registracija polisa za šifarnik proizvoda
        Gate::policy(\App\Models\Products\Brand::class, \App\Policies\Products\BrandPolicy::class);
        Gate::policy(\App\Models\Products\Category::class, \App\Policies\Products\CategoryPolicy::class);
        Gate::policy(\App\Models\Products\Core::class, \App\Policies\Products\CorePolicy::class);
        Gate::policy(\App\Models\Products\Packing::class, \App\Policies\Products\PackingPolicy::class);
        Gate::policy(\App\Models\Products\Uom::class, \App\Policies\Products\UomPolicy::class);
        Gate::policy(\App\Models\Products\Variant::class, \App\Policies\Products\VariantPolicy::class);

        // Registracija polisa za nabavu
        Gate::policy(\App\Models\Purchases\Orders\Core::class, \App\Policies\Purchases\Orders\CorePolicy::class);
        Gate::policy(\App\Models\Purchases\StockEntries\Core::class, \App\Policies\Purchases\StockEntries\CorePolicy::class);

        // Registracija polisa za prodaju
        Gate::policy(\App\Models\Sales\Catalog::class, \App\Policies\Sales\CatalogPolicy::class);
    }
}
