<?php

namespace App\Http\Controllers\Core\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationType;

class NotificationController extends Controller
{
    public static function createNotification($sender_id, $recipient_id, $notification_type_id, $notification_message, $custom_notification_title = null)
    {
        $notification = new Notification();
        $notification->sender_id = $sender_id;
        $notification->recipient_id = $recipient_id;
        $notification->notification_type_id = $notification_type_id;
        $notification->title = ($custom_notification_title != null) ? $custom_notification_title : self::getGenericNotificationTitle($notification_type_id);
        $notification->message = $notification_message;
        $notification->save();
    }

    protected static function getGenericNotificationTitle($notification_type_id)
    {
        if ($notification_type_id == NotificationType::$JOB_APPLICATION_NEW) {
            return 'New Job Applicant';
        } else if ($notification_type_id == NotificationType::$JOB_APPLICATION_UPDATE) {
            return 'Job Application Update';
        } else if ($notification_type_id == NotificationType::$JOB_OFFER_RECEIVED) {
            return 'New Job Offer';
        } else if ($notification_type_id == NotificationType::$JOB_OFFER_ACCEPTED) {
            return 'Job Offer Accepted';
        } else if ($notification_type_id == NotificationType::$JOB_OFFER_DECLINED) {
            return 'Job Offer Declined';
        } else {
            return '';
        }
    }
}
