<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\System\ModelList;
use App\Models\System\UserRole;
use App\Models\System\UserRolePermission;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class SyncModelsToDatabase extends Command
{
    protected $signature = 'sync:models';
    protected $description = 'Sync all models to the database and update permissions';

    public function handle()
    {
        // Sinhronizacija modela
        $models = $this->syncModels();

        // Brisanje zastarelih modela
        $this->deleteObsoleteModels($models);

        // Ažuriranje permissions tabele
        $this->syncPermissions($models);

        $this->info('Model synchronization and permissions update completed!');
    }

    private function syncModels()
    {
        $modelsPath = app_path('Models');
        $syncedNamespaces = [];

        $models = collect(File::allFiles($modelsPath))
            ->map(function ($file) use ($modelsPath) {
                $relativePath = str_replace($modelsPath, '', $file->getPathname());
                $className = str_replace(['/', '.php'], ['\\', ''], 'App\\Models' . $relativePath);

                if (!class_exists($className)) {
                    return null;
                }

                try {
                    $reflection = new ReflectionClass($className);

                    if (!$reflection->hasProperty('description')) {
                        return null;
                    }

                    $property = $reflection->getProperty('description');
                    $property->setAccessible(true);
                    $description = $property->getValue(new $className);

                    if (empty($description)) {
                        return null;
                    }

                    return [
                        'namespace' => $className,
                        'description' => $description,
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter();

        foreach ($models as $model) {
            $modelEntry = ModelList::updateOrCreate(
                ['model_namespace' => $model['namespace']],
                ['model_description' => $model['description']]
            );

            $syncedNamespaces[] = $modelEntry->model_namespace;
        }

        $this->info('Models synchronized to the database.');
        return $syncedNamespaces;
    }

    private function deleteObsoleteModels(array $syncedNamespaces)
    {
        $obsoleteModels = ModelList::whereNotIn('model_namespace', $syncedNamespaces)->get();

        foreach ($obsoleteModels as $obsoleteModel) {
            UserRolePermission::where('permission_model', $obsoleteModel->model_id)->delete();
            $obsoleteModel->delete();
        }

        $this->info('Obsolete models removed from database.');
    }

    private function syncPermissions(array $models)
    {
        $roles = UserRole::all();

        foreach ($roles as $role) {
            foreach ($models as $namespace) {
                $model = ModelList::where('model_namespace', $namespace)->first();

                if ($model) {
                    // Provera da li već postoje permisije za dati model i ulogu
                    $existingPermission = UserRolePermission::where('permission_role', $role->role_index)
                        ->where('permission_model', $model->model_id)
                        ->first();

                    if ($existingPermission) {
                        // Ako postoje, preskoči ažuriranje
                        $this->info("Permissions for model {$namespace} and role {$role->role_index} already exist. Skipping...");
                        continue;
                    }

                    // Kreiranje permisija samo ako ne postoje
                    UserRolePermission::create([
                        'permission_role' => $role->role_index,
                        'permission_model' => $model->model_id,
                        'permission_permissions' => [], // Ostaviti prazno za ručno podešavanje
                    ]);
                }
            }
        }

        $this->info('Permissions table updated.');
    }
}
