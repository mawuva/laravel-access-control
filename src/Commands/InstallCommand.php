<?php

namespace Mawuekom\Accontrol\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Mawuekom\Accontrol\AccontrolServiceProvider;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'accontrol:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Accontrol package.';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * Seed Folder name.
     *
     * @var string
     */
    protected $seedFolder;

    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());
    }
    
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
            //['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Publishing the Custom User database, and config files');

        $this->call('vendor:publish', ['--provider' => AccontrolServiceProvider::class]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force']);

        $this->info('Attempting to set update User model');

        if (file_exists(app_path('User.php')) || file_exists(app_path('Models/User.php'))) {
            $userPath = file_exists(app_path('User.php')) ? app_path('User.php') : app_path('Models/User.php');

            $str = file_get_contents($userPath);

            if ($str !== false) {
                if (!str_contains($str, "use Laravel\Sanctum\HasApiTokens;\nuse Mawuekom\Accontrol\Assignables\HasRoleAndPermission;")) {
                    $str = str_replace('use Laravel\Sanctum\HasApiTokens;', "use Laravel\Sanctum\HasApiTokens;\nuse Mawuekom\Accontrol\Assignables\HasRoleAndPermission;", $str);
                }

                $start = strpos($str, 'use HasApiTokens');
                $end = strpos($str, ', Notifiable') - $start;
                $lengthToAdd = strlen(', Notifiable');
                $toSearch = substr($str, $start, $end+$lengthToAdd);

                if (!str_contains($str, $toSearch . ', HasRoleAndPermission')) {
                    $str = str_replace($toSearch, $toSearch . ', HasRoleAndPermission', $str);
                }

                file_put_contents($userPath, $str);
            }
        }

        else {
            $this->warn('Unable to locate "User.php" in app or app/Models.  Did you move this file?');
            $this->warn('You will need to update this manually.  Add "\Mawuekom\CustomUser\Traits\UserCustomization" to your trait using in your User model');
        }

        $this->info('Dumping the autoloaded files and reloading all new files');
        $this->composer->dumpAutoloads();
        require_once base_path('vendor/autoload.php');

        $this->info('Seeding data into the database');
        $this->call('db:seed', ['--class' => 'ActionsTableSeeder']);
        $this->call('db:seed', ['--class' => 'EntitiesTableSeeder']);
        $this->call('db:seed', ['--class' => 'RolesTableSeeder']);
        $this->call('db:seed', ['--class' => 'PermissionsTableSeeder']);
        $this->call('db:seed', ['--class' => 'ConnectRelationshipsSeeder']);
        $this->call('db:seed', ['--class' => 'UsersTableSeeder']);

        $this->info('Successfully installed Accontrol ! Enjoy');
    }
}