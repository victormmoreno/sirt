<?php

namespace App\Http\Traits\User;

use App\Notifications\User\CompleteTalentInformation;
use App\Values\OfficerStorageValues;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait MustCompleteOfficerInformation
{
    /**
     * Determine if the user has completed information officer.
     *
     * @return bool
     */
    public function hasCompletedOfficerInformation()
    {
        return ! is_null($this->informacion_user_completed_at) && ! is_null($this->informacion_user);
    }

    /**
     * Mark the given user's information officer as completed.
     *
     * @return bool
     */
    public function markInformationOfficerAsCompleted()
    {
        return $this->forceFill([
            'informacion_user_completed_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * save information officer.
     *
     */
    public function saveInformationOfficer(Request $request = null)
    {
        if(
            !is_null($request) &&
            isset($request->roles)
            // is_null($this->informacion_user_completed_at)
            )
        {
            $officeStorageClass = OfficerStorageValues::OFFICER[$request->role];


            return (new $officeStorageClass)->buildStorageRecord($request);




            // $this->update(['informacion_user' => $structures]);

            // $this->markInformationOfficerAsCompleted();
        }
    }

    /**
     * Send the email information officer notification.
     *
     * @return void
     */
    public function sendEmailToCompleteOfficerInformation()
    {
        return;// $this->notify(new CompleteOfficerInformation);
    }


    public function getInformationOfficerBuilder()
    {
        // if(isset($this->informacion_user["talento"])){
        //     $talentType = Str::snake(Str::lower($this->informacion_user["talento"]["tipo_talento"]));
        //     $talentStorageClass = OfficerStorageValues::OFFICER[$talentType];
        //     return (new $talentStorageClass)->buildResponse($this->informacion_user);
        // }
    }

    public function getInformationOfficerEloquent()
    {
        return;
    }
}
