<?php

namespace App\Http\Controllers\Core\JobPost;

use App\Http\Controllers\Controller;
use App\Models\JobPost\JobPost;
use App\Models\JobPost\JobPostApplication;
use App\Models\JobPost\JobPostApplicationStatus;
use App\Models\JobPost\JobPostStatus;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    public static function create($employer_id, $position, $description, $max_applicants)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $job_post = new JobPost();
            $job_post->employer_id = $employer_id;
            $job_post->position = $position;
            $job_post->description = $description;
            $job_post->max_applicants = $max_applicants;
            $job_post->job_post_status_id = JobPostStatus::$OPEN;
            $job_post->save();

            DB::commit();

            $data = array();
            $data['job_post'] = $job_post;
            $response['data'] = $data;
            $response['message'] = 'Job post successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create job post.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create job post.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($job_post_id, $employer_id, $position, $description, $max_applicants)
    {
        $response = array();

        try {
            $job_post = JobPost::where('id', $job_post_id)->first();

            if ($job_post != null) {
                // job post exists
                DB::beginTransaction();

                $job_post_applicant_count = JobPostApplication::where('job_post_id', $job_post_id)
                    ->whereNotIn('job_post_application_status_id', [JobPostApplicationStatus::$CANCELLED, JobPostApplicationStatus::$REJECTED, JobPostApplicationStatus::$RETRACTED_JOB_OFFER])
                    ->count();
                if ($job_post_applicant_count <= $max_applicants) {
                    // if max applicants is within valid range (cannot be less than current job applicants)
                    $job_post->employer_id = $employer_id;
                    $job_post->position = $position;
                    $job_post->description = $description;
                    $job_post->max_applicants = $max_applicants;
                    $job_post->job_post_status_id = JobPostStatus::$OPEN;
                    $job_post->save();

                    DB::commit();

                    $data = array();
                    $data['job_post'] = $job_post;

                    $response['data'] = $data;
                    $response['message'] = 'Job post successfully updated.';
                    $response['status_code'] = Response::HTTP_OK;
                } else {
                    // if max applicants is lower than currently approved applicants
                    $error = array();
                    $error['message'] = 'Number of max applicants cannot be lower than currently approved applicants.';

                    $response['error'] = $error;
                    $response['message'] = 'Failed to update job post.';
                    $response['status_code'] = Response::HTTP_BAD_REQUEST;
                }
            } else {
                // job post does not exist
                $error = array();
                $error['message'] = 'Job post not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update job post.';
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
            $response['message'] = 'Failed to update job post.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update job post.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($job_post_id)
    {
        $response = array();

        try {
            $job_post = JobPost::where('id', $job_post_id)->first();

            if ($job_post != null) {
                // if job post exists
                DB::beginTransaction();

                $job_post->delete();

                DB::commit();

                $response['message'] = 'Job post successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if job post does not exist
                $error = array();
                $error['message'] = 'Job post not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete job post.';
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
            $response['message'] = 'Failed to delete job post.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to delete job post.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function filterMaxedOutApplications($job_posts)
    {
        foreach ($job_posts as $index => $job_post) {
            $job_post_applications = $job_post->jobPostApplications;

            $max_applicants = $job_post->max_applicants;
            $applicants_count = 0;
            foreach ($job_post_applications as $job_post_application) {

                if ($job_post_application->job_post_application_status_id == JobPostApplicationStatus::$CANCELLED || $job_post_application->job_post_application_status_id == JobPostApplicationStatus::$REJECTED || $job_post_application->job_post_application_status_id == JobPostApplicationStatus::$RETRACTED_JOB_OFFER) {
                } else {
                    $applicants_count++;
                }
            }

            if ($applicants_count >= $max_applicants) {
                $job_posts->forget($index);
            }
        }

        return $job_posts;
    }
}
