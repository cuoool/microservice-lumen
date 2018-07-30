<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/07/18
	 * Time: 14.53
	 */

	namespace App\Console\Commands;

	use Illuminate\Console\Command;
	use Illuminate\Http\File;
	use Illuminate\Support\Facades\Storage;

	class CreateApiController extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "create:api_controller";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create api controller files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$post = null;

			$version = $this->ask('Version api? (v1, v2, etc..)');
			$name = $this->ask('Name api controller?');

			$repository = $this->ask('Only name of Repository  to connect to controller? (generic path App\Repositories)');

			$var = strtolower($repository);

			$fileContents = <<<EOT
<?php

	namespace App\Api\\{$version};

	use App\Api\\{$version}\ApiBaseController;
	use App\Repositories\\{$repository}Repository as {$repository};
	use Illuminate\Http\Request;
	use App\Transformers\\{$repository}Transformer;

	class {$name}Controller extends ApiBaseController
	{
		
		private \${$var};
		
		public function __construct({$repository} \${$var})
		{
			\$this->{$var} = \${$var};
		}
		
		
		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all item.
		 *
		 * @Get url
		 * @Versions 
		 * @Response 
		 */
		public function index() {}

		/**
		 * Show
		 *
		 * Get a JSON representation of item.
		 *
		 * @Get url
		 * @Versions 
		 * @Request 
		 * @Response 
		 */
		public function show(\$id) {}


		/**
		 * Create
		 *
		 * Get a JSON representation of item .
		 *
		 * @Get /create
		 * @Versions 
		 * @Request()
		 * @Response
		 */
		public function create(Request \$request) {}

		/**
		 * Store
		 *
		 * Get a JSON representation of new item.
		 *
		 * @Post url
		 * @Versions 
		 * @Request(request)
		 * @Response
		 */
		public function store(Request \$request) {}

		/**
		 * Update
		 *
		 * Get a JSON representation of update.
		 *
		 * @Get /{id}/edit
		 * @Versions 
		 * @Request {id}
		 * @Response
		 */
		public function edit(\$id) {}

		/**
		 * Update
		 *
		 * Get a JSON representation of update.
		 *
		 * @Put /{id}
		 * @Versions 
		 * @Request (request, id)
		 * @Response
		 */
		public function update(Request \$request, \$id) {}

		/**
		 * Delete
		 *
		 * Get a JSON representation of delete
		 *
		 * @Delete /{id}
		 * @Versions version
		 * @Request {id}
		 * @Response
		 */
		public function delete(\$id) {}
	}

EOT;

			$dir_location = 'app/Api/'. $version .'/' . $name . 'Controller.php';


			$file = file_put_contents($dir_location, $fileContents);

			if ($file) {
				$this->info('Created new Api Controller ' . $name . 'Controller.php in App\Api\\'. $version .'.');
			} else {
				$this->info('Something went wrong');
			}
		}
	}