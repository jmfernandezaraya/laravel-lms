<?php

namespace App\Http\Livewire\SchoolAdmin;

use App\Models\SuperAdmin\SendSchoolMessage;
use Livewire\Component;

/**
 * Class NotificationMessages
 * @package App\Http\Livewire\SchoolAdmin
 */
class NotificationMessages extends Component
{
    public $aria_hidden = "aria-expanded=false", $show = "";

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $check_messages = $data['count'] = SendSchoolMessage::where('user_id', auth()->id());
        $data['messages'] = $check_messages->get();

        return view('livewire.school-admin.notification-messages', $data);
    }

    /**
     * @return bool
     */
    public function updateMessageSeen()
    {
        $set_status = SendSchoolMessage::where(['user_id' => auth()->id(), 'seen' => 0])->get();
        if ($set_status->isNotEmpty()) {
            foreach ($set_status as $status) {
                $status->seen = 1;
                $status->save();
            }
            $this->aria_hidden = "aria-expanded=true";
            $this->show = "show";
        }

        return true;
    }
}