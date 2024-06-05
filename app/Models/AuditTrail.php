<?php

namespace App\Models;

use App\Models\AuditTrail as AT;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditTrail extends Model
{
    use HasFactory;


    protected $fillable = [

        'action',
        'FKUserId',
        'table_name',
        'field_name',
        'old_value',
        'new_value'

    ];

    private static function createLogEntry($table, $partId, $action, $field, $oldValue, $newValue)
    {
        $userId = Auth::id();
        AT::create([
            'action' => $action,
            'FKUserId' => $userId,
            'table_name' => $table,
            'field_name' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
        ]);
    }

    public static function logTransactionCreate($input, string $tableName, $id = null)
    {

        self::createLogEntry($tableName, $id, 'Ordered', 'all', null, 'all');

    }

    public static function logCreate($input, string $tableName, $id = null)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                self::createLogEntry($tableName, $id, 'Create', $key, null, $value);
            }
        } else {
            self::createLogEntry($tableName, $id, 'Create', 'all', null, $input);
        }
    }

    public static function logUpdate($input, string $tableName, $id, $model = null)
    {

        $sql = "SELECT * FROM " . "`" . strtolower($tableName) . "s`" . " WHERE id = " . $id;

        $result = (new AuditTrail())->sql($sql, $tableName, $id, $model);

        if ($result) {
            $oldValue = $result->getAttributes();
            array_pop($oldValue);
            array_pop($oldValue);
            array_pop($oldValue);

            foreach ($oldValue as $key => $value) {
                //skip the keys that aren't set
                if (!isset($input[$key])) {
                    continue;
                }
                self::createLogEntry($tableName, $id, 'Update', $key, $value, $input[$key]);
            }
        }
    }

    public static function logDelete(string $tableName, $id)
    {
        self::createLogEntry($tableName, $id, 'Deleted', 'all', $id, null);
    }

    public static function logRestore(string $tableName, $id)
    {
        self::createLogEntry($tableName, $id, 'Restored', 'all', null, $id);
    }

    public static function logUserRegister($table)
    {

        $lastUser = DB::table('login')->latest('id')->first();
        $id = $lastUser->id;

        self::createLogEntry($table, $id, 'Registered', 'all', null, 'LoginId = ' . $id);
    }

    public static function logUserUpdateBasic($input, $table)
    {
        //dd($input);
        //Dit pakt de ingelogde user, met het gebruiken van een foreign key, om informatie uit te halen.
        $user = User::where('FKLoginId', Auth::user()->id)->get();
        $userInfo = $user[0]->getAttributes();
        //dd($userInfo, $input);

        //Zorgt voor dat de juiste data van de $userInfo array uit wordt gehaald.
        array_shift($userInfo);
        for($x = 0; $x <= 6; $x++) {
            array_pop($userInfo);
        }
        //Checks welke velden veranderd is, daarna naar de audit_trails tabel gestuurd.
        foreach ($userInfo as $key => $value) {
            if ($input[$key] != $value) {
                self::createLogEntry($table, Auth::id(), 'Updated User', $key, $value, $input[$key]);
            }

        }
    }

    public static function logInstructorUpdateBasic($input, $table)
    {

        //dd($input);
        //Dit pakt de ingelogde user, met het gebruiken van een foreign key, om informatie uit te halen.
        $instructorId = Instructors::where('id', intval($input['id']))->get();

        $instructorInfo = $instructorId[0]->getAttributes();

        $instructorLoginId = $instructorInfo['FKLoginId'];
        $instructorEmail = Login::where('id', $instructorLoginId)->get();
        $instructorEmail2 = $instructorEmail[0]->getAttributes();
        //Zorgt voor dat de juiste data van de $userInfo array uit wordt gehaald.
        array_shift($instructorInfo);
        array_shift($instructorInfo);
        array_pop($instructorInfo);
        array_pop($instructorInfo);
        array_pop($instructorInfo);

        //dd($instructorInfo, $input, $instructorEmail2);

        //Checks welke velden veranderd is, daarna naar de audit_trails tabel gestuurd.
        foreach ($instructorInfo as $key => $value) {
            if ($input[$key] != $value) {
                self::createLogEntry($table, Auth::id(), 'Updated User', $key, $value, $input[$key]);
            }

        }

    }
    public static function logUserDelete()
    {
        self::createLogEntry('users', Auth::user()->id, 'Deleted User', 'all', Auth::user()->id, null);
    }



    private function sql($sql, $modelName, $partId, $model = null)
    {
        $connection = app('db')->connection();
        if ($model) {
            $modelClass = 'App\\Models\\' . $model;
        } else {
            $modelClass = 'App\\Models\\Parts\\' . ucfirst($modelName);
        }
        $part = $modelClass::withTrashed()->find($partId);
        $connection->statement($sql);
        return $part;
    }

    private function sqlUser($sql)
    {
        $connection = app('db')->connection();
        $user = login::find(Auth::user()->id);
        $connection->statement($sql);
        return $user;
    }

    private function sqlUserToTable($sql) {
        return $user[0];
    }

}
