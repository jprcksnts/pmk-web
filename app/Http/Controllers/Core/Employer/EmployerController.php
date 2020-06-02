<?php

namespace App\Http\Controllers\Core\Employer;

use App\Http\Controllers\Controller;
use App\Models\Employer\Employer;
use App\Models\User\User;
use App\Models\User\UserDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployerController extends Controller
{
    public static function create($email, $password, $verify_password, $first_name, $last_name, $sex, $company_id)
    {
        $response = array();

        try {
            if ($password == $verify_password) {
                // if passwords match
                DB::beginTransaction();

                $user = new User();
                $user->email = $email;
                $user->password = $password;
                $user->user_type_id = 1;
                $user->save();

                $user_detail = new UserDetail();
                $user_detail->user_id = $user->id;
                $user_detail->first_name = $first_name;
                $user_detail->last_name = $last_name;
                $user_detail->sex = $sex;
                $user_detail->save();

                $employer = new Employer();
                $employer->company_id = $company_id;
                $employer->user_id = $user->id;
                $employer->save();

                DB::commit();

                $data = array();
                $data['user'] = $user;
                $data['user']['user_detail'] = $user_detail;
                $data['user']['employer'] = $employer;

                $response['data'] = $data;
                $response['message'] = 'Employer successfully created.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if passwords do not match
                $error = array();
                $error['message'] = 'Passwords do not match.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create employer.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create employer.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create employer.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($employer_id, $email, $password, $verify_password, $first_name, $last_name, $sex, $company_id)
    {
        $response = array();

        try {
            $employer = Employer::where('id', $employer_id)->first();

            if ($employer != null) {
                // if employer exists
                if ($password == $verify_password) {
                    // if passwords match
                    DB::beginTransaction();

                    $user = User::where('id', $employer->user_id)->first();
                    $user->email = $email;
                    $user->password = $password;
                    $user->user_type_id = 1;
                    $user->save();

                    $user_detail = UserDetail::where('user_id', $user->id)->first();
                    $user_detail->user_id = $user->id;
                    $user_detail->first_name = $first_name;
                    $user_detail->last_name = $last_name;
                    $user_detail->sex = $sex;
                    $user_detail->save();

                    $employer->company_id = $company_id;
                    $employer->user_id = $user->id;
                    $employer->save();

                    DB::commit();

                    $data = array();
                    $data['user'] = $user;
                    $data['user']['user_detail'] = $user_detail;
                    $data['user']['employer'] = $employer;

                    $response['data'] = $data;
                    $response['message'] = 'Employer successfully updated.';
                    $response['status_code'] = Response::HTTP_OK;
                } else {
                    // if passwords do not match
                    $error = array();
                    $error['message'] = 'Passwords do not match.';

                    $response['error'] = $error;
                    $response['message'] = 'Failed to update employer.';
                    $response['status_code'] = Response::HTTP_BAD_REQUEST;
                }
            } else {
                // if employer does not exist
                $error = array();
                $error['message'] = 'Employer not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update employer.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to update employer.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to update employer.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($employer_id)
    {
        $response = array();

        try {
            $employer = Employer::where('id', $employer_id)->first();

            if ($employer != null) {
                // if employer exists
                DB::beginTransaction();

                $user = User::where('id', $employer->user_id)->first();
                $user_detail = UserDetail::where('user_id', $user->id)->first();

                $employer->delete();
                $user_detail->delete();
                $user->delete();

                DB::commit();

                $response['message'] = 'Employer successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if employer does not exist
                $error = array();
                $error['message'] = 'Employer not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete employer.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to delete employer.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to delete employer.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
