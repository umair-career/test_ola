<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DatabaseInfo;
use  App\Models\Utility;
use Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */



  public function __construct()
    {
        $this->middleware('guest');
    }


    public function create()
    {
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //ReCpatcha
        if(env('RECAPTCHA_MODULE') == 'yes')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string',
                         'min:8','confirmed', Rules\Password::defaults()],
        ]);



        $user = User::create([
            
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
             'type' => 'company',
             'default_pipeline' => 1,
              'plan' => 1,
              'lang' => Utility::getValByName('default_language'),
               'avatar' => '',
               'created_by' => 1,
        ]);
        $database = DatabaseInfo::create([
            'user_id' => 1,
            'db_name' => $request->name,
            'db_password' => Hash::make($request->password),
        ]);
        
       

        $role_r = Role::findByName('company');
        $user->assignRole($role_r);
        Utility::chartOfAccountTypeData($user->id);
        Utility::chartOfAccountData($user);
        Utility::pipeline_lead_deal_Stage($user->id);
        Utility::project_task_stages($user->id);
        Utility::labels($user->id);
        Utility::sources($user->id);
        Utility::jobStage($user->id);

        event(new Registered($user));
        
        try{
            $new_db_name = 'olaaccounts_'.$request->name;
            $new_mysql_username = "root";
            $new_mysql_password = "";
          
            
            $conn = mysqli_connect(
                config('database.connections.mysql.host'), 
                env('DB_USERNAME'), 
                env('DB_PASSWORD')
            );
            if(!$conn ) {
                return false;
            }
            $sql = 'CREATE Database IF NOT EXISTS '.$new_db_name;
            $exec_query = mysqli_query( $conn, $sql);
            if(!$exec_query) {
                die('Could not create database: ' . mysqli_error($conn));
                
            }
            $bool= DBConnection($new_db_name);
         

            $artisan    =   Artisan::call('migrate', array('--database' => $new_db_name,'--path' => 'database/migrations', '--force' => true));
            if($artisan){
                return 'Database created successfully with name '.$new_db_name;

            }else{
                return 'error while artisan command ';   
            }               
        }
        
        catch(\Exception $e){
            return 'Error '.$e->getLine()." ".$e->getMessage(); 
            return false;
        } 

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

 public function showRegistrationForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);


        return view('auth.register', compact('lang'));
    }

}
