<?php

namespace App\Http\Controllers\Core\JobPost;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Notification\NotificationController;
use App\Models\JobPost\JobPost;
use App\Models\JobPost\JobPostApplication;
use App\Models\JobPost\JobPostApplicationStatus;
use App\Models\Notification\NotificationType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobPostApplicationController extends Controller
{
    public static function create($job_post_id, $employee_id)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $job_post = JobPost::where('id', $job_post_id)->first();
            $job_post_applicant_count = JobPostApplication::where('job_post_id', $job_post_id)
                ->whereNotIn('job_post_application_status_id', [JobPostApplicationStatus::$CANCELLED, JobPostApplicationStatus::$REJECTED, JobPostApplicationStatus::$RETRACTED_JOB_OFFER])
                ->count();

            if ($job_post->max_applicants > $job_post_applicant_count) {
                $job_post_application = new JobPostApplication();
                $job_post_application->job_post_id = $job_post_id;
                $job_post_application->employee_id = $employee_id;
                $job_post_application->job_post_application_status_id = JobPostApplicationStatus::$PENDING;
                $job_post_application->save();

                $sender_id = $job_post_application->employee->user->id;
                $recipient_id = $job_post_application->jobPost->employer->user->id;
                $applicant_name = $job_post_application->employee->user->userDetail->name();
                $job_post_title = $job_post_application->jobPost->position;
                NotificationController::createNotification($sender_id, $recipient_id, NotificationType::$JOB_APPLICATION_NEW, "New job applicant ($applicant_name) for the job post $job_post_title");

                DB::commit();

                $data = array();
                $data['job_post_application'] = $job_post_application;

                $response['data'] = $data;
                $response['message'] = 'Job post application successfully created.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                $error = array();
                $error['message'] = 'Max applicants for the job posting has been reached.';

                $response['error'] = $error;
                $response['message'] = 'Failed to submit job post application.';
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
            $response['message'] = 'Failed to submit job post application.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to submit job post application.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($job_post_application_id, $job_post_application_status_id = null)
    {
        $response = array();

        try {
            $job_post_application = JobPostApplication::where('id', $job_post_application_id)->first();

            if ($job_post_application != null) {
                // if job post application exists
                DB::beginTransaction();

                // TODO :: Add validation to prevent adding more applicants if max (approved) applicants has been reached
                if ($job_post_application_status_id != null) {
                    $job_post_application->job_post_application_status_id = $job_post_application_status_id;
                }

                $job_post_application->save();

                if ($job_post_application_status_id == JobPostApplicationStatus::$UNDER_REVIEW) {
                    $sender_id = $job_post_application->jobPost->employer->user->id;
                    $recipient_id = $job_post_application->employee->user->id;
                    $position_title = $job_post_application->jobPost->position;
                    NotificationController::createNotification($sender_id, $recipient_id, NotificationType::$JOB_OFFER_RECEIVED, "You have been placed under review for the job post $position_title");
                }

                DB::commit();

                $data = array();
                $data['job_post_application'] = $job_post_application;

                $response['data'] = $data;
                $response['message'] = 'Job post application successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if job post application does not exist
                $error = array();
                $error['message'] = 'Job post application not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update job post application.';
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
            $response['message'] = 'Failed to update job post application.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update job post application.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function updateEmployeeApplicationStatus($job_post_application_id, $employee_id, $job_post_application_status_id)
    {
        $response = array();

        try {
            $job_post_application = JobPostApplication::where('id', $job_post_application_id)
                ->where('employee_id', $employee_id)->first();

            if ($job_post_application != null) {
                // if employee job post application exists
                DB::beginTransaction();

                $job_post_application->job_post_application_status_id = $job_post_application_status_id;
                $job_post_application->save();

                DB::commit();

                $data = array();
                $data['job_post_application'] = $job_post_application;

                $response['data'] = $data;
                $response['message'] = 'Job post application successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if employee job application does not exist
                $error = array();
                $error['message'] = 'Employee job application not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update job post application.';
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
            $response['message'] = 'Failed to update job post application.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update job post application.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($job_post_application_id)
    {
        $response = array();

        try {
            $job_post_application = JobPostApplication::where('id', $job_post_application_id)->first();

            if ($job_post_application != null) {
                // if job post application exists
                DB::beginTransaction();

                $job_post_application->delete();

                DB::commit();

                $response['message'] = 'Job post application successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if job post application does not exist
                $error = array();
                $error['message'] = 'Job post application not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete job application.';
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
            $response['message'] = 'Failed to delete job post application.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to delete job post application.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
