<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class link to model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $repositoryName = $this->argument('repository');
        $this->line("Creating repository {$repositoryName} ...");
        if (!File::exists("app/Repositories"))
            File::makeDirectory("app/Repositories",0775,true);

        if (!File::exists("app/Repositories/Interfaces"))
            File::makeDirectory("app/Repositories/Interfaces",0775,true);

        if (!File::exists("app/Repositories/Interfaces/RepositoryInterface.php")){
            $schema = $this->schemaFileRepositoryInterface();
            File::put("app/Repositories/Interfaces/RepositoryInterface.php",$schema);
        }
        if (!File::exists("app/Repositories/BaseRepository.php")){
            $schemaExtends = $this->schemaFileRepositoryExtends();
            File::put("app/Repositories/BaseRepository.php",$schemaExtends);
        }
        if(!File::exists("app/Repositories/{$repositoryName}.php")){
            $schema = $this->schemaFileRepository($repositoryName);
            File::put("app/Repositories/{$repositoryName}.php",$schema);
        }
        $this->info("The repository with name {$repositoryName} was created successfully");
    }

    /**
     * @return string
     */
    private function schemaFileRepositoryInterface(): string
    {
        return
            '<?php namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function save(array $data, array $attributes);

    public function delete($id);

    public function getById($id);

    public function filterIn(string $field, array $data);

    public function getBy(array $attributes);

    public function filterBy(array $data): Collection;

}';

    }

    /**
     * @return string
     */
    private function schemaFileRepositoryExtends(): string
    {
        return
            '<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\{RepositoryInterface};

class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model table
     */
    private Model $_repository;

    public function __construct(Model $model)
    {
        $this->setRepository($model);
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
        return $this->repository->all();
    }

    public function save(array $data, array $attributes): ?Model
    {
        // TODO: Implement create() method.
        return $this->repository->updateOrCreate($data,$attributes);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->repository->find($id)->delete();
    }

    public function getById($id): ?Model
    {
        // TODO: Implement find() method.
        return $this->repository->find($id);
    }

    public function filterIn(string $field, array $data): ?Collection
    {
        // TODO: Implement filterIn() method.
        return $this->repository->whereIn($field, $data)->get();
    }

    public function getBy(array $attributes): ?Model
    {
        // TODO: Implement filterIn() method.
        return $this->repository->firstWhere($attributes);
    }

    public function filterBy(array $data): Collection
    {
        // TODO: Implement filters() method.
        return $this->repository->where($data)->get();
    }

    protected function setRepository(Model $model): BaseRepository
    {
        // TODO: Implement setRepository() method.
        $this->_repository = $model;
        return $this;
    }

    protected function getRepository(): ?Model
    {
        // TODO: Implement getRepository() method.
        return $this->_repository;
    }

}';
    }

    /**
     * @param string $repositoryName
     * @return string
     */
    private function schemaFileRepository(string $repositoryName): string
    {
        $entityName = Str::of($repositoryName)->replace("Repository","");
        return
            '<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\{'.$entityName.'};

class '.$repositoryName.' extends BaseRepository
{

    /**
     * Construct '.$repositoryName.' class
     */
    public function __construct()
    {
        parent::__construct(new '.$entityName.');
    }

    /**
     * @return mixed
     */
    public function getAllQuery(): mixed
    {
        return $this->getRepository()
            ->query()
            ->when(\request("key"), function ($query){
                return $query->where("key",\request("key"));
            })
            ->when(\request("status"), function ($query){
                return $query->where("status",\request()->boolean("status"));
            })
            ->get();
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    protected function saveRepository(array $attributes): ?Model
    {
        return $this->save([
            "key" => $attributes["key"]
        ],$attributes);
    }

    /**
     * @param array $attributes
     * @param string $id
     * @return Model|null
     */
    protected function updateRepository(array $attributes,string $id): ?Model
    {
        return $this->save([
            "id" => $id
        ],$attributes);
    }

}';
    }
}
