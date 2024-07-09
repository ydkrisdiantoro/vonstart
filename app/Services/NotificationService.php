<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{

    /**
     * Rule Validation Data
     * @return array $rules_validation_data
     */
    public function rules()
    {
        return [
            'menu_id' => ['required','string','min:36','max:36'],
            'notification' => ['required','string'],
            'is_read' => ['required','integer','in:0,1'],
        ];
    }

    /**
     * Get Notification
     * @param uuid $notificationId optional
     * @return collection from find() or get()
     */
    public function getNotification($notificationId = null, $paginate = null)
    {
        if($notificationId != null){
            $data = Notification::orderBy('created_at', 'desc')->find($notificationId);
        } else{
            if ($paginate === null) {
                $data = Notification::orderBy('created_at', 'desc')->get();
            } else{
                $data = Notification::orderBy('created_at', 'desc')->paginate($paginate);
            }
        }
        return $data;
    }

    /**
     * Create Notification
     * @param array $datas
     * @return collection return from save()
     */
    public function create($datas)
    {
        $notifications = (new Notification)->fill($datas);
        if($notifications->save()){
            return $notifications;
        } else{
            return false;
        }
    }

    /**
     * Update Notification by Id
     * @param uuid $notificationId
     * @param array $datas
     * @return collection return from update()
     */
    public function update($notificationId, $datas)
    {
        return Notification::find($notificationId)->update($datas);
    }

    /**
     * Delete Notification
     * @param uuid $notificationId
     * @return collection from delete()
     */
    public function delete($notificationId)
    {
        return Notification::find($notificationId)->delete();
    }
}
