<?php
namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class CompanyController extends Controller
{

    public function index()
    {
        $companies= Company::all();
        return view('company.index', compact('companies'));
    }

  
    public function create(Request $request)
    {
        
        $company = Company::create(

            [ 
                'name' => $request->company,
                'user_id' => $request->user_id,
            ]
            );
            
            try{
                // $new_connection = 'new';
                // $nc = \Illuminate\Support\Facades\Config::set('database.connec‌​tions.' . $new_connect‌​ion, [
                //     'driver'   => 'mysql',
                //     'host'     => 'localhost',
                //     'database' => $dbName,
                //     'username' => 'root',
                //     'password' => '',
                // ]);
                

                $new_db_name = 'olaccounts_'.$request->company;
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
                // $artisan    =   Artisan::call('migrate', array('--database' => $request->company,'--path' => 'database/migrations', '--force' => true));
                // if($artisan){
                //     return 'Database created successfully with name '.$new_db_name;

                // }else{
                //     return 'error while artisan command ';   
                // }
               
            }
            
            catch(\Exception $e){
                return 'Error '.$e->getLine()." ".$e->getMessage(); 
                return false;
            } 
            
            
        return redirect()->back()->with('success', 'Company created successfully!');
    }

    public function store(Request $request)
    {
       
            $validator = \Validator::make(
                $request->all(), [
                                  'name' => 'required',
                              ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $company             = new Company();
            $company->name       = $request->name;
            $company->save();
            // return $company;

            return redirect()->route('company.index')->with('success', __('Company successfully created.'));
        
      
    }


    public function show(Company $company)
    {
        $company = Company::all();
        return view('company.index', compact('company'));
        
    }


    public function edit($id)
    {
        $company = Company::find($id);

        return view('company.edit', compact( 'company'));

    }


    public function update(Request $request, Company $company,$id)
    {
        $company = Company::where('id',$id)->update([
            'name' => $request->company,
        ]);  
        return redirect()->route('company-manage')->with('success', __('Company Name Updated.Successfully!'));
    
    }


   
    public function destroy(Company $company,$id)
    {
            $company = Company::destroy(array('id',$id));
            return redirect()->back()->with('success', __('Company Deleted Successfully'));
    }

}